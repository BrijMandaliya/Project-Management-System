$(document).ready(function () {
    var TaskHistoryTable = $("#task-history-table").DataTable({
        processing: true,
        serverSide: true,
        lengthChange: false,
        ajax: {
            data: function (d) {

            },
        },
        columns: [
            {
                data: "task_name",
                name: "task_name",
                orderable: false,
            },
            {
                data: "project_name",
                name: "project_name",
                orderable: false,
            },
            {
                data: "employee_name",
                name: "employee_name",
                orderable: false,
            },
            {
                data: "task_status",
                name: "task_status",
                orderable: false,
            },
            {
                data: "task_status_on",
                name: "task_status_on",
                orderable: false,
            },
        ],
    });

    $(".dt-search").css("display", "none");

    function searchBasedOnColumn(column, searchText) {
        TaskHistoryTable.columns(column).search(searchText, true, false).draw();
    }

    $("#s_task_name").on("input", function () {
        searchBasedOnColumn($(this).data("column-id"), $(this).val());
    });
    $("#s_project_name").on("input", function () {
        searchBasedOnColumn($(this).data("column-id"), $(this).val());
    });
    $("#s_employee_name").on("input", function () {
        searchBasedOnColumn($(this).data("column-id"), $(this).val());
    });
    $("#s_task_status").on("input", function () {
        searchBasedOnColumn($(this).data("column-id"), $(this).val());
    });
    $("#s_task_on").on("input", function () {
        searchBasedOnColumn($(this).data("column-id"), $(this).val());
    });

});
