class userAccount extends View {
    constructor(elem, stats, user = null) {
        super(elem, stats);
        this.path_personal = "views/Accounts/account/";
        this.path_other = "views/Accounts/users/";

        if (user == null) {
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
        }
    }

    //helper methods
    array_combine(fields, elements) {

        $.each(elements, (index, element) => {
            var field_name = element[1];
            $.each(fields, (title, value) => {
                if (field_name == title) {
                    if (element[0].length > 0) {
                        fields[title] = element[0].val();
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
    get_user_details() {
        let elements = [
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

        let form_data = this.array_combine(fields, elements);

        var validated_data = this.validate_data(form_data);

        if (validated_data) {
            this.form_data = form_data;
            this.test = true;
            // spanner_loader
        } else {
            this.form_data = {
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
            this.test = true;
        }

        return this;
    }

    // crud
    create_user() {
        this.get_user_details();
        if (!this.test) {
            return;
        }
        var bind_data = this.form_data;


        let path1 = './views/Accounts/accounts_control.php';

        let uplink1 = new uplink("create", path1, "create_user", "post", bind_data, call_back_success);

        function call_back_success(msg) {
            var data = JSON.parse(msg);
            alert(data.response_stmt);

            navigation_panel
                .pre_def_intent('Accounts')
                .render_body_content(path.Accounts.users + 'list.php', user_init);
        }

        return this;
    }
    update_user(id) {
        this.get_user_details();
        if (!this.test) {
            return;
        }
        var bind_data = this.form_data;

        let uplink1 = null;

        let path1 = './views/Accounts/accounts_control.php';

        uplink1 = new uplink("update", path1, "update_user", "post", bind_data, call_back_success);

        function call_back_success(msg) {
            if (msg == true) {
                alert("Updated Successfully.");
            } else {
                alert("Not Successful.");
            }
        }

        return this;
    }
    delete_account(id) {

        let uplink1 = null;

        let path1 = './views/Accounts/accounts_control.php';

        uplink1 = new uplink("delete", path1, "delete_user", "post", id, call_back_success);

        function call_back_success(msg) {
            var response = JSON.parse(msg);

            if (response.status == true) {
                alert(response.response);

                navigation_panel
                    .pre_def_intent('Accounts')
                    .render_body_content(path.Accounts.users + 'list.php', user_init);
            } else {
                alert("Error deleting user");
            }
        }
    }

    //renders
    render_user_form() {
        let path1 = this.path_other + "userForm.php";

        $('#item_content').load(path1);
    }
    render_update() {
        var id = $(event.currentTarget).parent().find(".id_holder p").text();

        $.ajax({
                method: "POST",
                url: this.path_other + "userForm.php",
                data: id,
            })
            .done((msg) => {
                $('#item_content').html(msg);
            })
            .fail((msg) => {
                $('#item_content').html(msg);
            });
    }

}
let user_account = null;
let user_account_form = null;
var user_view = null;


const user_init = (paren_caller) => {
    const user_account_val = {
        name: "user_account",
        title: "Account",
        root: "Account",
        content: null
    };

    user_account = new userAccount($('#item_content'), user_account_val);
    view = user_account.view;
    user_table = new display_table(view.find('#user_panel_1'));

    user_account.content = user_account_form;
};