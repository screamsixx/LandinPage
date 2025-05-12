$(document).ready(function () {
    var last_scroll_top = 0;
    $(window).on('scroll', function() {
        scroll_top = $(this).scrollTop();
        if(scroll_top > last_scroll_top) {
            $('.navbar-910').collapse('hide')
        }
        last_scroll_top = scroll_top;
    });
})