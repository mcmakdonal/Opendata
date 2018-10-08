var $pagination = $('#pagination');
var defaultOpts = {
    totalPages: 1
};
$pagination.twbsPagination(defaultOpts);

function get_data(page = 1) {
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
        'order': order,
        'page': page
    };

    var organization_name = ($(".organization.menu-active").attr('data-id') === undefined) ? "" : $(".organization.menu-active").attr('data-name');
    var categories_name = ($(".categories.menu-active").attr('data-id') === undefined) ? "" : $(".categories.menu-active").attr('data-name');

    if(organization_name==''&categories_name==''){
        $("#title_dataset").html('DATASET');
    }else if(organization_name!==''&categories_name==''){
        $("#title_dataset").html(organization_name);
    }else if (organization_name==''&categories_name!==''){
        $("#title_dataset").html(categories_name);
    }else{
        $("#title_dataset").html(organization_name+' > '+categories_name);
    }

    update_filter(data);

    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        url: full_url + "/list-data",
        method: "post",
        data: data,
        beforeSend() {
            // $.LoadingOverlay("show");
            $("#result-data").LoadingOverlay("show", {
                fontawesome: "fa fa-circle-o-notch fa-spin"
            });
        },
        success: function (result) {
            var str = '';
            $.each(result.data, function (index, value) {
                str += '<div class="col-md-12 featured-responsive"><div class="list-group"><a href="' + full_url + '/dataset/page/' + value.dts_url + '" class="list-group-item list-group-item-action box_data">';
                str +='<h4 style="float: right;color: #8e2e70;font-size:16px">'+value.cat_title+'</h4>';
                if (result.is_login) {
                    var status = (value.dts_status == "pb") ? "Public" : "Private";
                    str += '<h4><img src="' + full_url + '/backend/assets/img/icon_items_pink.png">' + value.dts_title + ' <span class="badge badge-secondary">' + status + '</span> </h4>';
                    
                } else {
                    str += '<h4><img src="' + full_url + '/backend/assets/img/icon_items_pink.png">' + value.dts_title + ' </h4>';
                }
                str += '<p style="padding-left: 25px;" >' + value.dts_description + '</p>';
                var format = value.format;
                if (format !== null) {
                    var arg = format.split(",");
                    str += '<div style="padding-left: 25px;">';
                    $.each(unique_arg(arg), function (i, val) {
                        if (val !== '') {
                            str += '<img src="' + full_url + '/backend/assets/img/tag_' + val + '.png" style="margin-right: 3px;width: 45px;">';
                        }
                    });
                    str += '</div>';
                }
                str += '</a></div></div>';
                // str += '<span class="label label-primary">' + value.format + '</span></a></div></div>';
            });
            $("#result-data").LoadingOverlay("hide", true);
            pagi_init(result.totalPages, result.startPage);
            $("#result-data").html(str);
            $('html,body').animate({
                scrollTop: 0
            }, 'slow');
            $(".star").css({
                'float': 'right',
                'font-size': '15px',
                'padding': '5px'
            });
        },
        error(xhr, status, error) {
            // alert(error);
        }
    });
}

