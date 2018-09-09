$(document).ready(function() {
    $(".use-select2").select2();
});

function read_filename(e){
    var name = $(e).val().split(/(\\|\/)/g).pop();
    $("#file_name").val(name);
}

function remove_dts(e) {
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
                window.location.replace(url);
                break;
            case "no":
                swal("Message!", "Cancel", "warning");
                break;
            default:
        }
    });
}


function remove_ogz(e) {
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
                window.location.replace(url);
                break;
            case "no":
                swal("Message!", "Cancel", "warning");
                break;
            default:
        }
    });
}
