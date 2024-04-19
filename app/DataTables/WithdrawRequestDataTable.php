<?php

namespace App\DataTables;

use App\Models\WithdrawRequest;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class WithdrawRequestDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function($query) {
              $showBtn = "<a href='".route('admin.withdraw-list.show', $query->id)."' class='btn btn-primary'><i class='far fa-eye'></i></a>";

              return $showBtn;
            })
            ->addColumn('vendor', function($query) {
              return $query->vendor->name;
            })
            ->addColumn('total_amount', function($query) {
              return getCurrencyIcon().$query->total_amount;
            })
            ->addColumn('withdraw_amount', function($query) {
              return getCurrencyIcon().$query->withdraw_amount;
            })
            ->addColumn('withdraw_charge_amount', function($query) {
              return getCurrencyIcon().$query->withdraw_charge;
            })
            ->addColumn('status', function($query) {
              if($query->status == 'pending') {
                return "<i class='badge badge-warning rounded-pill'>Pending</i>";
              }
              else if($query->status == 'paid') {
                return "<i class='badge badge-success rounded-pill'>Paid</i>";
              }
              else {
                return "<i class='badge badge-secondary rounded-pill'>Declined</i>";
              }
            })
            ->addColumn('request_date', function($query) {
              return date('d M Y', strtotime($query->created_at));
            })
            ->filterColumn('vendor', function($query, $keyword) {
              $query->whereHas('vendor', function($subQuery) use ($keyword) {
                $subQuery->where('name', 'like', '%'.$keyword.'%');
              });
            })
            ->rawColumns(['status', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(WithdrawRequest $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('withdrawrequest-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(0)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('vendor'),
            Column::make('method'),
            Column::make('total_amount'),
            Column::make('withdraw_amount'),
            Column::make('withdraw_charge_amount'),
            Column::make('status'),
            Column::make('request_date'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(200)
                  ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'WithdrawRequest_' . date('YmdHis');
    }
}
