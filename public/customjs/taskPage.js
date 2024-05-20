$(document).ready(function () {

    var taskposted_by = "Hello";
    var TaskTable = $("#task-table").DataTable({
        processing: true,
        serverSide: true,
        lengthChange: false,
        bInfo: false,
        ajax: {
            data: function (d) {},
        },
        columns: [
            {
                data: "action",
                name: "action",
                width: "40px",
                orderable: false,
            },
            {
                data: "task_id",
                name: "task_id",
                orderable: false,
            },
            {
                data: "task_title",
                name: "task_title",
                orderable: false,
                render: function (data, type, row) {
                    return `<a class="detailTask" data-id="${row.id}">${data}</a>`;
                },
            },
            {
                data: "Project Name",
                name: "Project Name",
                orderable: false,
            },
            {
                data: "task_type",
                name: "task_type",
                orderable: false,
            },
            {
                data:'taskpostedby',
                name:'taskpostedby',
                orderable:false,
                render:function(data){
                    taskposted_by = data;
                    return data;
                },
            },
            {
                data: "Employees",
                name: "Employees",
                orderable: false,
                visible:
                    admin != null ||
                    Emp.employee_role.role_title == "Project Manager" ||
                    Emp.employee_role.role_title == "QA"
                        ? true
                        : false,
                render: function(data)
                {
                    return data.replaceAll(",","<br><br>");
                }
            },
            {
                data: "task_DeadLine",
                name: "task_DeadLine",
                orderable: false,
            },
            {
                data: "task_status",
                name: "task_status",
                orderable: false,
            },
        ],
    });

    console.log(Emp.emp_name,taskposted_by,TaskTable.settings().init())
    console.log(TaskTable.column(5).render(function(data){
        return data;
    }))
    if(Emp.emp_name == taskposted_by)
    {
        TaskTable.column(5).visible(false);
    }


    $(document).on("click", ".task-status-edit-btn", function () {
        TaskTable.column(8).draw();
        setTimeout(() => {
            $(".select-task-status-" + $(this).data("row-id")).prop(
                "disabled",
                false
            );
        }, 250);

        setTimeout(() => {
            $(".select-task-status-" + $(this).data("row-id")).prop(
                "disabled",
                true
            );
        }, 5000);
    });

    $("#addtaskbtn").on("click", function () {
        $("#add-task-btn").removeClass("d-none");
        $("#taskdetails").addClass("d-none");
        $("#taskaddorupdate").removeClass("d-none");

        $("#offcanvasScrollingLabel").html("Add Task");
        $(".add-task-btn").attr("id", "add-task-btn");
        $(".add-task-btn").html("Add task");

        $("#SelectProject").prop("selectedIndex", 0);
        $("#SelectProject").trigger("change");

        $("#SelectEmployee").empty();
        $("#SelectEmployee").trigger("change");

        $("#SelectTaskType").prop("selectedIndex", 0);
        $("#SelectTaskType").trigger("change");

        $("#addtaskform")[0].reset();
        $("#addtaskform").attr("action", "http://127.0.0.1:8000/Task/addtask");
    });

    $(document).on("change", "#SelectTaskStatus", function () {
        let task_status_data = {
            task_status: $(this).val(),
            task_id: $(this).find("option:selected").data("id"),
            project_id: $(this).find("option:selected").data("project-id"),
        };

        if (task_status_data.task_status == "Complete") {
            Swal.fire({
                title: "Are you sure to Complete This Task?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "/Task/addtotaskhistory",
                        data: task_status_data,
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        success: function (response) {
                            console.log(response);
                            if (response == 1) {
                                new Notify({
                                    status: "success",
                                    title: "Updated!",
                                    text: "Task Status Updated SuccessFully",
                                    effect: "slide",
                                    speed: 300,
                                    customClass: "",
                                    customIcon: "",
                                    showIcon: true,
                                    showCloseButton: true,
                                    autoclose: true,
                                    autotimeout: 2000,
                                    notificationsGap: null,
                                    notificationsPadding: null,
                                    type: "outline",
                                    position: "top right",
                                    customWrapper: "",
                                });
                                TaskTable.ajax.reload();
                                $("#Task-offcanvasScrolling").removeClass(
                                    "show"
                                );
                            }
                        },
                        error: function (error) {
                            console.log(error);
                        },
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire({
                        title: "Cancelled",
                        text: "Your Task is not Complete Yet :)",
                        icon: "error",
                    });
                }
            });
        } else {
            $.ajax({
                type: "POST",
                url: "/Task/addtotaskhistory",
                data: task_status_data,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                success: function (response) {
                    console.log(response);
                    if (response == 1) {
                        new Notify({
                            status: "success",
                            title: "Updated!",
                            text: "Task Status Updated SuccessFully",
                            effect: "slide",
                            speed: 300,
                            customClass: "",
                            customIcon: "",
                            showIcon: true,
                            showCloseButton: true,
                            autoclose: true,
                            autotimeout: 2000,
                            notificationsGap: null,
                            notificationsPadding: null,
                            type: "outline",
                            position: "top right",
                            customWrapper: "",
                        });
                        TaskTable.ajax.reload();
                        $("#Task-offcanvasScrolling").removeClass("show");
                    }
                },
                error: function (error) {
                    console.log(error);
                },
            });
        }
    });

    $(".dt-search").css("display", "none");

    $("#SelectProject").on("change", function () {
        let projectId = $(this).val();
        $.ajax({
            url: "/Task/getemployeesfromproject",
            type: "POST",
            data: {
                projectID: projectId,
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                $("#SelectEmployee").empty();
                $.each(response.employees, function (index, element) {
                    $("#SelectEmployee").append(
                        $("<option>", {
                            value: element.id,
                            text: element.name,
                        })
                    );
                });

                setDeadLine(response.deadLine);
                $("#TaskMaxDeadLine").val(response.deadLine);
            },
            error: function (error) {
                console.log(error);
            },
        });
    });

    $(".add-task-btn").on("click", function () {
        let taskName = $("#InputTaskTitle").val();
        let taskDescription = $("#InputTaskDescription").val();
        let taskProject = $("#SelectProject").prop("selectedIndex");
        let taskEmployee = $("#SelectEmployee").val();
        let taskType = $("#SelectTaskType").prop("selectedIndex");
        let taskDeadLine = $("#TaskDeadLine").val();
        let taskImages = $("#TaskImages").val();

        if (taskName.trim() == "") {
            $("#errorTaskTitle").html("Enter Task Title");
        } else if (taskDescription.trim() == "") {
            $("#errorTaskDescription").html("Enter Task Description");
        } else if (taskProject == 0) {
            $("#errorTaskProject").html("Select Project");
        } else if (taskEmployee.length == 0) {
            $("#errorTaskEmployee").html("Select Employee For This Task");
        } else if (taskType == 0) {
            $("#errorTaskType").html("Select Task Type");
        } else if (taskDeadLine.trim() == "") {
            $("#errorTaskDeadLine").html("Select Task DeadLine");
        } else {
            if ($(".add-task-btn").attr("id") == "update-task-btn") {
                if ($(".task_images_for_update")) {
                    let taskimagesname = "";

                    $(".task_images_for_update").each(function (
                        index,
                        element
                    ) {
                        taskimagesname += $(this).data("value") + ",";
                    });

                    $("#addtaskform").append(
                        $("<input>", {
                            type: "hidden",
                            name: "taskoldimages",
                            value: taskimagesname,
                        })
                    );
                }
            }
            $("#addtaskform").submit();
        }

        setTimeout(() => {
            $("#errorTaskTitle").html("");
            $("#errorTaskDescription").html("");
            $("#errorTaskProject").html("");
            $("#errorTaskEmployee").html("");
            $("#errorTaskType").html("");
            $("#errorTaskDeadLine").html("");
        }, 2000);
    });

    $(document).on("click", ".editbtn", function () {
        $("#add-task-btn").removeClass("d-none");
        $("#taskdetails").addClass("d-none");
        $("#taskaddorupdate").removeClass("d-none");

        $("#Task-offcanvasScrolling").addClass("show");
        $("#Task-offcanvasScrolling").css("visibility", "visible");
        $("#offcanvasScrollingLabel").html("Update Task");
        $(".add-task-btn").attr("id", "update-task-btn");
        $(".add-task-btn").html("Update task");
        $("#addtaskform").attr(
            "action",
            "http://127.0.0.1:8000/Task/updatetask"
        );

        let TaskId = $(this).data("id");
        $.ajax({
            type: "POST",
            url: "/Task/gettaskdatafromid",
            data: {
                taskId: TaskId,
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                console.log(response);

                let employees = response.task_assign_to.split(",");

                let oldTaskImages =
                    response.task_images != null
                        ? response.task_images.split(",")
                        : [];

                $("#InputTaskTitle").val(response.task_title);
                $("#InputTaskDescription").val(response.task_description);

                $("#SelectProject").val(response.project_id);
                $("#SelectProject").trigger("change");

                setTimeout(() => {
                    $("#SelectEmployee").val(employees);
                    $("#SelectEmployee").trigger("change");
                }, 250);

                $("#SelectTaskType").val(response.task_type);
                $("#SelectTaskType").trigger("change");

                $("#TaskDeadLine").val(response.task_DeadLine);

                $(".task_images_for_update").remove();
                if (oldTaskImages.length > 0) {
                    oldTaskImages.forEach((element, index) => {
                        $(".task-images-for-update").append(
                            $("<img>", {
                                src: baseUrl + "/" + element,
                                class:
                                    "row task_images_for_update image-" + index,
                                "data-value": element,
                                "data-id": index,
                                id: "task_images_for_update",
                                style: "margin:20px;width:100px;height:100px;",
                            })
                        );

                        let closebtn = $("<span>", {
                            width: "30px",
                            height: "30px",
                            class: "close-icon-for-images d-none " + index,
                            id: index,
                            html: "<i class='mdi mdi-close-circle-outline'></i>",
                        });

                        $(".task-images-for-update").append(closebtn);
                    });

                    $(".task_images_for_update").each(function () {
                        $(this).on("click", function () {
                            $("." + $(this).data("id")).remove();
                            $(this).remove();
                        });
                    });
                }

                if ($("#TaskId").val()) {
                    $("#TaskId").val(response.id);
                } else {
                    let TaskIdHidden = $("<input>", {
                        type: "hidden",
                        name: "TaskId",
                        id: "TaskId",
                        value: response.id,
                    });

                    $("#addtaskform").append(TaskIdHidden);
                }
            },
        });
    });

    $(document).on("mouseenter", ".task_images_for_update", function () {
        $("." + $(this).data("id")).removeClass("d-none");
    });

    $(document).on("mouseleave", ".task_images_for_update", function () {
        $("." + $(this).data("id")).addClass("d-none");
        $(document).on("mouseenter", "." + $(this).data("id"), function () {
            $(this).removeClass("d-none");
        });
    });

    $(document).on("click", ".deleteTask", function () {
        console.log($(this).data("id"));
        let TaskId = $(this).data("id");

        $.ajax({
            type: "POST",
            url: "/Task/deletetask",
            data: {
                taskId: TaskId,
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                console.log(response);
                if (response == 1) {
                    new Notify({
                        status: "success",
                        title: "Deleted!",
                        text: "Task Deleted SuccessFully",
                        effect: "fade",
                        speed: 300,
                        customClass: "",
                        customIcon: "",
                        showIcon: true,
                        showCloseButton: true,
                        autoclose: true,
                        autotimeout: 2000,
                        notificationsGap: null,
                        notificationsPadding: null,
                        type: "outline",
                        position: "top right",
                        customWrapper: "",
                    });
                    TaskTable.ajax.reload();
                }
            },
        });
    });

    $(document).on("click", ".detailTask", function () {
        $("#add-task-btn").addClass("d-none");
        let TaskId = $(this).data("id");
        console.log(TaskId);
        $.ajax({
            type: "POST",
            url: "/Task/gettaskdatafromid",
            data: {
                taskId: TaskId,
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                let Task_Images =
                    response.task_images != null
                        ? response.task_images.split(",")
                        : [];
                $("#offcanvasScrollingLabel").html(response.task_title);
                $("#DetailTaskDescrption").html(response.task_description);

                $("#Task-offcanvasScrolling").addClass("show");
                $("#Task-offcanvasScrolling").css("visibility", "visible");
                $("#taskaddorupdate").addClass("d-none");
                $("#taskdetails").removeClass("d-none");

                let options = [
                    {
                        value: "Listed",
                        text: "Listed",
                        project_id: response.project_id,
                        task_id: response.id,
                        disabled: true,
                    },
                ];

                if (response.task_status !== "Complete" && admin == null) {
                    if (response.task_assign_to.includes(Emp.id)) {
                        options.push(
                            {
                                value: "In Working",
                                text: "In Working",
                                project_id: response.project_id,
                                task_id: response.id,
                                disabled: false,
                            },
                            {
                                value: "On Hold",
                                text: "On Hold",
                                project_id: response.project_id,
                                task_id: response.id,
                                disabled: false,
                            },
                            {
                                value: "Done",
                                text: "Done",
                                project_id: response.project_id,
                                task_id: response.id,
                                disabled: false,
                            },
                            {
                                value: "Not Done",
                                text: "Not Done",
                                project_id: response.project_id,
                                task_id: response.id,
                                disabled: false,
                            }
                        );
                    } else {
                        if (response.task_status == "Done") {
                            options.push(
                                {
                                    value: "Done",
                                    text: "Done",
                                    project_id: response.project_id,
                                    task_id: response.id,
                                    disabled: true,
                                },
                                {
                                    value: "Not Done",
                                    text: "Not Done",
                                    project_id: response.project_id,
                                    task_id: response.id,
                                    disabled: false,
                                }
                            );
                        } else {
                            options.push({
                                value: response.task_status,
                                text: response.task_status,
                                project_id: response.project_id,
                                task_id: response.id,
                                disabled: false,
                            });
                            $("#SelectTaskStatus").prop("disabled", true);
                        }
                    }

                    if (Emp.id == response.task_posted_by) {
                        options.push({
                            value: "Complete",
                            text: "Complete",
                            project_id: response.project_id,
                            task_id: response.id,
                            disabled: false,
                        });
                    }


                } else {
                    options.push({
                        value: response.task_status,
                        text: response.task_status,
                        project_id: response.project_id,
                        task_id: response.id,
                        disabled: false,
                    });
                    if(admin != null)
                    {
                        $("#SelectTaskStatus").addClass("d-none");
                        $("#TaskStatusLabel").addClass("d-none");
                    }
                }

                $(".TaskStatusOptions").remove();

                $.each(options, function (index, option) {
                    $("#SelectTaskStatus").append(
                        $("<option>", {
                            value: option.value,
                            text: option.text,
                            "data-project-id": option.project_id,
                            "data-id": option.task_id,
                            class: "TaskStatusOptions",
                            disabled: option.disabled,
                        })
                    );
                });

                console.log(response.task_status);
                $("#SelectTaskStatus").val(response.task_status);

                $(".task_images").remove();
                Task_Images.forEach((element, index) => {
                    $(".task-images").append(
                        $("<img>", {
                            src: baseUrl + "/" + element,
                            class: "row task_images",
                            id: "task_images",
                            style: "margin:30px 30px 30px 100px;width:200px;height:150px;",
                        })
                    );
                });
            },
        });
    });

    $(document).on("click", ".task_images", function () {
        window.open($(this).attr("src"), "_blank");
    });

    $(".btncancel").on("click", function () {
        $("#Task-offcanvasScrolling").removeClass("show");
    });

    function searchBasedOnColumn(column, searchText) {
        TaskTable.columns(column).search(searchText, true, false).draw();
    }

    $("#cleartaskdeadline").on("click",function(){
        $("#s_task_deadline").val("");
        $("#s_task_deadline").trigger("input");
        $("#cleartaskdeadline").addClass("d-none");
    });

    $("#s_task_ID").on("input", function () {
        searchBasedOnColumn($(this).data("column-id"), $(this).val());
    });
    $("#s_task_title").on("input", function () {
        searchBasedOnColumn($(this).data("column-id"), $(this).val());
    });
    $("#s_project_name").on("input", function () {
        searchBasedOnColumn($(this).data("column-id"), $(this).val());
    });
    $("#s_task_type").on("input", function () {
        searchBasedOnColumn($(this).data("column-id"), $(this).val());
    });
    $("#s_task_posted_by").on("input", function () {
        searchBasedOnColumn($(this).data("column-id"), $(this).val());
    });
    $("#s_task_deadline").on("input", function () {
        $("#cleartaskdeadline").removeClass("d-none");
        console.log($(this).val());
        searchBasedOnColumn($(this).data("column-id"), $(this).val());
    });
    $("#s_task_status").on("input", function () {
        searchBasedOnColumn($(this).data("column-id"), $(this).val());
    });

});
