/* JS */
const $ = require('jquery');
require('bootstrap');
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

    /* Hamburger */
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
                "<a href='#'><i class='fa fa-home'></i></a>",
                "<a href='#'><i class='fa fa-user'></i></a>"
            ],
            "bottom": [
                "<a href='#'><i class='fa fa-twitter'></i></a>",
                "<a href='#'><i class='fa fa-facebook'></i></a>",
                "<a href='#'><i class='fa fa-linkedin'></i></a>"
            ]
        },
        "navbars": [
            {
                "position": "top",
                "content": [
                    "<a class='fa fa-envelope' href='#'></a>",
                    "<a class='fa fa-twitter' href='#'></a>",
                    "<a class='fa fa-facebook' href='#'></a>"
                ]
            },
            {
                "position": "bottom",
                "content": [
                    "<a class='fa fa-envelope' href='#'></a>",
                    "<a class='fa fa-twitter' href='#'></a>",
                    "<a class='fa fa-facebook' href='#'></a>"
                ]
            }
        ],

    }, {});

    let $hamburger = $(".hamburger");
    let api = $("#my-menu").data( "mmenu" );

    api.bind("open:finish", () => {
        $hamburger.addClass("is-active");
    }).bind("close:finish", () => {
        $hamburger.removeClass("is-active");
    });

});
