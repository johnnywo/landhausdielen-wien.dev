/*
 * Application
 */

$(document).tooltip({
    selector: "[data-toggle=tooltip]"
})

$(document).ready(function() {
    $('.sidebar-navbar-collapse').on('click','.list-group-item', function ( e ) {
        e.preventDefault();
        $(this).parents('.sidebar-navbar-collapse').find('.active').removeClass('active').end().end().addClass('active');
        $(activeTab).show();
    });

});

