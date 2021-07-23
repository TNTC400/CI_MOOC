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
                    let resp = JSON.parse(data);
                    window.location.href = resp.redirect;
                }
                else {
                    window.location = 'login'
                }
            },
            error: function (data) {
                
            },
        });
}
}