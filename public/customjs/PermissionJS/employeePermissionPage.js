$(document).ready(function () {
    var EmployeePermissionTable = $("#employee-permission-table").DataTable({
        processing: true,
        serverSide: true,
        lengthChange: false,
        searching: false,
        bInfo: false,
        ajax: {
            url: "/permission/getemployeepermission",
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        },
        columns: [
            {
                data: "action",
                name: "action",
                width: "40px",
            },
            {
                data: "employee",
                name: "employee",
            },
            {
                data: "Role",
                name: "Role",
            },
            {
                data: "Permissions",
                name: "Permissions",
                render: function (data) {
                    return data.replaceAll(",", "<br><br>");
                },
            },
        ],
    });

    $(document).on("click", ".editbtn", function () {
        let employeePermisisonId = $(this).data("id");

        $("#EmployeePermission-offcanvasScrolling").addClass("show");
        $("#EmployeePermission-offcanvasScrolling").css(
            "visibility",
            "visible"
        );

        $.ajax({
            type: "POST",
            url: "/permission/getemployeepermissionbyid",
            data: {
                employeePermissionID: employeePermisisonId,
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                console.log(response);
                let permissions = response.permission_id.split(",");
                let employeePermissionID = response.id;
                $("#EmployeeRole").html(response.employee_role.role_title);
                $("#EmployeeName").html(response.employee.emp_name);
                $("#SelectEmployeePermissions").val(permissions);
                $("#SelectEmployeePermissions").trigger("change");

                if ($("#employeePermissionID").val()) {
                    $("#employeePermissionID").val(employeePermissionID);
                } else {
                    var RoleIDHiddenField = $("<input>", {
                        type: "hidden",
                        id: "employeePermissionID",
                        value: employeePermissionID,
                    });
                    $(".offcanvas-body")
                        .first(".form-group")
                        .append(RoleIDHiddenField);
                }
            },
            error: function (error) {
                console.log(error);
            },
        });
    });

    $(document).on("click", ".btncancel", function () {
        $("#EmployeePermission-offcanvasScrolling").removeClass("show");
    });

    $(document).on("click", "#update-employee-permission-btn", function () {
        let employeePermissionID = $(this)
            .parent()
            .parent()
            .parent()
            .find("input:hidden")
            .val();

        let employeepermissions = $("#SelectEmployeePermissions").val();

        let permissions = "";

        $(".select2-selection__choice").each(function(){
            permissions += $(this).attr("title") + ",";
        });

        $.ajax({
            url: "/permission/updateemployeepermission",
            type: "POST",
            data: {
                empPermissions: permissions,
                employeePermissions: employeepermissions,
                employeePermissionId: employeePermissionID,
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                console.log(response);
                if (response == 1) {
                    $("#EmployeePermission-offcanvasScrolling").removeClass(
                        "show"
                    );
                    new Notify({
                        status: "success",
                        title: "Updated!",
                        text: "Employee Permission Update SuccessFully",
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
                    EmployeePermissionTable.ajax.reload();
                }
            },
            error: function (error) {
                console.log(error);
            },
        });
    });
});
