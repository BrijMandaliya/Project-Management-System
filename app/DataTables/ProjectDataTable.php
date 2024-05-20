<?php

namespace App\DataTables;

use App\Models\Employee;
use App\Models\Project;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Str;

class ProjectDataTable extends DataTable
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
                <div class="dropdown-menu h-auto action-option" aria-labelledby="threeDotMenu" style="min-width:5%;"> ';
                if (Session::has("admin") || strpos(Session('Employee')->permissions, 'Update Project') !== false) {
                    $actionrow .= '<a class="dropdown-item editbtn btn btn-icon-text" id="editbtn"  data-id="' . $raw->id . '">Edit <i class="typcn typcn-edit btn-icon-append"></i></a>';
                }
                if (Session::has("admin") || strpos(Session('Employee')->permissions, 'Delete Project') !== false) {
                    $actionrow .= '<a class="dropdown-item deletebtn btn btn-icon-text" id="deletebtn" data-id="' . $raw->id . '">Delete <i class="typcn typcn-delete-outline btn-icon-append"></i></a>';
                }
                $actionrow .= '</div>
            </div>';

                return $actionrow;
            })
            ->addColumn('EmployeesName', function ($model) {
                $employee = Employee::all();
                $employees = "";
                foreach ($employee as $key => $value) {
                    if (Str::contains($model->employees, $value->id)) {
                        $employees .= $value->emp_name . ",";
                    }
                }
                return substr($employees, 0, -1);
            })
            ->addColumn("ProjectUploadEmployee", function ($model) {
                return $model->employee->emp_name;
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Project $model): QueryBuilder
    {
        return $model->with("employee")
        ->where("user_id",Session::has("admin") ? Session::get("admin")->id : 0)
        ->orWhereRaw("FIND_IN_SET(?,employees)",[Session::has("Employee")?Session::get("Employee")->id:0])
        ->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('project-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
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
            Column::make('project_code'),
            Column::make('project_name'),
            Column::make('project_deadline'),
            Column::make('project_startDate'),
            Column::make('project_payout'),
            Column::make('status'),
            Column::make('created_at'),
            Column::make('updated_at'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Project_' . date('YmdHis');
    }
}
