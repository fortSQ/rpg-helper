/* JS */
const $ = require('jquery');
require('bootstrap');
require('jquery.mmenu/dist/jquery.mmenu.all');
require('@fortawesome/fontawesome-free/js/all');

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
    $("#menu").mmenu({
        extensions: [
            "border-full",
            "fx-menu-slide",
            "multiline",
            "pagedim-black",
            "position-right",
            "position-back", // position-front
            "shadow-page",
            "shadow-panels",
            //"theme-dark"
        ],
        "iconbar": {
            "add": true,
            "top": [
                "<a href='#'><i class='fas fa-home'></i></a>",
                "<a href='#'><i class='fas fa-user'></i></a>",
                "<a href='#'><i class='fab fa-d-and-d'></i></a>"
            ]
        },
        "navbars": [
            {
                "position": "top",
                "content": [
                    "<a href='#'><i class='fa fa-dice'></i></a>",
                    "<a href='#'><i class='fas fa-dice-d6'></i></a>",
                    "<a href='#'><i class='fas fa-box'></i></a>",
                    "<a href='#'><i class='fas fa-cogs'></i></a>"
                ]
            },
            {
                "position": "bottom",
                "content": [

                ]
            }
        ],
    }, {});

});
