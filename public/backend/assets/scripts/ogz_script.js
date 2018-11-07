var $pagination_ogz = $('#pagination_ogz');
var defaultOpts = {
    totalPages: 1,
    // Text labels
    first: 'หน้าแรก',
    prev: 'ก่อนหน้า',
    next: 'หน้าต่อไป',
    last: 'หน้าสุดท้าย',
};
$pagination_ogz.twbsPagination(defaultOpts);

function get_dts_data(page = 1) {
    var organization = ($("#organization_id").val() == "") ? "" : $("#organization_id").val();
    var order = $("#dts-order").val().trim();
    var title = $("#title").val().trim();
    var data = {
        'organization': organization,
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
        beforeSend() {
            $("table.ogz-dts tbody").LoadingOverlay("show", {
                fontawesome: "fa fa-circle-o-notch fa-spin"
            });
        },
        success: function (result) {
            var str = '';
            $("table.ogz-dts tbody").html(str);
            $.each(result.data, function (index, value) {
                var status = (value.dts_status == "pb") ? "สาธารณะ" : "ส่วนตัว";
                var label = (value.dts_status == "pb") ? "primary" : "danger";
                str += '<tr><td>';
                str += '<div class="checkbox">';
                str += '    <label><input type="checkbox" name="url" value="' + value.dts_url + '"></label>';
                str += '</div></td>';
                str += '<td colspan="3">';
                str += '    <h5> <span class="label label-'+label+'">' + status + '</span> ' + value.dts_title + ' </h5>';
                str += '</td></tr>';
            });
            $("table.ogz-dts tbody").LoadingOverlay("hide", true);
            pagi_ogz_init(result.totalPages, result.startPage);
            $("table.ogz-dts tbody").html(str);
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
            $("table.ogz-dts tbody").LoadingOverlay("hide", true);
            swal("Fail !", error + " Status : " + status, "error");
        }
    });
}


function pagi_ogz_init(totalPages, startPage) {
    $pagination_ogz.twbsPagination('destroy');
    $pagination_ogz.twbsPagination({
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
            // console.log(page);
            get_dts_data(page);
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
