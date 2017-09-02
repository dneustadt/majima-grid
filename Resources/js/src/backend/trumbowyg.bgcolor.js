(function ($) {
    'use strict';

    $.extend(true, $.trumbowyg, {
        langs: {
            en: {
                bgcolor: 'Panel background color'
            }
        }
    });

    var defaultOptions = {
        colorList: [
            "red",
            "pink",
            "purple",
            "deep-purple",
            "indigo",
            "blue",
            "light-blue",
            "cyan",
            "teal",
            "green",
            "light-green",
            "lime",
            "yellow",
            "amber",
            "orange",
            "deep-orange",
            "brown",
            "blue-grey",
            "grey",
            "white",
            "black",
            "transparent"
        ]
    };

    $.extend(true, $.trumbowyg, {
        plugins: {
            bgcolor: {
                init: function (trumbowyg) {
                    trumbowyg.o.plugins.bgcolor = trumbowyg.o.plugins.bgcolor || defaultOptions;
                    var bgPanelBtnDef = {
                            dropdown: buildBgDropdown('bgcolor', trumbowyg)
                        };

                    trumbowyg.addBtnDef('bgcolor', bgPanelBtnDef);
                }
            }
        }
    });

    function buildBgDropdown(fn, trumbowyg) {
        var dropdown = [];

        $.each(trumbowyg.o.plugins.bgcolor.colorList, function (k, color) {
            var shades = [' lighten-5', ' lighten-4', ' lighten-3', ' lighten-2', ' lighten-1', '', ' darken-1', ' darken-2', ' darken-3', ' darken-4'];
            for (var i = 0; i < shades.length; i++) {
                if((color === 'white' || color === 'black' || color === 'transparent') && shades[i] !== '') {
                    continue;
                }
                var shade = shades[i],
                    btn = ' ' + color + shade + ' ',
                    btnDef = {
                        fn: function (btn) {
                            $(trumbowyg.$c).closest('.col-panel').attr('class', 'col-panel' + btn + 'has--editor');
                        },
                        forceCss: true,
                        style: 'padding:0;margin:0;overflow:hidden;font-size:10px;'
                    };
                trumbowyg.addBtnDef(btn, btnDef);
                dropdown.push(btn);
            }
        });

        return dropdown;
    }
})(jQuery);
