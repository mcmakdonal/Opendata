var full_url = window.location.protocol + "//" + window.location.hostname;
// preload window
$(document).ready(function ($) {
    var Body = $("body");
    Body.addClass("preloader-site");
    $(".use-select2").select2();

    $('.datatable').DataTable();

    $('.tag-input').tagsInput({
        'width': '100%',
        'defaultText': 'ใส่ป้ายกำกับ'
    });
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

function manage_cat(type, id = '') {
    $("#cat_title").val("");
    if (type == "add") {
        $("#modal-cat").modal({
            backdrop: true
        });
    } else if (type == "edit") {
        $("#modal-cat-edit").modal({
            backdrop: true
        });
        var str = $("#cat_title_" + id).html().trim();
        $(".form-cat").attr('action', full_url + '/categories/' + id)
        $("#cat_title").val(str);
    } else if (type == 'del') {
        swal("คุณต้องการลบ Categories นี้ ?", {
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
                    $.ajax({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                        },
                        url: full_url + "/categories/" + id,
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
                    break;
                case "no":
                    swal("Message!", "Cancel", "warning");
                    break;
                default:
            }
        });
    }
}

// organization
$(".organization").click(function () {
    if ($(this).hasClass("menu-active")) {
        $(this).removeClass("menu-active");
    } else {
        $(".organization").removeClass("menu-active");
        $(this).addClass("menu-active");
    }
    $('html,body').animate({
        scrollTop: 0
    }, 'slow');
});

// format
$(".format").click(function () {
    if ($(this).hasClass("menu-active")) {
        $(this).removeClass("menu-active");
    } else {
        $(".format").removeClass("menu-active");
        $(this).addClass("menu-active");
    }
    $('html,body').animate({
        scrollTop: 0
    }, 'slow');
});

// license
$(".license").click(function () {
    if ($(this).hasClass("menu-active")) {
        $(this).removeClass("menu-active");
    } else {
        $(".license").removeClass("menu-active");
        $(this).addClass("menu-active");
    }
    $('html,body').animate({
        scrollTop: 0
    }, 'slow');
});

// categories
$(".categories").click(function () {
    if ($(this).hasClass("menu-active")) {
        $(this).removeClass("menu-active");
    } else {
        $(".categories").removeClass("menu-active");
        $(this).addClass("menu-active");
    }
    $('html,body').animate({
        scrollTop: 0
    }, 'slow');
});

$(".clear-data").click(function () {
    $("a").removeClass("menu-active");
    $("#order").val('').trigger('change');
    $("#title").val(" ");
    get_data();
});

$(".search-data").on('click change', function (e) {
    var organization = ($(".organization.menu-active").attr('data-id') === undefined) ? "" : $(".organization.menu-active").attr('data-id');
    var format = ($(".format.menu-active").attr('data-id') === undefined) ? "" : $(".format.menu-active").attr('data-id');
    var license = ($(".license.menu-active").attr('data-id') === undefined) ? "" : $(".license.menu-active").attr('data-id');
    var categories = ($(".categories.menu-active").attr('data-id') === undefined) ? "" : $(".categories.menu-active").attr('data-id');
    var title = $("#title").val().trim();
    var order = $("#order").val().trim();
    var data = {
        'organization': organization,
        'format': format,
        'license': license,
        'categories': categories,
        'title': title,
        'order': order
    };
    get_data(data);
});

function get_data(data = {}) {
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        url: full_url + "/list-data",
        method: "post",
        data: data,
        success: function (result) {
            var str = '';
            $.each(result.data, function (index, value) {
                str += '<div class="col-md-12 featured-responsive"><div class="list-group"><a href="' + full_url + '/dataset/page/' + value.dts_url + '" class="list-group-item list-group-item-action">';
                if (result.is_login) {
                    var status = (value.dts_status == "pb") ? "Public" : "Private";
                    str += '<h5><span class="badge badge-secondary">' + status + '</span> ' + value.dts_title + ' </h5>';
                } else {
                    str += '<h5>' + value.dts_title + ' </h5>';
                }
                str += '<p>' + value.dts_description + '</p>';
                var format = value.format;
                if (format !== null) {
                    var arg = format.split(",");
                    $.each(unique_arg(arg), function (i, val) {
                        str += '<span class="label label-primary" style="margin-right: 3px;">' + val + '</span>';
                    });
                }
                str += '</a></div></div>';
                // str += '<span class="label label-primary">' + value.format + '</span></a></div></div>';
            });
            $("#result-data").html(str);
        },
        error(xhr, status, error) {
            alert(error);
        }
    });
}

function unique_arg(list) {
    var result = [];
    $.each(list, function (i, e) {
        if ($.inArray(e, result) == -1) result.push(e);
    });
    return result;
}

$("#file_type").on('change', function (e) {
    change_res();
});

function change_res(edit = false) {
    var type = $("#file_type").val();
    if (type === "w") {
        $("#div-web").show();
        $("#div-web input[type=url]").removeAttr("disabled");
        $("#div-web input[type=url]").attr("required", "required");

        $("#div-file").hide();
        $("#div-file input[type=file]").removeAttr("required");
        $("#div-file input[type=file]").attr("disabled", "disabled");
    } else {
        $("#div-file").show();
        $("#div-file input[type=file]").removeAttr("disabled");
        if (!edit) {
            $("#div-file input[type=file]").attr("required", "required");
        }

        $("#div-web").hide();
        $("#div-web input[type=url]").removeAttr("required");
        $("#div-web input[type=url]").attr("disabled", "disabled");
    }
}
