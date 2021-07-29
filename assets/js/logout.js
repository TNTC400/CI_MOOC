var Logout = {
    error_list : [],
    logout : function() {    
        $.ajax({
            type: "POST",
            url: "userlogout",
            success: function (data) {
                let resp = JSON.parse(data);
                window.location.href = resp.redirect;
            },
            error: function () {
                window.location = 'login'
            },
        });
}
}