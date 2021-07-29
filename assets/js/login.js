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
                    if(resp.isSuccess == false) {
                        $("#message").html(resp.message);
                    } else {
                        window.location.href = resp.redirect;
                    }
                }
                else {
                    //window.location = 'login'
                }
            },
            error: function (data) {
                
            },
        });
    },

    sendTokenChangePassword : function() {
    var formData = {
            email: $("#email").val(),
        };   
    
        $.ajax({
            type: "POST",
            url: "sendtokenchangepassword",
            data: formData,
            success: function (data) {
                if (data) {
                    let resp = JSON.parse(data);
                    if(resp.isSuccess == false) {
                        $("#message").html(resp.message);
                    } else {
                        $("#changePasswordDiv").html(resp.changePasswordDiv);
                        $("#btnSendToken").html("Send Token Again ?");
                    }
                }
                else {
                    //window.location = 'login'
                }
            },
            error: function (data) {
                
            },
        });
    },

    changePassword : function() {
    var formData = {
            email: $("#email").val(),
            token: $("#token").val(),
            password: $("#password").val(),
            passwordconf: $("#passwordconf").val(),
        };   
    
        $.ajax({
            type: "POST",
            url: "changepassword",
            data: formData,
            success: function (data) {
                if (data) {
                    let resp = JSON.parse(data);
                    if(resp.isSuccess == false) {
                        $("#message").html(resp.message);
                    } else {
                        window.location.href = resp.redirect;
                    }
                }
                else {
                    //window.location = 'login'
                }
            },
            error: function (data) {
                
            },
        });
    }
}