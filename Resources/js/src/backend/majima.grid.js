$(document).ready(function() {
    window.majima = {
        dragula: null,
        defaultColumn: '<div class="col-panel"><div class="col-panel--inner" data-column-edit="true" data-widget-type="%s"></div><a class="del-column button button-small" data-del-column="true"><span class="typcn typcn-minus"></span></a></div>',
        defaultRow: '<div class="row"><a class="add-column button button-small" data-add-column="true"><span class="typcn typcn-plus"></span> Column</a></div>',
        overlay: '<div class="js--overlay"></div>',
        widgets: {},
        init: function() {
            var me = this;

            me.registerEvents();
            me.initDragula();
            me.initContextMenu();
        },
        registerEvents: function() {
            $('*[data-del-column="true"]').bind('click', $.proxy(this.delColumn, this));
            $('*[data-add-column="true"]').bind('click', $.proxy(this.addColumn, this));
            $('*[data-add-row="true"]').bind('click', $.proxy(this.addRow, this));
            $('*[data-column-edit="true"]').bind('dblclick', $.proxy(this.editColumn, this));
            $('*[data-save-grid="true"]').bind('click', $.proxy(this.saveGrid, this));
            $('*[data-revision-select="true"]').bind('change', $.proxy(this.changeRevision, this));
        },
        initDragula: function() {
            this.dragula = dragula($('.container.is--editable .row').toArray());
        },
        initContextMenu: function() {
            var me = this;

            $.contextMenu({
                selector: '*[data-add-column="true"]',
                build: function ($trigger, e) {
                    $.publish('grid-widgets', [ me ]);
                    return {
                        callback: function (key, options) {
                            var widgetType = key,
                                columnElement = me.defaultColumn.replace(/%s/g, widgetType),
                                target = $(e.target).parent('.add-column').length ? $(e.target).parent('.add-column') : $(e.target),
                                newColumn = $(columnElement).insertBefore(target);
                            newColumn.children('*[data-column-edit="true"]').bind('dblclick', $.proxy(me.editColumn, me));
                            newColumn.children('.del-column').on('click', $.proxy(me.delColumn, me));
                        },
                        items: me.widgets
                    }
                }
            });
        },
        delColumn: function(e) {
            e.preventDefault();

            var target = $(e.target).parent('.del-column').length ? $(e.target).parent('.del-column') : $(e.target);

            target.parent().remove();
        },
        addColumn: function(e) {
            e.preventDefault();

            $(e.target).contextMenu();
        },
        addRow: function(e) {
            e.preventDefault();

            var target = $(e.target).parent('.add-row').length ? $(e.target).parent('.add-row') : $(e.target),
                newRow = $(this.defaultRow).insertBefore(target),
                addRowButton = target.clone(),
                index = $(newRow).index();
            $(newRow).children('*[data-add-column="true"]').on('click', $.proxy(this.addColumn, this));
            $(addRowButton).insertBefore(newRow).on('click', $.proxy(this.addRow, this));
            $.each($('.container.is--editable .row').toArray(), function(i, el) {
                if($(el).index() === $(newRow).index()){
                    index = i;
                }
            });
            this.dragula.containers.splice(index, 0, newRow.get(0));
        },
        editColumn: function(e) {
            var target = $(e.target),
                panelInner = target.is('[data-column-edit]') ? target : target.closest('*[data-column-edit="true"]');
            $.publish('widget/' + panelInner.data('widgetType'), [ this, panelInner ]);
        },
        saveGrid: function(e) {
            e.preventDefault();

            var rows = {'rows': []},
                rowIndex = 0;

            $.each(this.dragula.containers, function(i, row) {
                if(row.childElementCount > 1){
                    rows['rows'][rowIndex] = [];
                    var colIndex = 0;
                    $.each(row.children, function(i, col) {
                        if(!$(col).hasClass('add-column')) {
                            rows['rows'][rowIndex][colIndex] = {
                                'subject': $(col).find('*[data-column-edit="true"]').html(),
                                'type': $(col).find('*[data-column-edit="true"]').data('widgetType'),
                                'classes': $(col).attr('class')
                            };
                            colIndex++;
                        }
                    });
                    rowIndex++;
                }
            });

            $.ajax({
                type: 'POST',
                url: $(e.target).data('url'),
                data: JSON.stringify(rows),
                success: function(data) {
                    var body = $('body');
                    window.location.href = body.data('baseUrl') + body.data('pathInfo');
                },
                contentType: "application/json",
                dataType: 'json'
            });
        },
        changeRevision: function(e) {
            e.preventDefault();

            var revision = $(e.target).val(),
                body = $('body');

            window.location.href = body.data('baseUrl') + body.data('pathInfo') + '?r=' + revision;
        }
    };

    window.majima.init();
});