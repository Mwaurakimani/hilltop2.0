// initialize_components

//compose Overlay
const over_lays = new main_over_lay($("#over_lay_element"));

// initialize search display
const search_display = new search_display_area($(".search_display_area"));

//initialize Time
// window.setInterval(function() {
//     let time = system_clock.get_time_date();
//     const sys_time = new simple_time_display($(".system_clock"), time);
// }, 1000);

const navigation_panel = new nav_pan($("#nav_tabs_container"));

navigation_panel
    .pre_def_intent('Account')
    .render_body_content(path.Accounts.users + 'userForm.php', $('#item_content'), path.Operations.catalogue + 'list.php').init(user_init);

let view = null;

var my_click;

setTimeout(() => {
    my_click = $("#current_clicked");
    my_click.click();
}, 600);