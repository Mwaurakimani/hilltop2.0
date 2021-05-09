class Sale extends View {
    constructor(elem, stats, product = null) {
        super(elem, stats);
        this.sales_path = "views/Operations/sales/";

        if (product == null) {
            this.product = {
                productId: null,
                productName: null,
                currentStock: null,
                units: null,
                min_limit: null,
                max_limit: null,
                sale_price: null,
                supply_price: null,
                notes: null,
                allow_stock_tracking: null,
            };
        }
    }


    // crud
    create_product() {

        this.get_details();
        if (!this.test) {
            return;
        }
        var bind_data = this.form_data;

        let path1 = this.catalogue_path + 'catalogue_control.php';

        let uplink1 = new uplink("create", path1, "create_product", "post", bind_data, call_back_success);

        function call_back_success(msg) {
            var data = JSON.parse(msg);
            alert(data.response_stmt);
        }

        return this;
    }


    //renders
    render_product_form() {
        let path1 = this.catalogue_path + "form.php";

        $('#item_content').load(path1);
    }
    render_sale() {
        var id = $(event.currentTarget).parent().find(".id_holder p").text();

        $.ajax({
                method: "POST",
                url: this.sales_path + "salesView.php",
                data: id,
            })
            .done((msg) => {
                $('#item_content').html(msg);
            })
            .fail((msg) => {
                $('#item_content').html(msg);
            });
    }
}
let Sale_handler = null;

const sale_init = (paren_caller) => {
    const sale_val = {
        name: "sale",
        title: "sale",
        root: "sale",
    };
    Sale_handler = new Sale($('.sale_detail_elem'), sale_val);

    console.log(Sale_handler);
    pos_init();
};