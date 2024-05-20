<?php

namespace App\DataTables;

use App\Models\Permissions;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PermissionDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function($raw){
                return '<div class="dropdown">
                <a type="button" style="font-size:15px;margin:10px;" id="threeDotMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    &#8942;
                </a>
                <div class="dropdown-menu h-auto action-option" aria-labelledby="threeDotMenu" style="min-width:5%;">
                    <a class="dropdown-item editbtn btn btn-icon-text" id="editbtn" value="' . $raw->permission_title . '" data-id="' . $raw->id . '">Edit <i class="typcn typcn-edit btn-icon-append"></i></a>
                    <a class="dropdown-item deletebtn btn btn-icon-text" id="deletebtn" value="' . $raw->permission_title . '" data-id="' . $raw->id . '">Delete <i class="typcn typcn-delete-outline btn-icon-append"></i></a>
                </div>
            </div>';
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Permissions $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('permission-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1)
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
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
            Column::make('id'),
            Column::make('permission_title'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Permission_' . date('YmdHis');
    }
}
