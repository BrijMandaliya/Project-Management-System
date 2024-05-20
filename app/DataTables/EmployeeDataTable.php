<?php

namespace App\DataTables;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class EmployeeDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($raw) {
                $actionrow =  '<div class="dropdown">
                <a type="button" style="font-size:15px;margin:10px;" id="threeDotMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    &#8942;
                </a>
                <div class="dropdown-menu h-auto action-option" aria-labelledby="threeDotMenu" style="min-width:5%;">';
                if (Session("admin") || strpos(Session('Employee')->permissions, 'Update Employee') !== false) {
                    $actionrow .= '<a class="dropdown-item editbtn btn btn-icon-text" href="/employee/editemployee/' . $raw->id . '" id="editbtn"  data-id="' . $raw->id . '">Edit <i class="typcn typcn-edit btn-icon-append"></i></a>';
                }
                if (Session("admin") || strpos(Session('Employee')->permissions, 'Delete Employee') !== false) {
                    $actionrow .= '<a class="dropdown-item deletebtn btn btn-icon-text" id="deletebtn" data-id="' . $raw->id . '">Delete <i class="typcn typcn-delete-outline btn-icon-append"></i></a>';
                }
                $actionrow .= '</div></div>';

                return $actionrow;
            })
            ->addColumn('Role', function ($model) {
                return $model->employee_role->role_title;
            })
            ->filterColumn('Role', function ($query, $keyword) {
                $query->whereHas('employee_role', function ($q) use ($keyword) {
                    $q->where('role_title', 'like', "%{$keyword}%");
                });
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Employee $model): QueryBuilder
    {
        return $model->with('employee_role')->where("user_id",Session::has("admin") ? Session::get("admin")->id : Session::get("Employee")->user_id)->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('employee-table')
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
            Column::make('emp_name'),
            Column::make('emp_email'),
            Column::make('emp_code'),
            Column::make('emp_address'),
            Column::make('emp_country'),
            Column::make('emp_profile_image'),
            Column::make('emp_gender'),
            Column::make('emp_DOB'),
            Column::make('created_at'),
            Column::make('updated_at'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Employee_' . date('YmdHis');
    }
}
