/**
 * Created by salmah on 11/6/15.
 */

$(function () {
    $(window).resize(function () {
        var h = Math.max($(window).height() - 2000, 1000);
        $('#container, #data, #tree, #data .content').height(h).filter('.default').css('lineHeight', h + 'px');
    }).resize();


    var tree_url = Routing.generate('app_backend_category_ajax');
    var tree = $('#tree');
    tree.jstree({
        "ui" : {
            // this makes the node with ID node_4 selected onload
            "initially_select" : [ "root" ]
        },
        'core': {
            'data': {
                type: "json",
                'url': tree_url,
                'data': function (node) {
                    return {
                        "operation" : "get_children",
                        "id" : node.attr ? node.attr("id").replace("node_","") : 1
                    };
                }
            },
            'check_callback': true

        },
        "file": {
            "icon": "glyphicon glyphicon-file",
            "valid_children": []
        },
        "animation": 1,
        "open_parents": true,
        "initially_open": ["1"],
        "themes": {"stripes": true},
        'force_text': false,
        'plugins': ["themes", 'dnd', "html_data", 'sort']
    });


    $("#add_default").click(function () {
        var ref = tree.jstree(true),
            sel = ref.get_selected();
        if (!sel.length) {
            return false;
        }
        sel = sel[0];
        sel = ref.create_node(sel);
        if (sel) {
            ref.edit(sel);
        }

    });

    $("#edit_category").click(function () {
        var ref = tree.jstree(true),
            sel = ref.get_selected();
        if (!sel.length) {
            return false;
        }
        sel = sel[0];

        var editUrl = Routing.generate('app_backend_category_edit', {'id': sel});
        window.open(editUrl);
    });

    $("#rename_category").click(function () {
        var ref = tree.jstree(true),
            sel = ref.get_selected();
        if (!sel.length) {
            return false;
        }
        sel = sel[0];
        ref.edit(sel);
    });

    $("#delete_category").click(function () {
        var ref = tree.jstree(true),
            sel = ref.get_selected();
        if (!sel.length) {
            return false;
        }
        if (sel == 1) {
            alert('Cannot delete root category');
        } else {
            ref.delete_node(sel);
        }
    });

    tree.on('delete_node.jstree', function (e, data) {
        var deleteUrl = Routing.generate('app_backend_category_delete', {'id': data.node.id});
        $.get(deleteUrl)
            .done(function () {
                data.instance.refresh();
            })
            .fail(function () {
                data.instance.refresh();
            });
    });
    tree.on('create_node.jstree', function (e, data) {
        var addUrl = Routing.generate('app_backend_category_add');
        $.post(addUrl, {
                'parent': data.node.parent,
                'name': data.node.text,
                'visibility': true
            })
            .done(function (d) {
                data.instance.set_id(data.node, d.id);
            })
            .fail(function () {
                data.instance.refresh();
            });
    });

    tree.on('rename_node.jstree', function (e, data) {
        var renameUrl = Routing.generate('app_backend_category_rename', {'id': data.node.id});
        $.post(renameUrl, {'name': data.node.text, 'visibility': true})
            .done(function (d) {
                data.instance.set_id(data.node, d.id);
                data.instance.refresh();
            })
            .fail(function () {
                data.instance.refresh();
            });
    });

    tree.on('changed.jstree', function (e, data) {
        if (data && data.selected && data.selected.length > 1) {
            $.get(tree_url, function (d) {
                $('#data .default').text(d.content).show();
            });
        }
        else {
            $('#data .content').hide();
            $('#data .default').text('Select a file from the tree.').show();
        }
    });

});

