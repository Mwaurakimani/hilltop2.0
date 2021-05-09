class stockControl extends View {
    constructor(elem, stats, product = null) {
        super(elem, stats);
        this.stockControl_path = "views/Operations/stockControl/";
    }


    // crud
    create_stockAction() {
        this.collect_stockAction_data();
        this.collect_subEntries_data();
        this.post_data();
    }
    resolve_transfer() {
        this.collect_stockAction_data();
        this.collect_resolve_data();
        this.resolve();
    }

    post_data() {

        var bind_data = {
            entry: this.entry,
            sub_entry: this.sub_entries
        };

        let path1 = this.stockControl_path + 'stock_controlHandler.php';

        let uplink1 = new uplink("create", path1, this.entry.type, "post", bind_data, this.success_fun);

        return this;
    }


    collect_resolve_data() {
        //collecting data
        var table = $(".body_holder>table");
        var tbody = table.children().eq(1);

        var sub_entries = [];

        var trs = tbody.find("tr");

        trs.each(function(index, value) {
            var sub_entry = null;

            var prod_id = $(value).children().eq(1).find("p").text();
            var units_taken = $(value).children().eq(3).find("p").text();
            var units_returned = $(value).children().eq(4).find("input").val();
            var amount_val = $(value).children().eq(5).find(".input>p").text();

            sub_entry = {
                prod_id: prod_id,
                units_taken: units_taken,
                units_returned: units_returned,
                amount: amount_val
            };

            sub_entries.push(sub_entry);
        });

        this.sub_entries = sub_entries;
    }
    collect_stockAction_data() {
        var type = null;
        var my_summary = null;
        var resolve = null;

        type = $("[name='action']").val();
        my_summary = $("[name='Summary']").val();
        resolve = $("[name='resolve']").val();

        this.entry = {
            type: type,
            summary: my_summary,
            resolve: resolve
        };

        return this;
    }
    collect_subEntries_data() {
        var action = this.entry.type;

        switch (action) {
            case "Add":
                this.add_products();
                this.success_fun = call_back_Add;

                function call_back_Add(msg) {
                    alert("Added Successfully.");
                    navigation_panel
                        .pre_def_intent('Stock Control')
                        .render_body_content('views/Operations/stockControl/stockControl.php', stock_handler_init);
                }
                break;
            case "Remove":
                this.remove_products();
                this.success_fun = call_back_Remove;

                function call_back_Remove(msg) {
                    alert("Removed Successfully");
                    navigation_panel
                        .pre_def_intent('Stock Control')
                        .render_body_content('views/Operations/stockControl/stockControl.php', stock_handler_init);
                }
                break;
            case "Transfer":
                this.transfer_products();
                this.success_fun = call_back_Transfer;

                function call_back_Transfer(msg) {
                    alert("Transferred Successfully");
                    navigation_panel
                        .pre_def_intent('Stock Control')
                        .render_body_content('views/Operations/stockControl/stockControl.php', stock_handler_init);
                }
                break;
            case "Return":
                this.return_products();
                this.success_fun = call_back_Return;

                function call_back_Return(msg) {
                    alert("System updated");
                    navigation_panel
                        .pre_def_intent('Stock Control')
                        .render_body_content('views/Operations/stockControl/stockControl.php', stock_handler_init);
                }
                break;
            default:
                alert("No action....");
                break;
        }
    }

    add_products() {
        var table = $(".body_holder>table");
        var tbody = table.children().eq(1);

        var sub_entries = [];

        var trs = tbody.find("tr");

        trs.each(function(index, value) {
            var sub_entry = null;

            var prod_id = $(value).children().eq(1).find("p").text();
            var prod_unit = $(value).children().eq(3).find("input").val();
            var prod_price = $(value).children().eq(4).find("input").val();

            sub_entry = {
                prod_id: prod_id,
                prod_unit: prod_unit,
                prod_price: prod_price
            };

            sub_entries.push(sub_entry);
        });

        this.sub_entries = sub_entries;
    }
    remove_products() {
        var table = $(".body_holder>table");
        var tbody = table.children().eq(1);

        var sub_entries = [];

        var trs = tbody.find("tr");

        trs.each(function(index, value) {
            var sub_entry = null;

            var prod_id = $(value).children().eq(1).find("p").text();
            var prod_unit = $(value).children().eq(3).find("input").val();
            var prod_price = $(value).children().eq(4).find("input").val();

            sub_entry = {
                prod_id: prod_id,
                prod_unit: prod_unit,
                prod_price: prod_price
            };

            sub_entries.push(sub_entry);
        });

        this.sub_entries = sub_entries;
    }
    transfer_products() {
        var table = $(".body_holder>table");
        var tbody = table.children().eq(1);

        var sub_entries = [];

        var trs = tbody.find("tr");

        trs.each(function(index, value) {
            var sub_entry = null;

            var prod_id = $(value).children().eq(1).find("p").text();
            var prod_unit = $(value).children().eq(3).find("input").val();
            var prod_price = $(value).children().eq(4).find("input").val();

            sub_entry = {
                prod_id: prod_id,
                prod_unit: prod_unit,
                prod_price: prod_price
            };

            sub_entries.push(sub_entry);
        });

        this.sub_entries = sub_entries;
    }
    return_products() {
        var table = $(".body_holder>table");
        var tbody = table.children().eq(1);

        var sub_entries = [];

        var trs = tbody.find("tr");

        trs.each(function(index, value) {
            var sub_entry = null;

            var prod_id = $(value).children().eq(1).find("p").text();
            var prod_unit = $(value).children().eq(3).find("input").val();
            var prod_price = $(value).children().eq(4).find("input").val();

            sub_entry = {
                prod_id: prod_id,
                prod_unit: prod_unit,
                prod_price: prod_price
            };

            sub_entries.push(sub_entry);
        });

        this.sub_entries = sub_entries;
    }

    resolve() {
        var id = $("[name='stockControl_ID']").val();
        var bind_data = {
            entry: this.entry,
            sub_entry: this.sub_entries,
            id: id
        };

        let path1 = this.stockControl_path + 'stock_controlHandler.php';

        let uplink1 = new uplink("update", path1, this.entry.type, "post", bind_data, callback);

        return this;

        function callback(msg) {
            // $("#dev_error_display").html(msg);
            alert("Resolved");
            navigation_panel
                .pre_def_intent('Stock Control')
                .render_body_content('views/Operations/stockControl/stockControl.php', stock_handler_init);
        }
    }



    //Action Control
    changeAction() {
        var elem = $(event.currentTarget);
        var change = elem.val();

        var el = null;
        var el2 = null;

        if (change == "Transfer") {
            el = $("[name='resolve']").children().eq(0).removeAttr("selected");
            el2 = $("[name='resolve']").children().eq(1).attr("selected", "selected");
        } else {
            el = $("[name='resolve']").children().eq(0).attr("selected", "selected");
            el2 = $("[name='resolve']").children().eq(1).removeAttr("selected");
        }

        $(".body_holder>table tbody").html("");
    }










































    get_products() {
        var elem = $(event.currentTarget);
        // var elem = $("#clicked_obj");
        var data = elem.val();
        var type = $("[name='action']").val();

        var bind_data = [data, type];

        let path1 = this.stockControl_path + 'list_product.php';

        let uplink1 = new uplink("read", path1, "get_product", "post", bind_data, call_back_success);

        function call_back_success(msg) {
            var parent = elem.parent().parent();

            var element_render = parent.find(".item_display");

            element_render.html(msg);
        }

        return this;
    }


    // action
    select_item(data) {
        var elem = $(event.currentTarget);
        var name = elem.children().eq(0).text();
        var Price = elem.children().eq(1).text();
        var quantity = elem.children().eq(2).text();
        elem.attr("data-id", data);

        var input = '' +
            '<tr class="selected">' +
            '<th scope="col">' +
            '<input type="checkbox" class="check_all">' +
            '</th>' +
            '<td style="overflow: auto;" class="id_holder">' +
            '<p>' + data + '</p>' +
            '</td>' +
            '<td class="name">' +
            '<p>' + name + '</p>' +
            '</td>' +
            '<td>' +
            '<div class="input">' +
            '<input type="number" min="1" value="1">' +
            '</div>' +
            '</td>' +
            '<td>' +
            '<div class="input">' +
            '<input type="number" min="1" value="0">' +
            '</div>' +
            '</td>' +
            '<td onclick="stockHandler.remover_item()">' +
            '<img src="' + root_domain + '/res/images/icons/trash.png" alt="">' +
            '</td>' +
            '</tr>';

        $('.body_holder tbody').append(input);
        var inp = $('#select_product .input_elem input');
        inp.val('');
    }



    //renders
    render_update() {
        var id = $(event.currentTarget).parent().find(".id_holder p").text();

        $.ajax({
                method: "POST",
                url: this.stockControl_path + "stockForm.php",
                data: id,
            })
            .done((msg) => {
                $('#item_content').html(msg);
            })
            .fail((msg) => {
                $('#item_content').html(msg);
            });
    }
    hide_selector() {
        $(".item_display").fadeOut();
    }
    show_selector() {
        $(".item_display").fadeIn();
    }
    remover_item() {
        var elem = $(event.currentTarget);
        elem.parent().remove();
    }
}
let stockHandler = null;

const stock_handler_init = (paren_caller) => {
    const stock_stats = {
        name: "stock_control",
        title: "Stock Control",
        root: "Stock_control",
    };
    stockHandler = new stockControl($('.item_content'), stock_stats);
};