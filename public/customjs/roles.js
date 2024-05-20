$(document).ready(function () {


    $(".addRoleBtn").on("click", function () {
        $("#InputRoleTitle").val("");
        $("#SelectPermissions").val([]);
        $("#SelectPermissions").trigger("change");
        $(".add-roles-btn").html("Add Role");
        $(".add-roles-btn").attr("id", "add-roles-btn");
    });

    $(".btncancel").on("click", function () {
        $("#Role-offcanvasScrolling").removeClass("show");
    });

    $(".add-roles-btn").on("click", function () {
        var RoleTitle = $("#InputRoleTitle").val();
        let RolePermissions = $("#SelectPermissions").val();

        if (RoleTitle.trim() == "") {
            $("#errorRoleTitle").html("Please Enter Role Title");
            setTimeout(() => {
                $("#errorRoleTitle").html("");
            }, 2000);
        } else if (RolePermissions.length < 1) {
            $("#errorRolePermissions").html("Please Select Any One Permission");
            setTimeout(() => {
                $("#errorRolePermissions").html("");
            }, 2000);
        } else {
            if ($(this).attr("id") == "add-roles-btn") {
                $.ajax({
                    url: "/roles/addrole",
                    type: "POST",
                    data: {
                        roleTitle: RoleTitle,
                        rolePermissions: RolePermissions,
                    },
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    success: function (response) {
                        console.log(response);
                        if (response == 1) {
                            $("#Role-offcanvasScrolling").removeClass("show");
                            new Notify({
                                status: "success",
                                title: "Added",
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
                            roleTable.ajax.reload();
                        }
                    },
                    error: function (error) {
                        console.log(error);
                    },
                });
            } else if($(this).attr("id") == "update-roles-btn") {

                let roleId = $(this)
                    .parent()
                    .parent()
                    .parent()
                    .find("input:hidden")
                    .val();
                let permissions = "";

                $(".select2-selection__choice").each(function(){
                    permissions = $(this).attr("title") + ",";
                });

                $.ajax({
                    type: "POST",
                    url: "/roles/updaterole",
                    data: {
                        roleTitle: RoleTitle,
                        roleID: roleId,
                        rolePermissions: RolePermissions,
                        permissions : permissions,
                    },
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    success: function (response) {
                        console.log(response);
                        if (response == 1) {
                            $("#Role-offcanvasScrolling").removeClass("show");
                            new Notify({
                                status: "success",
                                title: "Updated",
                                text: "Role Updated SuccessFully",
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
                            roleTable.ajax.reload();

                        }
                    },
                    error: function (error) {
                        console.log(error);
                    },
                });
            }
        }
    });

    var roleTable = $("#roles-table").DataTable({
        processing: true,
        serverSide: true,
        lengthChange: false,
        searching: false,
        bInfo: false,
        ajax: {
            data: function (d) {},
        },
        columns: [
            {
                data: "action",
                name: "action",
                width: "40px",
            },
            {
                data: "role_title",
                name: "role_title",
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

    $(".dt-search").css("display", "none");

    $(document).on("click", ".editbtn", function () {
        $.ajax({
            url: "/roles/getroledatafromid",
            type: "POST",
            data: {
                roleID: $(this).data("id"),
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {

                let permissions = response.Permissions.permission_id.split(",");
                let Role_Title = response.Permissions.role_title;
                let Role_ID = response.Permissions.id;

                $("#SelectPermissions").val(permissions);
                $("#InputRoleTitle").val(Role_Title);
                $("#Role-offcanvasScrolling").addClass("show");
                $("#Role-offcanvasScrolling").css("visibility", "visible");

                $("#SelectPermissions").trigger("change");

                $(".add-roles-btn").html("Update Role");
                $(".add-roles-btn").attr("id", "update-roles-btn");

                if ($("#roleID").val() != null) {

                    $("#roleID").val(response.Permissions.id);

                } else {

                    var RoleIDHiddenField = $("<input>", {
                        type: "hidden",
                        id: "roleID",
                        value: Role_ID,
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

    $(document).on("click", ".deletebtn", function () {
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
                    type: "POST",
                    url: "/roles/deleterole",
                    data: {
                        roleID: $(this).data("id"),
                    },
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    success: function (response) {
                        if (response.status == true) {
                            new Notify({
                                status: "success",
                                title: "Deleted",
                                text: "Role Deleted SuccessFully",
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
                            roleTable.ajax.reload();
                        }
                        else if (response.status == false) {
                            new Notify({
                                status: "error",
                                title: "Cannot Deleted",
                                text: response.statusMessage,
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
                            roleTable.ajax.reload();
                        }
                    },
                    error:function(error)
                    {
                        console.log(error.responseText);
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire({
                    title: "Cancelled",
                    text: "Your imaginary file is safe :)",
                    icon: "error",
                });
            }
        });
    });

    $("#SelectPermissions").on("change", function () {

    });
});
