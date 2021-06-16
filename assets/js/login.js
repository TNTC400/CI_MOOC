const Login = {
    error_list : [],
    login : function() {
    var formData = {
        username: $("#username").val(),
        password: $("#password").val(),
        };   
    
        $.ajax({
            type: "POST",
            url: "userlogin",
            data: formData,
            success: function (data) {
                if (data) {
                    window.location = 'home'
                }
                else {
                    window.location = 'login'
                }
            },
            error: function () {
                window.location = 'login'
            },
        });
}
}