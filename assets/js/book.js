const Book = {
    error_list : [],
    addnew : function() {
    var formData = {
        title: $("#title").val(),
        author: $("#author").val(),
        quantity: $("#quantity").val()
        };   
    
        $.ajax({
            type: "POST",
            url: "newbook",
            data: formData,
            success: function (data) {
                window.location = 'home'
            },
            error: function () {
                window.location = 'home'
            },
        });
    },

    AddExistedBook : function(value) {
        var formData = {
            id: value,
            quantity: $("#quantity").val()
        };
        
        var str = "addexisted/" + value;
        
        $.ajax({
            type: "POST",
            url: "addexisted/"+value,
            data: formData,
            success: function (data) {
                let resp = JSON.parse(data);
                window.location.href = resp.redirect
            },
            error: function (data) {
                
            },
        });
    },

    DeleteBook : function(value) {
        var formData = {
        id: value
        };   
    
        $.ajax({
            type: "POST",
            url: "delete/" + value,
            data: formData,
            success: function (data) {
                let resp = JSON.parse(data);
                window.location.href = resp.redirect
            },
            error: function (data) {
            },
        });
    },
}