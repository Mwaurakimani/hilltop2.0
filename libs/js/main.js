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

    });
});