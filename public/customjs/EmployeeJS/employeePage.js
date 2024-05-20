$(document).ready(function(){
    var EmployeeTable = $("#employee-table").DataTable({
        processing: true,
        serverSide: true,
        lengthChange: false,
        bInfo: false,
        ajax: {
            data: function (d) {console.log(d)},
        },
        columns: [
            {
                data: "action",
                name: "action",
                width: "40px",
                orderable : false,
            },
            {
                data: "emp_name",
                name: "emp_name",
                orderable:false,
            },
            {
                data: "emp_email",
                name: "emp_email",
                orderable:false,
            },
            {
                data: "emp_code",
                name: "emp_code",
                orderable:false,
            },
            {
                data: "Role",
                name: "Role",
                orderable:false,
                searchable: true,
            },
            {
                data: "emp_address",
                name: "emp_address",
                orderable:false,
            },
            {
                data: "emp_country",
                name: "emp_country",
                orderable:false,
            },
            {
                data: "emp_gender",
                name: "emp_gender",
                orderable:false,
            },
            {
                data: "emp_DOB",
                name: "emp_DOB",
                orderable:false,
            },
            {
                data: "emp_profile_image",
                name: "emp_profile_image",
                render: function(data)
                {
                    return `<img src="`+baseUrl+`/`+data+`" height="50px" width="50px">`;

                },
                orderable:false,
            },

        ],
    });

    $(".dt-search").css("display","none");



    $(document).on("click",".deletebtn",function(){
        console.log($(this).data("id"));

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
                        url: "/employee/deleteemployee",
                        data:{
                            employeeID : $(this).data("id"),
                        },
                        headers:{
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        success:function(response)
                        {
                            console.log(response);
                            if(response == 1)
                            {
                                new Notify({
                                    status: "success",
                                    title: "Deleted!",
                                    text: "Employee Deleted SuccessFully",
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

                                EmployeeTable.ajax.reload();
                            }
                        },
                        error:function(error)
                        {
                            console.log(error);
                        },
                })
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire({
                    title: "Cancelled",
                    text: "Your Employee is safe :)",
                    icon: "error",
                });
            }
        });




    });

    function searchfromtable(searchText,searchColumn)
    {
        console.log(searchText,searchColumn);
        EmployeeTable.columns(searchColumn).search(searchText, true, false).draw();
    }

    $("#s_emp_name").on("input",function()
    {
        searchfromtable($(this).val(),$(this).data("column-id"));
    });

    $("#s_emp_email").on("input",function()
    {
        searchfromtable($(this).val(),$(this).data("column-id"));
    });

    $("#s_emp_code").on("input",function()
    {
        searchfromtable($(this).val(),$(this).data("column-id"));
    });

    $("#s_emp_Role").on("input",function()
    {
        searchfromtable($(this).val(),$(this).data("column-id"));
    });

    $("#s_emp_Address").on("input",function()
    {
        searchfromtable($(this).val(),$(this).data("column-id"));
    });

    $("#s_emp_Country").on("input",function()
    {
        searchfromtable($(this).val(),$(this).data("column-id"));
    });

    $("#s_emp_Gender").on("input",function()
    {
        searchfromtable($(this).val(),$(this).data("column-id"));
    });




});
