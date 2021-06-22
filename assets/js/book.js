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
}
}