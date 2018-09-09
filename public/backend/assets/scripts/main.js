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