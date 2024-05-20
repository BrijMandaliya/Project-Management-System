<?php

namespace App\DataTables;

use App\Models\TaskHistory;
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

class TaskHistoryDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('project_name', function ($model) {
                return $model->project->project_name;
            })
            ->filterColumn('project_name', function ($query, $keyword) {
                $query->whereHas('project', function ($q) use ($keyword) {
                    $q->where("project_name", "LIKE", "%{$keyword}%");
                });
            })
            ->addColumn('employee_name', function ($model) {
                return $model->employee->emp_name;
            })
            ->filterColumn('employee_name', function ($query, $keyword) {
                $query->whereHas('employee', function ($q) use ($keyword) {
                    $q->where("emp_name", "LIKE", "%{$keyword}%");
                });
            })
            ->addColumn('task_name', function ($model) {
                return $model->task->task_title;
            })
            ->filterColumn('task_name', function ($query, $keyword) {
                $query->whereHas('task', function ($q) use ($keyword) {
                    $q->where("task_title", "LIKE", "%{$keyword}%");
                });
            })
            ->addColumn('task_status_on', function ($model) {
                return date_format($model->created_at, "d-m-Y  h:i:s");
            })
            ->filterColumn('task_status_on', function ($query, $keyword) {
                $query->where("created_at", "LIKE", "%{$keyword}%");
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(TaskHistory $model): QueryBuilder
    {
        return $model->with('employee', 'project', 'task')
            ->where(function ($query) {
                $query->where('employee_id', Session::has("Employee") ? Session::get("Employee")->id : 0)
                    ->orWhereHas('task', function ($query) {
                        $query->whereRaw('FIND_IN_SET(?,task_assign_to)', [Session::has("Employee") ? Session::get("Employee")->id : 0]);
                    })
                    ->orWhereHas('task', function ($query) {
                        $query->where('task_posted_by', Session::has("Employee") ? Session::get("Employee")->id : 0);
                    })
                    ->orWhere("user_id", Session::has("admin") ? Session::get("admin")->id : 0);
            })
            ->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('taskhistory-table')
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
            Column::make('id'),
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
        return 'TaskHistory_' . date('YmdHis');
    }
}
