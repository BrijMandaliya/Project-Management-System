$(document).ready(function () {
    var ProjectTable = $("#project-table").DataTable({
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
                data: "project_code",
                name: "project_code",
                orderable: false,
            },
            {
                data: "project_name",
                name: "project_name",
                orderable: false,
            },

            {
                data: "project_startDate",
                name: "project_startDate",
                orderable: false,
            },

            {
                data: "project_deadline",
                name: "project_deadline",
                orderable: false,
            },

            {
                data: "EmployeesName",
                name: "EmployeesName",
                render: function (data) {
                    return data.replaceAll(",", "<br><br>");
                },
                orderable: false,
            },

            {
                data: "project_payout",
                name: "project_payout",
                orderable: false,
            },

            {
                data: "status",
                name: "status",
                orderable: false,
            },
        ],
    });

    $(".dt-search").css("display", "none");

    $(".addProjectBtn").on("click", function () {
        let projectName = $("#InputProjectName").val();
        let projectStartDate = $("#InputStartDate").val();
        let projectDeadLine = $("#InputDeadLine").val();
        let projectEmployees = $("#SelectEmployees").val();
        let projectPayout = $("#InputProjectPayout").val();
        let projectStatus = $("#SelectProjectStatus").val();

        if (projectName.trim() == "") {
            $("#InputProjectName").focus();
            $("#errorProjectName").html("Enter Project Name");
        } else if (projectStartDate == "") {
            $("#InputStartDate").focus();
            $("#errorstartDate").html("Select Project Start Date");
        } else if (projectDeadLine == "") {
            $("#InputDeadLine").focus();
            $("#errordeadLine").html("Select Project DeadLine");
        } else if (projectStartDate > projectDeadLine) {
            $("#InputDeadLine").focus();
            $("#errordeadLine").html("DeadLine should not be before StartDate");
        } else if (projectEmployees.length == 0) {
            $("#SelectEmployees").focus();
            $("#errorSelectEmployees").html("Select Employee Work on Project");
        } else if (projectPayout == "") {
            $("#InputProjectPayout").focus();
            $("#errorProjectPayout").html("Enter Project Payout");
        } else if (projectStatus == "") {
            $("#SelectProjectStatus").focus();
            $("#errorProjectStatus").html("Select Project Status");
        } else {
            addProjectFormData = {
                projectName: projectName,
                projectStartDate: projectStartDate,
                projectDeadLine: projectDeadLine,
                projectEmployees: projectEmployees,
                projectPayout: projectPayout,
                projectStatus: projectStatus,
            };

            if ($(this).attr("id") == "addProjectBtn") {
                $.ajax({
                    type: "POST",
                    url: "/project/addproject",
                    data: {
                        addprojectformdata: addProjectFormData,
                    },
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    success: (response) => {
                        console.log(response);
                        if (response == 1) {
                            $("#Project-offcanvasScrolling").removeClass(
                                "show"
                            );
                            $("#SelectEmployees").val(null).trigger("change");
                            new Notify({
                                status: "success",
                                title: "Added!",
                                text: "Project Added SuccessFully",
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
                        }
                    },
                    error: (error) => {
                        console.log(error);
                    },
                });
            }
            else if($(this).attr("id") == "updateProjectBtn")
            {
                let projectId = $(this)
                    .parent()
                    .parent()
                    .parent()
                    .find("input:hidden#projectID")
                    .val();
                addProjectFormData.projectID = projectId;
                $.ajax({
                    type: "POST",
                    url: "/project/updateproject",
                    data: {
                        addprojectformdata: addProjectFormData,
                    },
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    success: (response) => {
                        console.log(response);
                        if (response == 1) {
                            $("#Project-offcanvasScrolling").removeClass(
                                "show"
                            );
                            $("#SelectEmployees").val(null).trigger("change");
                            new Notify({
                                status: "success",
                                title: "Updated!",
                                text: "Project Updated SuccessFully",
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
                        }
                        ProjectTable.ajax.reload();

                    },
                    error: (error) => {
                        console.log(error);
                    },
                });
            }
        }

        setTimeout(() => {
            $("#errorProjectName").html("");
            $("#errorstartDate").html("");
            $("#errorstartDate").html("");
            $("#errordeadLine").html("");
            $("#errorSelectEmployees").html("");
            $("#errorProjectPayout").html("");
            $("#errorProjectStatus").html("");
        }, 2000);
    });

    $(document).on("click", "#add-project-btn", () => {
        $(".addProjectBtn").attr("id", "addProjectBtn");
        $(".addProjectBtn").html("Add Project");
        $("#addProjectForm")[0].reset();
    });

    $(document).on("click", "#btn-close", () => {
        $("#Project-offcanvasScrolling").removeClass("show");
    });

    $(document).on("click", ".editbtn", function () {
        $(".addProjectBtn").attr("id", "updateProjectBtn");
        $(".addProjectBtn").html("Update Project");
        let ProjectId = $(this).data("id");
        $.ajax({
            type: "POST",
            url: "/project/getprojectdatafromid",
            data: "projectID=" + ProjectId,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: (response) => {
                console.log(response);

                let Employees =
                    response.employees.length == 1
                        ? response.employees
                        : response.employees.split(",");

                $("#InputProjectName").val(response.project_name);
                $("#InputStartDate").val(response.project_startDate);
                $("#InputDeadLine").val(response.project_deadline);
                $("#SelectEmployees").val(Employees);
                $("#SelectEmployees").trigger("change");
                $("#InputProjectPayout").val(response.project_payout);
                $("#SelectProjectStatus").val(response.status);
                $("#SelectProjectStatus").trigger("change");
                $("#Project-offcanvasScrolling").addClass("show");
                $("#Project-offcanvasScrolling").css("visibility", "visible");

                if ($("#projectID").val()) {
                    $("#projectID").val($(this).data("id"));
                } else {
                    var projectIDHiddenField = $("<input>", {
                        type: "hidden",
                        id: "projectID",
                        value: response.id,
                    });
                    $(".offcanvas-body")
                        .first(".form-group")
                        .append(projectIDHiddenField);
                }
            },
            error: (error) => {
                console.log(error);
            },
        });
    });

    $(document).on("click",".deletebtn",function(){

        Swal.fire({
            title: "Are you sure?",
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
                    type:"POST",
                    url:"/project/deleteproject",
                    data:"projectId="+$(this).data("id"),
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    success:function(response)
                    {
                        console.log(response.status);
                        if(response.status == "true")
                        {
                            new Notify({
                                status: "success",
                                title: "Deleted!",
                                text: "Project Deleted SuccessFully",
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
                            ProjectTable.ajax.reload();
                        }
                        else if(response.status == "false")
                        {
                            new Notify({
                                status: "error",
                                title: "Not Deleted",
                                text: "This Project cannot be deleted as this project is "+response.projectstatus,
                                effect: "fade",
                                speed: 300,
                                customClass: "",
                                customIcon: "",
                                showIcon: true,
                                showCloseButton: true,
                                autoclose: true,
                                autotimeout: 5000,
                                notificationsGap: null,
                                notificationsPadding: null,
                                type: "outline",
                                position: "top right",
                                customWrapper: "",
                            });
                        }
                    },
                    error:function(error)
                    {
                        console.log(error);
                    }
                })
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire({
                    title: "Cancelled",
                    text: "Your Project is safe :)",
                    icon: "error",
                });
            }
        });



    });

    function searchfromtable(searchText, searchColumn) {
        ProjectTable.columns(searchColumn)
            .search(searchText, true, false)
            .draw();
    }

    $("#s_project_code").on("input", function () {
        searchfromtable($(this).val(), $(this).data("column-id"));
    });
    $("#s_project_name").on("input", function () {
        searchfromtable($(this).val(), $(this).data("column-id"));
    });
    $("#s_project_startdate").on("input", function () {
        searchfromtable($(this).val(), $(this).data("column-id"));
    });
    $("#s_project_deadline").on("input", function () {
        searchfromtable($(this).val(), $(this).data("column-id"));
    });
    $("#s_project_payout").on("input", function () {
        searchfromtable($(this).val(), $(this).data("column-id"));
    });
    $("#s_project_status").on("input", function () {
        searchfromtable($(this).val(), $(this).data("column-id"));
    });
});
