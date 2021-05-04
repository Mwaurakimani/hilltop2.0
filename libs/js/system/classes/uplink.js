class uplink {
    constructor(mode, url, action, method, data_bind, callbacks, reference = null) {

        $("body").css("cursor", "progress");
        this.mode = mode;
        this.bind_data = data_bind;
        this.action = action;
        this.method = method;
        this.reference = reference;
        var data;

        switch (mode) {
            case "create":
                data = {
                    action: this.mode,
                    intent: this.action,
                    data: {
                        prop: data_bind
                    }
                };
                this.post_data(url, data, callbacks);
                break;
            case "read":
                console.log(mode);
                break;
            case "update":
                data = {
                    action: this.mode,
                    intent: this.action,
                    data: {
                        prop: data_bind
                    }
                };
                this.post_data(url, data, callbacks);
                break;
            case "delete":
                data = {
                    action: this.mode,
                    intent: this.action,
                    data: {
                        prop: data_bind
                    }
                };
                this.post_data(url, data, callbacks);
                break;
            case "sys_action":
                data = {
                    action: action
                };
                this.post_data(url, data, callbacks);
                break;

            default:
                console.log("Error X000912");
                break;
        }
    }

    post_data(url, data, callbacks) {
        $.ajax({
                method: "POST",
                url: url,
                data: data,
            })
            .done((msg) => {
                $("body").css("cursor", "default");
                callbacks(msg);
            })
            .fail((msg) => {
                $("body").css("cursor", "default");
                callbacks(msg);
            });
    }
}