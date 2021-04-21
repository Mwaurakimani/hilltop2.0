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