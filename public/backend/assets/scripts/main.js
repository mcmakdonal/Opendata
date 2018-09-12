var full_url = window.location.protocol + "//" + window.location.hostname;
// preload window
$(document).ready(function ($) {
    var Body = $("body");
    Body.addClass("preloader-site");
    $(".use-select2").select2();

    $('.datatable').DataTable();
});

$(window).load(function () {
    $(".preloader-wrapper").fadeOut();
    $("body").removeClass("preloader-site");
});

// preload ajax
$.LoadingOverlaySetup({
    image: "",
    fontawesome: "fa fa-circle-o-notch fa-spin"
});

function read_filename(e) {
    var name = $(e)
        .val()
        .split(/(\\|\/)/g)
        .pop();
    $("#file_name").val(name);
}

function remove_dts(e, slug) {
    swal("คุณต้องการลบ Dataset นี้ ?", {
        buttons: {
            yes: {
                text: "Yes",
                className: "btn-danger"
            },
            no: {
                text: "No",
                className: "btn-default"
            }
        }
    }).then(value => {
        switch (value) {
            case "yes":
                var url = $(e).attr("data");
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        )
                    },
                    url: url + "/" + slug,
                    method: "delete",
                    beforeSend() {
                        $.LoadingOverlay("show");
                    },
                    success: function (result) {
                        var obj = result;
                        $.LoadingOverlay("hide");
                        if (obj.status) {
                            window.location.replace(full_url + "/dataset");
                        } else {
                            swal("Fail !", obj.message, "error");
                        }
                    },
                    error(xhr, status, error) {
                        alert(error);
                    }
                });
                break;
            case "no":
                swal("Message!", "Cancel", "warning");
                break;
            default:
        }
    });
}

function remove_ogz(e, slug) {
    swal("คุณต้องการลบ Organization นี้ ?", {
        buttons: {
            yes: {
                text: "Yes",
                className: "btn-danger"
            },
            no: {
                text: "No",
                className: "btn-default"
            }
        }
    }).then(value => {
        switch (value) {
            case "yes":
                var url = $(e).attr("data");
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        )
                    },
                    url: url + "/" + slug,
                    method: "delete",
                    beforeSend() {
                        $.LoadingOverlay("show");
                    },
                    success: function (result) {
                        var obj = result;
                        $.LoadingOverlay("hide");
                        if (obj.status) {
                            window.location.replace(full_url + "/organization");
                        } else {
                            swal("Fail !", obj.message, "error");
                        }
                    },
                    error(xhr, status, error) {
                        alert(error);
                    }
                });
                break;
            case "no":
                swal("Message!", "Cancel", "warning");
                break;
            default:
        }
    });
}

function remove_res(e, slug_url, res_id) {
    swal("คุณต้องการลบ Resource นี้ ?", {
        buttons: {
            yes: {
                text: "Yes",
                className: "btn-danger"
            },
            no: {
                text: "No",
                className: "btn-default"
            }
        }
    }).then(value => {
        switch (value) {
            case "yes":
                var url = $(e).attr("data");
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        )
                    },
                    url: url + "/" + res_id,
                    method: "delete",
                    beforeSend() {
                        $.LoadingOverlay("show");
                    },
                    success: function (result) {
                        var obj = result;
                        $.LoadingOverlay("hide");
                        if (obj.status) {
                            window.location.href = full_url + '/dataset/page/' + slug_url;
                        } else {
                            swal("Fail !", obj.message, "error");
                        }
                    },
                    error(xhr, status, error) {
                        alert(error);
                    }
                });
                break;
            case "no":
                swal("Message!", "Cancel", "warning");
                break;
            default:
        }
    });
}

function set_status_dts(type) {
    var dts_id = $("input:checkbox:checked")
        .map(function () {
            return this.value;
        })
        .get();

    // console.log(dts_id);
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        url: full_url + "/dataset/set_status",
        method: "post",
        data: {
            dts_id: JSON.stringify(dts_id),
            type: type
        },
        beforeSend() {
            $.LoadingOverlay("show");
        },
        success: function (result) {
            var obj = result;
            // console.log(obj.status);
            $.LoadingOverlay("hide");
            if (obj.status) {
                location.reload(true);
            } else {
                swal("Fail !", "ผิดพลาด", "error");
            }
        },
        error(xhr, status, error) {
            alert(error);
        }
    });
}

function delete_admin(e) {
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        url: full_url + "/administrator/" + $(e).attr('data'),
        method: "delete",
        beforeSend() {
            $.LoadingOverlay("show");
        },
        success: function (result) {
            var obj = result;
            $.LoadingOverlay("hide");
            if (obj.status) {
                location.reload(true);
            } else {
                swal("Fail !", "ผิดพลาด", "error");
            }
        },
        error(xhr, status, error) {
            alert(error);
        }
    });
}

$(".download-file").click(function (e) {
    var file = $(this).attr('data');
    var id = $(this).attr('data-id');
    $(".last-download").attr('data', file);
    $(".last-download").attr('data-id', id);

    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        url: full_url + "/is-login",
        method: "get",
        success: function (result) {
            var obj = result;
            $.LoadingOverlay("hide");
            if (obj.status) {
                window.location.href = file;
                return true;
            } else {
                $("#modal-download").modal({
                    backdrop: true
                });
            }
        },
        error(xhr, status, error) {
            alert(error);
        }
    });
});

$(".last-download").click(function (e) {
    e.preventDefault();
    var first_name = $("form.form-download #first_name").val().trim();
    var last_name = $("form.form-download #last_name").val().trim();
    var description = $("form.form-download #description").val().trim();
    var file = $(this).attr('data');
    var res_id = $(this).attr('data-id');
    if (first_name == "" || last_name == "" || description == "") {
        swal("Information !", "กรุณากรอก ชื่อ และ นามสกุล และรายละเอียดการ Download", "warning");
        return false;
    } else {
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            url: full_url + "/user-download",
            method: "post",
            data: {
                first_name: first_name,
                last_name: last_name,
                description: description,
                res_id: res_id
            },
            beforeSend() {
                $.LoadingOverlay("show");
            },
            success: function (result) {
                var obj = result;
                $.LoadingOverlay("hide");
                if (obj.status) {
                    window.location.href = file;
                    // $("#modal-download").modal("hide");
                    return true;
                } else {
                    swal("Fail !", "ผิดพลาด", "error");
                }
            },
            error(xhr, status, error) {
                alert(error);
            }
        });
    }
});
