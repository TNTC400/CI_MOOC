const SignUp = {
    error_list : [],
    signup : function() {
    var formData = {
        username: $("#username").val(),
        email: $("#email").val(),
        password: $("#password").val(),
        passconf: $("#passwordconf").val(),
        };   
    
        $.ajax({
            type: "POST",
            url: "usersignup",
            data: formData,
            success: function (data) {
                if (data) {
                    window.location = 'login'
                }
                else {
                    window.location = 'signup'
                }
            },
            error: function () {
                window.location = 'signup'
            },
        });
}
}