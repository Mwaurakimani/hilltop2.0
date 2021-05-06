class Catalogue extends View {
    constructor(elem, stats, product = null) {
            super(elem, stats);
            this.catalogue_path = "views/Operations/catalogue/";

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
        //helper methods
    array_combine(fields, elements) {

        $.each(elements, (index, element) => {
            var field_name = element[1];
            $.each(fields, (title, value) => {
                if (field_name == title) {
                    if (element[0].length > 0) {
                        fields[title] = element[0].val();
                    }
                }
            });
        });

        return fields;
    }
    validate_data(data) {
        console.log(data);
        let temp = [
            "currentStock",
            "productName",
            "sale_price",
            "units"
        ];

        $.each(data, function(index, val) {
            $.each(temp, function(index1, val1) {
                if (val1 == index) {
                    if ((val == "") || (val == undefined)) {
                        alert("Some Fields were empty");
                        return false;
                    }
                }
            });
        });

        return data;
    }
    get_details() {
        let elements = [
            [$("[name='productId']"), "productId"],
            [$("[name='productName']"), "productName"],
            [$("[name='currentStock']"), "currentStock"],
            [$("[name='allow_stock_tracking']"), "allow_stock_tracking"],
            [$("[name='units']"), "units"],
            [$("[name='min_limit']"), "min_limit"],
            [$("[name='max_limit']"), "max_limit"],
            [$("[name='sale_price']"), "sale_price"],
            [$("[name='supply_price']"), "supply_price"],
            [$("[name='notes']"), "notes"]
        ];

        var fields = {
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

        let form_data = this.array_combine(fields, elements);

        var validated_data = this.validate_data(form_data);

        if (validated_data) {
            this.form_data = form_data;
            this.test = true;
            // spanner_loader
        } else {
            this.form_data = {
                productId: null,
                productName: "prodx",
                currentStock: 10,
                units: "Bottle",
                min_limit: 5,
                max_limit: 20,
                sale_price: 5000.00,
                supply_price: 4000.00,
                notes: "hello",
                allow_stock_tracking: true,
            };
            this.test = true;
        }

        return this;
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
    update_product(id) {
        this.get_details();

        if (!this.test) {
            return;
        }

        var bind_data = this.form_data;

        let uplink1 = null;

        let path1 = this.catalogue_path + 'catalogue_control.php';

        uplink1 = new uplink("update", path1, "update_product", "post", bind_data, call_back_success);

        function call_back_success(msg) {
            var data = JSON.parse(msg);
            if (data.status == true) {
                alert("Updated Successfully.");
            } else {
                alert("Not Successful.");
            }
        }

        return this;
    }
    delete_product(id) {

        let uplink1 = null;

        let path1 = this.catalogue_path + "catalogue_control.php";

        uplink1 = new uplink("delete", path1, "delete_product", "post", id, call_back_success);

        function call_back_success(msg) {
            var response = JSON.parse(msg);

            if (response.status == true) {
                alert(response.response);

                navigation_panel
                    .pre_def_intent('Catalogue')
                    .render_body_content(path.Operations.catalogue + 'list.php', catalogue_init);
            } else {
                alert("Error deleting product");
            }
        }
    }

    //renders
    render_product_form() {
        let path1 = this.catalogue_path + "form.php";

        $('#item_content').load(path1);
    }
    render_update() {
        var id = $(event.currentTarget).parent().find(".id_holder p").text();

        $.ajax({
                method: "POST",
                url: this.catalogue_path + "form.php",
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
let product = null;
let product_form = null;
var product_view = null;


const catalogue_init = (paren_caller) => {
    const catalogue_val = {
        name: "catalogue",
        title: "Catalogue",
        root: "Catalogue",
        content: null
    };

    catalogue = new Catalogue($('#item_content'), catalogue_val);
    view = catalogue.view;
    catalogue_table = new display_table(view.find('#catalog_panel_1'));

    catalogue.content = catalogue_table;
};