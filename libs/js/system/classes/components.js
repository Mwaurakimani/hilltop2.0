class Component {
    constructor(element) {
        this.element = element;
    }
    found_elem() {
        return this.element.length;
    }
}

class main_over_lay extends Component {
    constructor(element) {
        super(element);
        super.found_elem(this.element);

        this.visible = false;
    }

    render_open() {
        this.element.fadeIn("fast");
        this.visible = true;
    }

    render_close() {
        this.element.fadeOut();
        this.visible = false;
    }
    render_toggle() {
        let over_lays_status = this.visible;


        if (over_lays_status) {
            this.render_close();
        } else {
            this.render_open();
        }
    }
}

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

class search_display_area extends Component {
    constructor(element) {
        super(element);
        this.visible = false;
    }
    render_display() {
        this.element.fadeIn();
        this.visible = true;
    }
    render_hide() {
        this.element.fadeOut();
        this.visible = false;
    }
    render_toggle() {
        if (this.visible) {
            this.render_hide();

        } else {
            this.render_display();

        }
    }

}

//<table>

class tbody extends Component {
    static echo_confirm() {
        console.log("confirm");
    }
    static get_elements(tbody) {
        return tbody.children('tr');
    }
    static get_table_rows(adj_rows) {

        let first_row = $(adj_rows).find("tr")[0];
        let rows = $(first_row).siblings();

        let trows = [
            $(first_row)
        ];

        rows.each(function(params, val) {
            trows.push($(val));
        });

        return trows;
    }
    static check_all(rows) {

        $.each(rows, function(index, value) {
            let elem = value.find("th>input")[0];
            $(elem).prop('checked', true);
        });
        return true;
    }
    static uncheck_all(rows) {

        $.each(rows, function(index, value) {
            let elem = value.find("th>input")[0];
            $(elem).prop('checked', false);
        });
        return true;
    }
}

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

class nav_pan extends Component {
    constructor(element, paths) {
        super(element);
    }
    get_intent() {
        let ren = null;
        let btn_list = this.element.find('li');
        let clicked = event.currentTarget;
        $.each(btn_list, function(index, value) {
            if (clicked === value) {
                this.caller = $(value);
                this.intent = this.caller.find("p").text();

                const render = {
                    caller: this.caller,
                    intent: this.intent
                };

                ren = render;
            }
        });
        this.ren = ren;
    }
    render_body_content(path, render_elem, fun) {

        this.get_intent();

        if (this.ren !== null) {
            const load_out = render_elem;

            if (load_out.length > 0) {
                $.ajax({
                        method: "POST",
                        url: path,
                    })
                    .done((msg) => {
                        load_out.html(msg);
                    })
                    .fail((msg) => {
                        console.log("hello");
                    });
            } else {
                alert("could not find load out");
            }
        } else {
            alert("Error fetching data");
        }
        return true;
    }
    render_list(path) {
        let elem = $('#catalog_panel_1');
        elem.load(path);
    }


}



// / Navigation

// var elem;
// let interval = setInterval(() => {
//     let elem = $('#catalog_panel_1');
//     console.log("done");
//     if (elem !== 'undefined') {
//         clearInterval(interval);
//         elem.load(path);
//     }
// }, 500);

// navigation_panel.render_list(path.Operations.catalogue+'list.php')