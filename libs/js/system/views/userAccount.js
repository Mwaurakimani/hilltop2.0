class userAccount extends View {
    constructor(elem, stats, user = null) {
        super(elem, stats);
        this.path = "views/Accounts/account/";

        if (user == null) {
            // console.log("Creating Mode");
            //db_prop
            this.user = {
                userID: null,
                firstName: null,
                lastName: null,
                username: null,
                email: null,
                password: null,
                ID_number: null,
                Status: null
            };
        } else {
            // console.log("Update Mode");
        }
    }

    get_user_details() {
        let variable_length = [
            [$("[name='userID']"), "userID"],
            [$("[name='firstName']"), "firstName"],
            [$("[name='lastName']"), "lastName"],
            [$("[name='phone']"), "phone"],
            [$("[name='username']"), "username"],
            [$("[name='email']"), "email"],
            [$("[name='password']"), "password"],
            [$("[name='ID_number']"), "ID_number"],
            [$("[name='userGroup']"), "userGroup"],
            [$("[name='Status']"), "Status"]
        ];

        var fields = {
            userID: null,
            firstName: null,
            lastName: null,
            username: null,
            phone: null,
            email: null,
            password: null,
            ID_number: null,
            Status: null,
            userGroup: null
        };

        let user_data = this.array_combine(fields, variable_length);
        var validated_data = this.validate_data(user_data);

        if (validated_data) {
            this.user = user_data;
            // spanner_loader
        } else {
            this.user = {
                userID: "hi",
                firstName: "hi",
                lastName: "hi",
                username: "hi",
                phone: "hi",
                email: "hi",
                password: "hi",
                ID_number: "hi",
                Status: "hi",
                userGroup: "hi"
            };
        }

        return this;
    }
    create_user() {
        var bind_data = this.user;

        let uplink1 = null;

        let path = './views/Accounts/accounts_control.php';

        uplink1 = new uplink("create", path, "create_user", "post", bind_data, call_back_success);

        function call_back_success(msg) {
            console.log(msg);
        }

        return this;
    }

    array_combine(fields, variable_length) {
        var user = {

        };
        $.each(variable_length, (index, val) => {
            var field_name = val[1];
            $.each(fields, (index1, val1) => {
                if (val[1] == index1) {
                    if (val[0].length > 0) {
                        var elem = (val[0]);
                        fields[index1] = elem.val();
                    }
                }
            });
        });

        return fields;
    }

    validate_data(user_data) {
        var validated = false;
        $.each(user_data, (index, value) => {
            if (value == null || value == "") {
                validated = false;
                return validated;
            } else {
                validated = true;
            }
        });

        return validated;
    }

}
let user_account = null;
let user_account_form = null;


const user_init = (paren_caller) => {
    const user_account_val = {
        name: "user_account",
        title: "Account",
        root: "Account",
        content: null
    };

    user_account = new userAccount($('#item_content'), user_account_val);
    view = user_account.view;
    user_account_form = null; //accounts form

    user_account.content = user_account_form;

    perform();
};

function perform() {

}