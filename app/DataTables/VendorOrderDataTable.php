<?php

namespace App\DataTables;

use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class VendorOrderDataTable extends DataTable
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
              $showBtn = "<a href='".route('vendor.orders.show', $query->id)."' class='btn btn-primary'><i class='far fa-eye'></i></a>";

              return $showBtn;
            })
            ->addColumn('customer', function($query) {
              return $query->user->name;
            })
            ->addColumn('date', function($query) {
              return date('d-M-Y', strtotime($query->created_at));
            })
            ->addColumn('order_status', function($query) {
              $orderStatus = $query->order_status;
              switch ($orderStatus) {
                case 'pending':
                  return "<i class='badge bg-warning rounded-pill'>Pending</i>";
                  break;
                case 'processed_and_ready_to_ship':
                  return "<i class='badge bg-info rounded-pill'>Processed</i>";
                  break;
                case 'dropped_off':
                  return "<i class='badge bg-info rounded-pill'>Dropped off</i>";
                  break;
                case 'shipped':
                  return "<i class='badge bg-info rounded-pill'>Shipped</i>";
                  break;
                case 'out_for_delivery':
                  return "<i class='badge bg-primary rounded-pill'>Out for delivery</i>";
                  break;
                case 'shipping':
                  return "<i class='badge bg-primary rounded-pill'>Shipping</i>";
                  break;
                case 'delivered':
                  return "<i class='badge bg-success rounded-pill'>Delivered</i>";
                  break;
                case 'canceled':
                  return "<i class='badge bg-secondary rounded-pill'>Canceled</i>";
                  break;

                default:
                  # code...
                  break;
              }
            })
            ->addColumn('amount', function($query) {
              $total = 0;
              foreach($query->orderProducts as $product) {
                if($product->vendor_id == Auth::user()->vendor->id) {
                  $total += ($product->unit_price + $product->variant_total) * $product->qty;
                }
              }
              return $query->currency_icon.$total;
            })
            ->addColumn('product_qty', function($query) {
              return OrderProduct::where('order_id', $query->id)->where('vendor_id', Auth::user()->id)->count();
            })
            ->addColumn('payment_status', function($query) {
              if($query->payment_status == 1) {
                return "<i class='badge bg-success rounded-pill'>Completed</i>";
              }
              else return "<i class='badge bg-warning rounded-pill'>Pending</i>";
            })
            ->rawColumns(['order_status', 'action', 'payment_status'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Order $model): QueryBuilder
    {
        return $model->whereHas('orderProducts', function($query) {
          $query->where('vendor_id', Auth::user()->vendor->id);
        })->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('vendororder-table')
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
            Column::make('invoice_id'),
            Column::make('customer'),
            Column::make('date'),
            Column::make('product_qty'),
            Column::make('amount'),
            Column::make('order_status'),
            Column::make('payment_method'),
            Column::make('payment_status'),
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
        return 'VendorOrder_' . date('YmdHis');
    }
}
