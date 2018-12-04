/* JS LIBRARIES */

const $  = require('jquery');
require('datatables.net-bs4');
require('bootstrap');
require('jquery.mmenu/dist/jquery.mmenu.all');
require('jquery.mmenu/dist/wrappers/bootstrap/jquery.mmenu.bootstrap4');
require('@fortawesome/fontawesome-free/js/all');

/* CSS */

require('../css/app.scss');

/* CUSTOM JS */

$(document).ready(() => {

    /* DataTables */
    $('#data-table').DataTable();

    /* Вывод изображения при наведении на название-ссылку */
    $(function () {
        $('[data-toggle="image-popover"]').popover({
            trigger: 'hover',
            placement: 'right',
            html: true,
            boundary: 'window',
            fallbackPlacement: 'clockwise',
            container: 'body',
        })
    });

    /* jQuery.mmenu */
    $(".navbar-collapse").mmenu({
        wrappers: ["bootstrap4"],
        extensions: [
            "border-full",
            "multiline",
            "pagedim-black",
            "position-left",
            "position-back",
            "shadow-page",
            "shadow-panels",
        ],
        "iconbar": {
            "add": true,
            "top": [

            ],
            "bottom": [

            ]
        },
        "navbars": [
            {
                "position": "top",
                "content": [
                    "<a href='#'><i class='fas fa-home'></i></a>",
                    "<a href='#'><i class='fa fa-user-alt'></i></a>",
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
