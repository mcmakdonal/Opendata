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
            pagi_init(result.totalPages, result.startPage);
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
