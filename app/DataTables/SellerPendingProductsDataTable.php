<?php

namespace App\DataTables;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SellerPendingProductsDataTable extends DataTable
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
              $editBtn = "<a href='".route('admin.product.edit', $query->id)."' class='btn btn-primary'><i class='far fa-edit'></i></a>";
              $deleteBtn = "<a href='".route('admin.product.destroy', $query->id)."' data-tableId='product-table' class='btn btn-danger ml-2 mr-1 delete-item'><i class='far fa-trash-alt'></i></a>";
              $moreBtn = '<div class="dropdown dropleft d-inline">
              <button class="btn btn-primary " type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-cog"></i>
              </button>
              <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 28px, 0px); top: 0px; left: 0px; will-change: transform;">
                <a class="dropdown-item has-icon" href="'.route('admin.product-image-gallery.index', ['product' => $query->id]).'"><i class="far fa-heart"></i> Image Gallery</a>
                <a class="dropdown-item has-icon" href="'.route('admin.product-variant.index', ['product' => $query->id]).'"><i class="far fa-file"></i> Variants</a>
              </div>
            </div>';
              return $editBtn.$deleteBtn.$moreBtn;
            })
            ->addColumn('image', function($query) {
              return '<img width="70px" src="'.asset($query->thumb_image).'"/>';
            })
            ->addColumn('type', function($query) {
              switch ($query->product_type) {
                case 'new_arrival':
                  return '<i class="badge badge-success">New Arrival</i>';
                  break;

                case 'featured_product':
                  return '<i class="badge badge-warning">Featured Product</i>';
                  break;

                case 'top_product':
                  return '<i class="badge badge-info">Top Product</i>';
                  break;

                case 'best_product':
                  return '<i class="badge badge-danger">Best Product</i>';
                  break;

                default:
                return '<i class="badge badge-dark">None</i>';
                  break;
              }
            })
            ->addColumn('status', function($query) {
              if($query->status == 1) {
                $button = ' <label class="custom-switch mt-2">
                              <input type="checkbox" data-id="'.$query->id.'" checked name="custom-switch-checkbox" class="custom-switch-input change-status">
                              <span class="custom-switch-indicator"></span>
                            </label>';
              } else {
                $button = ' <label class="custom-switch mt-2">
                              <input type="checkbox" data-id="'.$query->id.'" name="custom-switch-checkbox" class="custom-switch-input change-status">
                              <span class="custom-switch-indicator"></span>
                            </label>';
              }
              return $button;
            })
            ->addColumn('vendor', function($query) {
              return $query->vendor->name;
            })
            ->addColumn('approve', function($query) {
              return "<select class='form-control is_approved' data-id='$query->id' style='height: 34px; padding: 0 0 0 4px; width: 75%'>
                        <option selected value='0'>Pending</option>
                        <option value='1'>Approved</option>
                      </select>";

            })
            ->rawColumns(['image', 'type', 'status', 'approve', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Product $model): QueryBuilder
    {
        return $model->where('is_approved', 0)->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('sellerpendingproducts-table')
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
            Column::make('id')->width(100),
            Column::make('image')->width(250),
            Column::make('name'),
            Column::make('vendor'),
            Column::make('price'),
            Column::make('type')->width(200),
            Column::make('status'),
            Column::make('approve')->width(150),
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
        return 'SellerPendingProducts_' . date('YmdHis');
    }
}
