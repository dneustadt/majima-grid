$(document).ready(function() {
    window.majima.trumbowygConf = {
        svgPath: $('body').data('baseUrl') + '/plugins/MajimaGrid/Resources/icons/trumbowyg/icons.svg',
            btns: [
            ['viewHTML'],
            ['formatting'],
            'btnGrp-semantic',
            ['superscript', 'subscript'],
            ['link'],
            ['insertImage'],
            'btnGrp-justify',
            'btnGrp-lists',
            ['horizontalRule'],
            ['removeformat'],
            ['fullscreen'],
            ['foreColor'],
            ['backColor'],
            ['noembed'],
            ['preformatted'],
            ['table'],
            ['upload'],
            ['bgcolor']
        ]
    };

    window.majima.stopWysiwygEdit = function(e) {
        var editor = $('#editor');

        $(e.target).remove();
        editor.trumbowyg('destroy');
        editor.next('*[data-del-column="true"]').show();
        editor.attr('id', '').attr('style', '').bind('dblclick', $.proxy(majima.editColumn, majima));
        $('.has--editor').removeClass('has--editor');
    };

    $.subscribe("grid-widgets", function(e, grid) {
        grid.widgets.majima_wysiwyg = {
            'name': 'WYSIWYG Editor'
        };
    });

    $.subscribe("widget/majima_wysiwyg", function(e, majima, panelInner) {
        var panel = panelInner.closest('.col-panel');
        panel.addClass('has--editor');
        panelInner.trumbowyg(majima.trumbowygConf);
        panelInner.attr('id', 'editor').unbind('dblclick').off('mouseup');
        panel.find('*[data-del-column="true"]').hide();
        $(majima.overlay).appendTo('body').on('click', $.proxy(majima.stopWysiwygEdit, majima));
    });
});