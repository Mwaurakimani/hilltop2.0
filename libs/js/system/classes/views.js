class View {
    constructor(params, param_array) {
        this.view = params;
        this.name = param_array.name;
        this.title = param_array.title;
        this.path = param_array.root;
        this.content = param_array.content;
    }
    get_view() {
        console.log(this.view);
        return this;
    }
}