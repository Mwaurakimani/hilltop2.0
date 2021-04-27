class uplink {
    constructor(mode, url, action, method, data_bind, callbacks, reference = null) {
        this.mode = mode;
        this.bind_data = data_bind;
        this.action = action;
        this.method = method;
        this.reference = reference;

        switch (mode) {
            case "create":
                this.post_data(url, data_bind, callbacks);
                break;
            case "read":
                console.log(mode);
                break;
            case "update":
                console.log(mode);
                break;
            case "delete":
                console.log(mode);
                break;

            default:
                console.log("Error X000912");
                break;
        }
    }

    post_data(url, data, callbacks) {
        console.log(url);
        $.ajax({
                method: "POST",
                url: url,
                data: data
            })
            .done((msg) => {
                console.log(msg);
            })
            .fail((msg) => {
                console.log(msg);
            });
    }
}