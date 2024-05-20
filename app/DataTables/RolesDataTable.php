<?php

namespace App\DataTables;

use App\Models\Permissions;
use App\Models\Roles;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Str;

class RolesDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->setRowId('id')
            ->addColumn('Permissions',function($model){
               $permission =  Permissions::all();
               $permissionsData = "";
               foreach ($permission as $key => $value) {
                if(Str::contains($model->permission_id,$value->id))
                {
                    $permissionsData .= $value->permission_title . ",";
                }
               }
                return substr($permissionsData,0,-1);
            })
            ->addColumn('action', function ($raw) {
                return '<div class="dropdown">
                <a type="button" style="font-size:15px;margin:10px;" id="threeDotMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    &#8942;
                </a>
                <div class="dropdown-menu h-auto action-option" aria-labelledby="threeDotMenu" style="min-width:5%;">
                    <a class="dropdown-item editbtn btn btn-icon-text" id="editbtn" value="' . $raw->role_title . '" data-id="' . $raw->id . '">Edit <i class="typcn typcn-edit btn-icon-append"></i></a>
                    <a class="dropdown-item deletebtn btn btn-icon-text" id="deletebtn" value="' . $raw->role_title . '" data-id="' . $raw->id . '">Delete <i class="typcn typcn-delete-outline btn-icon-append"></i></a>
                </div>
            </div>';
            });
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Roles $model): QueryBuilder
    {
        return $model->newQuery()->select('id', 'role_title','permission_id');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('roles-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->selectStyleSingle();
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
            Column::make('role_title'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Roles_' . date('YmdHis');
    }
}
