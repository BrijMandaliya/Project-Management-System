<?php

namespace App\DataTables;

use App\Models\Employee;
use App\Models\Task;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Str;

class TaskDataTable extends DataTable
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
                $actionraw =  '<div class="dropdown">
                <a type="button" style="font-size:15px;margin:10px;" id="threeDotMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    &#8942;
                </a>
                <div class="dropdown-menu h-auto action-option" aria-labelledby="threeDotMenu" style="min-width:5%;">';
                if (Session::has("admin") || strpos(Session('Employee')->permissions, 'Update Task') !== false) {
                    $actionraw .= '<a class="dropdown-item editbtn btn btn-icon-text" id="editbtn" data-id="' . $raw->id . '">Edit <i class="typcn typcn-edit btn-icon-append"></i></a>';
                }
                if (Session::has("admin") || strpos(Session('Employee')->permissions, 'Delete Task') !== false) {
                    $actionraw .= '<a class="dropdown-item deletebtn btn btn-icon-text" id="deletebtn" data-id="' . $raw->id . '">Delete <i class="typcn typcn-delete-outline btn-icon-append"></i></a>';
                }
                $actionraw .= '</div></div>';
                return $actionraw;
            })
            ->addColumn('Project Name', function ($model) {
                return $model->project->project_code;
            })
            ->filterColumn('Project Name', function ($query, $keyword) {
                $query->whereHas("project", function ($q) use ($keyword) {
                    $q->where('project_code', 'Like', "%{$keyword}%");
                });
            })
            ->addColumn('Employees', function ($model) {
                $employees = '';
                foreach (Employee::all() as $key => $value) {
                    if (in_array($value->id, explode(',', $model->task_assign_to))) {
                        $employees .= $value->emp_name . ',';
                    }
                }
                return substr($employees, 0, -1);
            })
            ->addColumn('taskpostedby', function ($model) {
                return $model->posted_employee->first()->emp_name;
            })
            ->filterColumn('taskpostedby', function ($query, $keyword) {
                $query->whereHas('posted_employee', function ($q) use ($keyword) {
                    $q->where('emp_name', 'like', "%{$keyword}%");
                });
            })
            ->rawColumns(['action','Project Name','Employees','taskpostedby'])
            ->setRowId('id');
    }


    /**
     * Get the query source of dataTable.
     */
    public function query(Task $model): QueryBuilder
    {
        return $model->with('project', 'posted_employee')
            ->where(function ($query) {
                $query->whereRaw('FIND_IN_SET(?,task_assign_to)', [Session::has("Employee") ? Session::get("Employee")->id : 0])
                    ->orWhere("task_posted_by", [Session::has("Employee") ? Session::get("Employee")->id : 0])
                    ->orWhere('user_id', Session::has("admin") ? Session::get("admin")->id : 0);
            })
            ->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('task-table')
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
            Column::make('task_id'),
            Column::make('task_title'),
            Column::make('task_type'),
            Column::make('task_posted_by'),
            Column::make('task_DeadLine'),
            Column::make('task_Completed_On'),
            Column::make('task_status'),
            Column::make('created_at'),
            Column::make('updated_at'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Task_' . date('YmdHis');
    }
}
