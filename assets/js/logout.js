const Logout = {
    error_list : [],
    logout : function() {    
        $.ajax({
            type: "POST",
            url: "userlogout",
            success: function (data) {
                window.location = 'login'
            },
            error: function () {
                window.location = 'login'
            },
        });
}
}