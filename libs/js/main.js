const pathToJs = "libs/js/";
const importsObject = {
    //3rd party
    liveJs: `3rd_party/liveJs.js`,

    //config file
    config: `config/config.js`,

    //system files
    //classes
    components: "system/classes/components.js",
    views: "system/classes/views.js",
    mixins: "system/classes/mixins.js",
    modules: "system/classes/module.js",
    uplink: "system/classes/uplink.js",

    //management
    notification: "Management/Notification.js",
    report: "Management/Report.js",

    //operations
    catalogue: "operations/catalogue.js",
    pos: "operations/pos.js",
    stockControl: "operations/stockControl.js",
    sale: "operations/sale.js",
    transaction: "operations/transaction.js",

    //views
    home: "system/views/home.js",
    account: "system/views/userAccount.js",
};

function compiler(params) {
    const importFiles = [];
    for (const param of Object.values(params)) {
        importFiles.push(`${pathToJs}${param}`);
    }

    return importFiles;
}

const items = compiler(importsObject);

let over_lays = null;
let search_display = null;


require(items, function() {
    $(document).ready(function() {
        //compose Overlay
        over_lays = new main_over_lay($("#over_lay_element"));

        // initialize search display
        search_display = new search_display_area($(".search_display_area"));

        //initialize main navigation
        let navigation_panel = new nav_pan($("#nav_tabs_container"));

        //initialize Time
        // window.setInterval(function() {
        //     let time = system_clock.get_time_date();
        //     const sys_time = new simple_time_display($(".system_clock"), time);
        // }, 1000);

        loading_view();
    });
});

function loading_view() {
    //initialize main navigation
    const navigation_panel = new nav_pan($("#nav_tabs_container"));

    navigation_panel
        .pre_def_intent('Notifications')
        .render_body_content(path.Management.Notification + 'notifications.php', pos_init);

    pos_init();
    let btn_clicked = null;
    let intent = null;
}