class POS extends View {
    constructor(elem, stats) {
        super(elem, stats);
        this.pos_path = "views/Operations/POS/";
        this.payments = [];
        this.sales = [];
    }

    // crud
    create_sale() {
        var bind_data = this.bind_data;

        let path1 = this.pos_path + 'sale_action.php';

        let uplink1 = new uplink("create", path1, "create_sale", "post", bind_data, call_back_success);

        function call_back_success(msg) {
            var data = JSON.parse(msg);
            alert(data.response);
            navigation_panel
                .pre_def_intent('P.O.S')
                .render_body_content(path.Operations.POS + 'POS.php', $('.item_content').init(pos_init));
        }

        return this;
    }

    //view functions
    get_item() {
        var elem = $(event.currentTarget);
        // var elem = $("#clicked_obj");
        var data = elem.val();

        var bind_data = data;

        let path1 = this.pos_path + 'list_product.php';

        let uplink1 = new uplink("read", path1, "get_product", "post", bind_data, call_back_success);

        function call_back_success(msg) {
            var parent = elem.parent();
            var element_render = parent.find(".search_display");

            // $("#dev_error_display").html(msg);

            element_render.html(msg);
        }

        return this;
    }
    select_item(data) {
        var elem = $(event.currentTarget);
        var name = elem.children().eq(0).text();
        var Price = elem.children().eq(1).text();
        var quantity = elem.children().eq(2).text();
        elem.attr("data-id", data);

        var tr_parent = elem.closest(".product-name").parent();

        tr_parent.children().eq(0).html(data);
        tr_parent.children().eq(1).find("input").val(name);
        tr_parent.children().eq(2).find("input").val(1);
        tr_parent.children().eq(2).find("input").attr("max", quantity);
        tr_parent.children().eq(3).html(Price);
        var sub_total = parseInt(Price) * 1;
        tr_parent.children().eq(4).html(sub_total);


        var temp_tr = ('' +
            '<tr>' +
            '<th scope="row">#</th>' +
            '<td class="product-name">' +
            '<div class="prod_search_elem">' +
            '<input autocomplete="off" type="text" onfocus="pos_obj.open_search_display()" onblur="pos_obj.close_search_display()" onkeyup="pos_obj.get_item()">' +
            '<div class="search_display">' +
            '<div class="no_item">' +
            '<p>No items to select from...</p>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</td>' +
            '<td class="quantity">' +
            '<input type="number" min=1 value="0" onchange="pos_obj.render_sub_sum()">' +
            '</td>' +
            '<td class="price"></td>' +
            '<td></td>' +
            '<td onclick="pos_obj.remove_product()">' +
            '<img src="' + root_domain + '/res/images/icons/remove_product.png" alt="">' +
            '</td>' +
            '</tr>' +
            '');

        var el = $('.sale_detail_elem>.table_view>table');
        el.append(temp_tr);
        this.render_sub_sum();
    }
    remove_product() {
        var elem = $(event.currentTarget);

        elem.parent().remove();
        this.render_sub_sum();
    }
    render_sub_sum() {
        //render sub Total
        var elem = $('.sale_detail_elem>.table_view>table>tbody>tr');
        var count = 0;

        var action_elem = $(event.currentTarget);
        var subtotal_elem = action_elem.parent().parent().children().eq(4);
        var quantity = action_elem.parent().parent().children().eq(2).find("input").val();
        var price = action_elem.parent().parent().children().eq(3).text();
        var sub_total = parseInt(price) * parseInt(quantity);
        subtotal_elem.text(sub_total);


        elem.each(function(index, value) {
            var tr = $(value);

            var this_price = tr.children().eq(3).text();
            var this_quantity = tr.children().eq(2).find("input").val();
            var sub_total = parseInt(this_price) * parseInt(this_quantity);

            if (!isNaN(sub_total)) {
                count = count + sub_total;
            }
        });

        var el2 = $("#sale_Amount");
        el2.text(count);
        this.sale_price = count;

        this.bind_balance();
    }
    confirm_sale() {
        var table_rows = $(".sale_detail_elem>.table_view>table>tbody>tr");
        var quantity = 0;
        var amount = 0;
        var sales = [];

        table_rows.each(function(index, value) {
            var id = $(value).children().eq(0).text();
            if (id != "#") {
                id = parseInt(id);
                var temp_quantity = parseInt($(value).children().eq(2).find("input").val());
                var temp_subtotal = parseInt($(value).children().eq(4).text());
                var sale = [id, temp_quantity];
                sales.push(sale);
            } else {
                return false;
            }
        });

        this.sale = sales;
        var transactions = (this.payments).length;

        if (parseInt($('#rem_balance').text()) === 0) {
            if (transactions != 0) {
                var data = {
                    sales: this.sale,
                    transaction: this.payments
                };

                this.bind_data = data;

                console.log(data);

                this.create_sale();
            } else {
                alert("No values Entered!");
            }
        } else {
            alert("Balance Remaining!");
        }
    }
    bind_balance() {
        let sale_amount = this.sale_price;
        this.bind_payments();
        let total_payed = this.total_payed;
        let balance = sale_amount - total_payed;

        var el3 = $('#rem_balance');
        el3.text(balance);
    }
    bind_payments() {
        var total_payed = 0;
        var transactions = this.payments;

        $.each(transactions, function(index, value) {
            var amount = parseInt(value.amount);

            total_payed = total_payed + amount;
        });

        this.total_payed = total_payed;
    }
    make_payment() {
        var bal = parseInt($('#rem_balance').text());

        if (bal <= 0) {
            return false;
        }
        let elem = $(event.currentTarget);
        let parent = elem.parent();

        var amount = parent.find("[name='amount_payed']").val();
        var method = parent.find("[name='payment_method']").val();

        let transaction = {
            amount: amount,
            method: method
        };

        if (amount <= 0) {
            alert("No amount Entered!!!");
            return false;
        } else {
            (this.payments).push(transaction);

            var elem_transactions = $(".transactions");

            var append_elem = '' +
                '<div class="transaction_elem">' +
                '<div class="holder">' +
                '<div class="item_holder">' +
                '<p>Method:</p>' +
                '<p>' + method + '</p>' +
                '</div>' +
                '<div class="item_holder">' +
                '<p>Amount:</p>' +
                '<p>' + amount + '</p>' +
                '</div>' +
                '</div>' +
                '<div class="remover" onclick="pos_obj.remove_transaction()">' +
                'X' +
                '</div>' +
                '</div>' +
                '';

            elem_transactions.append(append_elem);

            this.bind_balance();
        }
    }
    view_transactions() {
        console.log(this.payments);
    }
    remove_transaction() {
        var elem = $(event.currentTarget);
        var parent = elem.parent();

        parent.remove();

        var temp_method = parent.children().eq(0).children().eq(0).children().eq(1).text();
        var temp_cash = parent.children().eq(0).children().eq(1).children().eq(1).text();

        var transactions = this.payments;

        $.each(transactions, function(index, value) {
            var amount = value.amount;
            var meth = value.method;

            if (temp_cash == amount && temp_method == meth) {
                transactions.pop(value);
                return false;
            }
        });
        this.bind_balance();
        this.payments = transactions;
    }

    //renders
    open_search_display() {
        let elem = $(event.currentTarget);
        let parent = elem.parent();
        var search_display = parent.find(".search_display");
        search_display.fadeIn("fast");
    }
    close_search_display() {
        let elem = $(event.currentTarget);
        let parent = elem.parent();
        let search_display = parent.find(".search_display");
        search_display.fadeOut("fast");
    }
    toggle_transactions() {
        let elem = $('.transactions');

        elem.toggle();
    }
}
let pos_obj = null;

const pos_init = () => {
    const pos_val = {
        name: "pos",
        title: "pos",
        root: "POS",
    };

    pos_obj = new POS($('.sale_detail_elem'), pos_val);

    // window.setInterval(function() {
    //     perform();
    // }, 800);
};

function perform() {
    // pos_obj.get_item();
}