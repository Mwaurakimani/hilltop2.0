class Catalogue extends View {
    constructor(elem, stats) {
        super(elem, stats);
        this.list_path = "views/";
    }
    render_list_view() {

    }
}
let catalogue = null;
let catalogue_table = null;


const catalogue_init = (paren_caller) => {
    console.log("here");
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

    console.log(catalogue_table);

    perform();
};

function perform() {

}