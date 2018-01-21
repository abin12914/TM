$(function () {

    //handle link to tabs
    var url = document.location.toString();
    if (url.match('#')) {
        $('.nav-tabs-custom a[href="#' + url.split('#')[1] + '"]').tab('show');
    }

    // Change hash for page-reload
    $('.nav-tabs-custom a').on('shown.bs.tab', function (e) {
        window.location.hash = e.target.hash;
    });

    //action on rent measurement keyup
    $('body').on("click", ".arrows", function () {
        var link = $(this).attr("href");
        $('li a[href="'+ link +'"]').trigger('click');
    });
});