function update_filter(data) {
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                "content"
            )
        },
        url: full_url + "/filter-cat",
        method: "post",
        data: data,
        success: function (obj) {
            $("a.organization li span").html("(0)");
            for (i = 0; i < obj['data'].length; i++) {
                $("a[data-id=" + obj['data'][i]['ogz_id'] + "].organization li span").html("(" + obj['data'][i]['sum'] + ")");
            };
        },
        error(xhr, status, error) {
            // alert(error);
        }
    });

    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                "content"
            )
        },
        url: full_url + "/filter-ogz",
        method: "post",
        data: data,
        success: function (obj) {
            $("a.categories li span").html("(0)");
            for (i = 0; i < obj['data'].length; i++) {
                $("a[data-id=" + obj['data'][i]['cat_id'] + "].categories li span").html("(" + obj['data'][i]['sum'] + ")");
            };
        },
        error(xhr, status, error) {
            // alert(error);
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


function pagi_init(totalPages, startPage) {
    $pagination.twbsPagination('destroy');
    $pagination.twbsPagination({
        totalPages: totalPages,
        // the current page that show on start
        startPage: startPage,

        // maximum visible pages
        visiblePages: (totalPages > 5) ? 5 : totalPages,

        initiateStartPageClick: false,

        // template for pagination links
        href: false,

        // variable name in href template for page number
        hrefVariable: '{{number}}',

        // Text labels
        first: 'หน้าแรก',
        prev: 'ก่อนหน้า',
        next: 'หน้าต่อไป',
        last: 'หน้าสุดท้าย',

        // carousel-style pagination
        loop: false,

        // callback function
        onPageClick: function (event, page) {
            console.log(page);
            get_data(page);
        },

        // pagination Classes
        paginationClass: 'pagination',
        nextClass: 'next',
        prevClass: 'prev',
        lastClass: 'last',
        firstClass: 'first',
        pageClass: 'page',
        activeClass: 'active',
        disabledClass: 'disabled'

    });
}

function set_star(point) {
    var str = '';
    for (var i = 1; i <= point; i++) {
        str += '<i class="fa fa-star" aria-hidden="true"></i>';
        str += '&nbsp;';
    }

    return str;
}

function beautiful_star() {
    if ($(".star").length > 0) {
        var arr = $(".star").html();
        var star = parseInt(arr);
        var str = 'คะแนนการเปิดเผย : ';
        for (var i = 1; i <= star; i++) {
            str += '<i class="fa fa-star" aria-hidden="true"></i>';
            str += '&nbsp;';
        }
        $(".star").css({
            'float': 'right',
            'font-size': '15px',
            'padding': '5px'
        });
        $(".star").html(str);
    }
}


function beautiful_tag() {
    if ($(".tags").length > 0) {
        var arr = $(".tags").html().split(',');
        var str = 'Tag : ';
        var style = ['default', 'primary', 'success', 'info', 'warning', 'danger'];
        for (i = 0; i < arr.length; i++) {
            var random = style[Math.floor(Math.random() * style.length)];
            str += '<span class="label label-' + random + '">' + arr[i] + '</span>';
            str += '&nbsp;';
        }

        $(".tags").html(str);
    }
}


var x=1000;
        function add_table(){
            x++;
            var html = "<tr id='tr"+x+"' >\n" +
"												<td><input type=\"text\" value=\"\" class=\"form-control\" name=\"field_name[]\"  required></td>\n" +
"												<td><input type=\"text\" value=\" \" class=\"form-control\" name=\"description[]\"  ></td>\n" +
"												<td><input type=\"text\" value=\"\" class=\"form-control\" name=\"field_type[]\"  required></td>\n" +
"												<td><input type=\"text\" value=\" \" class=\"form-control\" name=\"unit[]\"  ><input type=\"text\" value=\"1\" class=\"form-control\" style=\"display:none\" name=\"type[]\" ></td>\n" +
"                                               <td><button type=\"button\" class=\"btn btn-danger metadata_btn\" onclick=\"del_btn('"+x+"')\"><i class=\"glyphicon glyphicon-trash\"></i></button></td>\n" +
"											</tr>";
            $("#data_body").append(html);
        }

        function del_btn(x){
           
            $("#tr"+x).remove();
        }


        function remove_metadata(id,url) {
    swal("คุณต้องการลบ Metadata นี้ ?", {
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
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        )
                    },
                    url: "/dataset/delete_metadata/"+id,
                    method: "get",
                    beforeSend() {
                        $.LoadingOverlay("show");
                    },
                    success: function (result) {
                        console.log(result);
                        var obj = result;
                        $.LoadingOverlay("hide");
                        if (obj.status) {
                            window.location.replace("/dataset/edit/"+url);
                        } else {
                            swal("Fail !", "ไม่สามารถลบข้อมูลได้", "error");
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
var elements = document.querySelectorAll('input,select,textarea');

for (var i = elements.length; i--;) {
    elements[i].addEventListener('invalid', function () {
        this.scrollIntoView(false);
    });
}