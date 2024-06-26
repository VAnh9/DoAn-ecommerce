<?php

namespace App\DataTables;

use App\Models\BlogComment;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class BlogCommentDataTable extends DataTable
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
              $deleteBtn = "<a href='".route('admin.blog-comment.destroy', $query->id)."' data-tableId='blogcomment-table' class='btn btn-danger ml-2 delete-item'><i class='far fa-trash-alt'></i></a>";
              return $deleteBtn;
            })
            ->addColumn('blog', function($query) {
              return "<a href='".route('blog.index', $query->blog->slug)."' target='_blank'>".$query->blog->title."</a>";
            })
            ->addColumn('user_name', function($query) {
              return $query->user->name;
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
            ->rawColumns(['blog', 'status', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(BlogComment $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('blogcomment-table')
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
            Column::make('blog')->width(500),
            Column::make('user_name')->width(200),
            Column::make('comment'),
            Column::make('status'),
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
        return 'BlogComment_' . date('YmdHis');
    }
}
