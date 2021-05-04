/**
 *This class represents all containers that perform known system actions
 *
 */
class Component {
    constructor(element) {
        this.element = element;
    }
    found_elem() {
        return this.element.length;
    }
}

/**
 *this class controls the overlay that covers the screen 
 *
 */
class main_over_lay extends Component {
    constructor(element) {
        super(element);
        super.found_elem(this.element);

        this.visible = false;
    }

    //opens the overlay
    render_open() {
        this.element.fadeIn("fast");
        this.visible = true;
    }

    //closes the overlay
    render_close() {
        this.element.fadeOut();
        this.visible = false;
    }

    //toggles the overlay
    render_toggle() {
        let over_lays_status = this.visible;


        if (over_lays_status) {
            this.render_close();
        } else {
            this.render_open();
        }
    }

}

/**
 *This class controls the display clock
 *
 */
class simple_time_display extends Component {
    constructor(element, time) {
        super(element);
        super.found_elem();
        this.bind_time(time);
    }

    bind_time(time) {
        $(".clock_item").html(time[0]);
        $(".calender_item").html(time[1]);
    }
}

/**
 *This class controls the system search bar
 *
 */
class search_display_area extends Component {
    constructor(element) {
        super(element);
        this.visible = false;
    }

    //displays the search bar
    render_display() {
        this.element.fadeIn();
        this.visible = true;
    }

    //hides the search bar
    render_hide() {
        this.element.fadeOut();
        this.visible = false;
    }

    //toggles visibility of the search bar
    render_toggle() {
        if (this.visible) {
            this.render_hide();

        } else {
            this.render_display();

        }
    }

}

//<table>

/**
 *This class defines methods that can be performed on a table
 *
 */
class tbody extends Component {
    static get_elements(tbody) {
        return tbody.children('tr');
    }

    //this method gets the table_row elements from a given table_body
    static get_table_rows(table_body) {

        let first_row = $(table_body).find("tr")[0];
        let rows = $(first_row).siblings();

        let table_rows = [
            $(first_row)
        ];

        rows.each(function(index, row) {
            table_rows.push($(row));
        });

        return table_rows;
    }

    //Auto-check all elements in an array of rows
    static check_all(rows) {

        $.each(rows, function(index, value) {
            let elem = value.find("th>input")[0];
            $(elem).prop('checked', true);
        });

        return true;
    }

    //Uncheck all elements in an array of rows
    static uncheck_all(rows) {

        $.each(rows, function(index, value) {
            let elem = value.find("th>input")[0];
            $(elem).prop('checked', false);
        });

        return true;
    }
}


/**
 *This class is used to select the table to be performed actions on
 *
 */
class display_table extends Component {
    constructor(element) {
        super(element);
        this.bind_children();
    }

    //table function
    bind_children() {
        const table = this.element.find("table")[0];
        const table_head = $(table).find("thead")[0];
        const table_body = $(table).find("tbody")[0];
        const adj_rows = tbody.get_table_rows(table_body);

        this.comp_table = table;
        this.comp_body = table_body;
        this.comp_rows = adj_rows;
        this.comp_head = table_head;
    }
    toggle_all_check() {
        let main_checker = $(this.comp_head).find("tr th input");

        if (main_checker.is(":checked")) {
            tbody.check_all(this.comp_rows);
        } else {
            tbody.uncheck_all(this.comp_rows);
        }
    }

}
//</table>

// Navigation


/**
 This class represents tha main navigation bar of the system.
  It controls the main view of the System
 It can be instantiated by auto-click
 @param element this element will be used to paste the response 
 @param path is the path to be used fore rendering the view 
*/
class nav_pan extends Component {
    constructor(element, paths) {
        super(element);
        this.init_by_click = false;
    }

    /**
    Gets the element that was clicked and the main_view it intends to open
    @sets caller
    @sets my_intent
     */
    get_intent() {
        var action;
        let btn_clicked = null;
        let my_intent = null;

        let btn_list = this.element.find('li'); //find all navigation buttons

        let clicked_button = event.currentTarget; //get the clicked element

        $.each(btn_list, function(index, button) {
            var clicked_button_txt = $(clicked_button).find("p").text();
            var button_txt = $(button).find("p").text();

            if (clicked_button_txt === button_txt) { //confirm the button clicked is in list and get its intent
                btn_clicked = $(button);
                this.btn_clicked = btn_clicked;
                my_intent = btn_clicked.find("p").text(); //find the text in paragraph

                action = {
                    btn_clicked: btn_clicked,
                    my_intent: my_intent
                };
                return false;
            }
        });
        this.init_by_click = true;
        this.action = action;
        return this;
    }

    /**
    This method gets an element selected by the user and automates the click to perform an auto-my_intent
    @set caller
    @set my_intent
     */

    pre_def_intent(intent) {
        let btn_clicked = null;
        let my_intent = null;
        this.element.find('li>p').each(
            (index, paragraph_element) => {
                if ($(paragraph_element).text() == intent) {
                    btn_clicked = $(paragraph_element).parent();
                }
            }
        );
        my_intent = btn_clicked.find("p").text();

        this.action = {
            btn_clicked: btn_clicked,
            my_intent: my_intent
        };
        this.init_by_click = false;
        return this;
    }

    /**
    This method renders the main view of the modules.
    @param path this is the path to the file to load
     */
    render_body_content(path, param) {
        let action = this.click_to_load_main;

        if (this.action !== null) {
            let body_content_element = $('#item_content');

            if (body_content_element.length > 0) {
                let result = null;

                $.ajax({
                        method: "POST",
                        url: path,
                        // async: false
                    })
                    .done((msg) => {
                        body_content_element
                            .html(msg)
                            .promise()
                            .then(this.init(param));
                        this.msg = msg;

                        return this;
                    })
                    .fail((msg) => {
                        console.log("Error");
                        this.msg = msg;
                        return this;
                    });

                return this;
            } else {
                alert("No load_out selected!");
                return this;
            }
        } else {
            console.log("No intent declared");
            return this;
        }
        return this;
    }

    /**
    This is used to act as a call back to load modules
    @param param this is a function to initialize a module
    */
    init(param) {
        if (typeof param === 'function') {
            param(this);
        } else {

        }
    }
}

class navigationBar extends Component {
    constructor(element, paths) {
        super(element);
    }
    show_elem() {
        console.log(this.element);
    }

}

class third_section extends navigationBar {
    static log_out() {
        let uplink1 = null;

        let path1 = './views/system_handler.php';

        uplink1 = new uplink("sys_action", path1, "log_out", "post", null, call_back_success);

        function call_back_success(msg) {
            window.location.replace(root_domain);
        }
    }
}

// </Navigation>