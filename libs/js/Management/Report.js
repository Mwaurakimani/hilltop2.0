class Reports extends View {
    constructor(elem, stats, product = null) {
            super(elem, stats);
            this.catalogue_path = "views/Reports/";
        }
        //helper methods
}
let reports = null;
let reports_form = null;
var reports_view = null;


const reports_init = (paren_caller) => {
    const reports_val = {
        name: "reports",
        title: "reports",
        root: "reports",
        content: null
    };

    reports = new Catalogue($('#item_content'), reports_val);
    view = reports.view;
    reports_table = new display_table(view.find('#catalog_panel_1'));

    reports.content = reports_table;
};