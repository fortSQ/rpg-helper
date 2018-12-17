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

    /* jQuery.mmenu
    -------------------------------------------------- */

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



    /* Login / Register
    -------------------------------------------------- */

    $("input[type='password'][data-eye]").each(function(i) {
        var $this = $(this),
            id = 'eye-password-' + i,
            el = $('#' + id);

        $this.wrap($("<div/>", {
            style: 'position:relative',
            id: id
        }));

        $this.css({
            paddingRight: 60
        });
        $this.after($("<div/>", {
            html: 'Show',
            class: 'btn btn-primary btn-sm',
            id: 'passeye-toggle-'+i,
        }).css({
            position: 'absolute',
            right: 10,
            top: ($this.outerHeight() / 2) - 12,
            padding: '2px 7px',
            fontSize: 12,
            cursor: 'pointer',
        }));

        $this.after($("<input/>", {
            type: 'hidden',
            id: 'passeye-' + i
        }));

        var invalid_feedback = $this.parent().parent().find('.invalid-feedback');

        if(invalid_feedback.length) {
            $this.after(invalid_feedback.clone());
        }

        $this.on("keyup paste", function() {
            $("#passeye-"+i).val($(this).val());
        });
        $("#passeye-toggle-"+i).on("click", function() {
            if($this.hasClass("show")) {
                $this.attr('type', 'password');
                $this.removeClass("show");
                $(this).removeClass("btn-outline-primary");
            }else{
                $this.attr('type', 'text');
                $this.val($("#passeye-"+i).val());
                $this.addClass("show");
                $(this).addClass("btn-outline-primary");
            }
        });
    });

    $(".my-login-validation").submit(function() {
        var form = $(this);
        if (form[0].checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.addClass('was-validated');
    });

});
