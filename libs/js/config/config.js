const root_domain = "http://hilltop2.local";

const path = {
    Home: {
        shop: "views/Home/shop/",
        Dashboard: "views/Home/Dashboard/",
    },
    Operations: {
        POS: "views/Operations/POS/",
        stockControl: "views/Operations/stockControl/",
        catalogue: "views/Operations/catalogue/",
        sales: "views/Operations/sales/",
        transactions: "views/Operations/transactions/",
        customer: "views/Operations/customer/",
        vendor: "views/Operations/vendor/",
    },
    Management: {
        notification: "views/Management/notification/",
        reports: "views/Management/reports/",
        customization: "views/Management/customization/",
        mediaManagement: "views/Management/mediaManagement/",
    },
    Accounts: {
        account: "views/Accounts/account/",
        users: "views/Accounts/users/",
    },
};

function cout(params) {
    console.log(params);
}

function toggle_check_box(elem) {
    var is_checked = elem.is(':Checked');

    if (is_checked) {
        elem.prop('value', true);
    } else {
        elem.prop('value', false);
    }
}

function display_error(msg) {
    $("#dev_error_display").html(msg);
}