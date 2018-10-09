/* JS */
const $ = require('jquery');
require('bootstrap');
require('@fortawesome/fontawesome-free/js/all');
require('jquery.mmenu/dist/jquery.mmenu.all');

/* CSS */
require('../css/app.scss');



/* CUSTOM JS */
$(document).ready(() => {

    /* Ajax full screen loading */
    $(document).ajaxStart(function () {
        $("#loading").show();
        $("#loading").addClass('show');
    }).ajaxStop(function () {
        $("#loading").hide();
        $("#loading").removeClass('show');
    });

    /* jQuery.mmenu */
    $("#my-menu").mmenu({}, {});

});