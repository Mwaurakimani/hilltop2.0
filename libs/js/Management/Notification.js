class Notifications extends View {
    constructor(elem, stats, product = null) {
        super(elem, stats);
        this.notification = "views/Management/Notification";
    }

}
let notification = null;
let notification_form = null;
var notification_view = null;


const notification_init = (paren_caller) => {
    const notification_val = {
        name: "notification",
        title: "notification",
        root: "notification",
        content: null
    };

    notification = new Catalogue($('#item_content'), notification_val);
    view = notification.view;
    notification_table = new display_table(view.find('#catalog_panel_1'));

    notification.content = notification_table;
};