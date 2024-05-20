$(document).ready(function () {
    var permissionTable = $("#permission-table").DataTable({
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
                data: "permission_title",
                name: "permission_title",
            },
        ],
    });

    $("#addPermissionBtn").on("click", function () {
        $("#PermissionModalLabel").html("Add Permission");
        $(".add-permission-btn").attr("id", "add-permission-btn");
        $(".add-permission-btn").html("Add Permission");
        $("#PermissionModal").modal("show");
        $("#InputPermissionTitle").val("");
    });

    $(".PermissionModalCloseBtn").on("click", function () {
        $("#PermissionModal").modal("hide");
    });

    $(".add-permission-btn").on("click", function () {
        var permisisonTitle = $("#InputPermissionTitle").val();
        if (permisisonTitle.trim() == "") {
            $("errorPermissionTitle").html("Please Enter Permision");
            setTimeout(() => {
                $("errorPermissionTitle").html("");
            }, 2000);
        } else {
            if ($(this).attr("id") == "add-permission-btn") {
                $.ajax({
                    type: "POST",
                    url: "/permission/addpermission",
                    data: {
                        permissionTitle: permisisonTitle,
                    },
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    success: function (response) {
                        if (response == 1) {
                            $("#PermissionModal").modal("hide");
                            new Notify({
                                status: "success",
                                title: "Added!",
                                text: "Permission Added SuccessFully",
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
                            permissionTable.ajax.reload();
                        }
                    },
                    error: function (error) {
                        console.log(error);
                    },
                });
            } else if ($(this).attr("id") == "update-permission-btn") {
                let permissionID = $(this)
                    .parent()
                    .parent()
                    .find("input:hidden")
                    .val();
                $.ajax({
                    type: "POST",
                    url: "/permission/updatepermission",
                    data: {
                        permissionId: permissionID,
                        permissionTitle: permisisonTitle,
                    },
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    success: function (response) {
                        if (response == 1) {
                            $("#PermissionModal").modal("hide");
                            new Notify({
                                status: "success",
                                title: "Updated!",
                                text: "Permission Updated SuccessFully",
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

                            permissionTable.ajax.reload();
                        }
                    },
                    error: function (error) {
                        console.log(error);
                    },
                });
            }
        }
    });

    $(document).on("click", ".editbtn", function () {
        $("#PermissionModalLabel").html("Update Permission");
        $(".add-permission-btn").html("Update Permission");
        $(".add-permission-btn").attr("id", "update-permission-btn");
        $("#PermissionModal").modal("show");
        $("#InputPermissionTitle").val($(this).attr("value"));
        if ($("#permissionID").val()) {
            $("#permissionID").val($(this).data("id"));
        } else {
            var PermissionIDHiddenField = $("<input>", {
                type: "hidden",
                id: "permissionID",
                value: $(this).data("id"),
            });
            $("#PermissionModal")
                .find(".form-group")
                .append(PermissionIDHiddenField);
        }
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
                    url: "/permission/deletepermission",
                    data: {
                        permissionId: $(this).data("id"),
                    },
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    success: function (response) {
                        if (response == 1) {
                            new Notify({
                                status: "success",
                                title: "Deleted!",
                                text: "Permission Deleted SuccessFully",
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
                            permissionTable.ajax.reload();
                        } else if (response == "false") {
                            new Notify({
                                status: "error",
                                title: "Not Deleted!",
                                text: "This Permission Can't be Deleted As This Permission is Assign to Any Role or Any Employee",
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
                    error: function (error) {
                        console.log(error);
                    },
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire({
                    title: "Cancelled",
                    text: "Your Project is safe :)",
                    icon: "error",
                });
            }
        });
    });
});
