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

    //operations
    catalogue: "operations/catalogue.js",
    account: "system/views/userAccount.js",

    //views
    home: "system/views/home.js",
};

function compiler(params) {
    const importFiles = [];
    for (const param of Object.values(params)) {
        importFiles.push(`${pathToJs}${param}`);
    }

    return importFiles;
}

const items = compiler(importsObject);

require(items, function() {
    $(document).ready(function() {
        //compose Overlay
        const over_lays = new main_over_lay($("#over_lay_element"));

        // initialize search display
        const search_display = new search_display_area($(".search_display_area"));

        //initialize main navigation
        const navigation_panel = new nav_pan($("#nav_tabs_container"));

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
        .pre_def_intent('Catalogue')
        .render_body_content(path.Operations.catalogue + 'list.php', catalogue_init);

    let btn_clicked = null;
    let intent = null;
}