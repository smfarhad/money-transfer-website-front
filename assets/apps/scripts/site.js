$(document).ready(function () {
    $('#sample_3 tbody').on('click', 'tr', function (e) {
    // e.preventDefault();       
    // alert('test');
//        var confirm;
//        var r = confirm("Press a button!");
//        if (r == true) {
//            txt = "You pressed OK!";
//        } else {
//            txt = "You pressed Cancel!";
//        }     
     });    
    
});
    
$(document).ready(function () {
 
    // stop transection delete button 
    $("#sample_3").on("submit", "form.transaction-delete-form", function (e){ 
        e.preventDefault();
        var r = confirm("Are you sure you want to delete this? ");
        if (r == true) {
            
            var data = $(this).serialize();
            var url = $(this).attr('action');
            var tr = $(this).closest("tr");
            // ajax submition 
            $.ajax({
                type: "POST",
                url: url,
                data: data,
                cache: false,
                dataType: 'json',
                success: function (response) {
                    if (response.success == true) {
                        tr.prev().remove();
                        tr.remove();
                        console.log(tr);
                        $('div#message').show().delay(1000).fadeOut();
                    }
                }
            });
        } else {
            txt = "You pressed Cancel!";
            //alert(txt);
        } 
       
    });
        
    
    var home = 'http://money-transfer-admin.dev/';
// check box click
    $(document).ready(function () {
        $('#clickmewow').click(function () {
            $('#radio1003').attr('checked', 'checked');
        });
    })

// save profile details 
    $('form#editProfile').on('submit', function (e) {
        e.preventDefault();
        var data = $(this).serialize();
        var url = $(this).attr('action');
        // ajax submition 
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            cache: false,
            dataType: 'json',
            success: function (response) {
                var password = $("div#password");
                var confirm_password = $("div#confirm_password");
                if (response.success == true) {
                    // remove error essential
                    var message = $('div#message').find('.alert');
                    message.addClass('alert-success');
                    message.html("<a href='#' class='close' data-dismiss='alert' aria-label='close' title='close'>Ã—</a>" +
                            '<span><strong>Success!</strong> Profile info updated successfully. </span>');
                    $('div#message').show().delay(3000).fadeOut();
                } else {


                }
            }
        });

    });

// add profile picture 
    $('form#addPic').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        $.ajax({
            url: "addprofilepic",
            type: "POST",
            data: formData,
            async: false,
            dataType: "json",
            success: function (response) {
                if(response.success == true){
                    console.log(response.success.path);
                    var message = $('div#message').find('.alert');
                    message.addClass('alert-success');
                    message.html("<a href='#' class='close' data-dismiss='alert' aria-label='close' title='close'>Ã—</a>" +
                            '<span><strong>Success!</strong> Image Update Success Fully. </span>');
                    $('div#message').show().delay(3000).fadeOut();
                    var img = $("img.profile_img");
                    console.log(img.attr('src', home+response.path));
                } else{
                    var message = $('div#message').find('.alert');
                    message.addClass('alert-danger');
                    message.html("<a href='#' class='close' data-dismiss='alert' aria-label='close' title='close'>Ã—</a>" +
                            '<span><strong>ERROR!</strong> ' + response.errors.profile_pic + '</span>');
                    $('div#message').show().delay(5000).fadeOut();
                }

            },
            cache: false,
            contentType: false,
            processData: false
        });

    });

    $('form#changePassword').on('submit', function (e) {
        e.preventDefault();
        var data = $(this).serialize();
        var url = $(this).attr('action');
        // ajax submition 
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            cache: false,
            dataType: 'json',
            success: function (response) {
                var password = $("div#password");
                var confirm_password = $("div#confirm_password");
                if (response.success == true) {
                    // remove error essential
                    password.removeClass('has-error');
                    confirm_password.removeClass('has-error');
                    $("span#password_error").text('');
                    $("span#confirm_password_error").text('');


                    var message = $('div#message').find('.alert');
                    message.addClass('alert-success');
                    message.html("<a href='#' class='close' data-dismiss='alert' aria-label='close' title='close'>Ã—</a>" +
                            '<span><strong>Success!</strong> Password updated successfully. </span>');
                    $('div#message').show().delay(5000).fadeOut();
                } else {
                    if (response.errors.password) {
                        password.addClass('has-error');
                        $("span#password_error").text(response.errors.password);
                    } else {
                        password.removeClass('has-error');
                        $("span#password_error").text('');
                    }
                    if (response.errors.password_confirmation) {
                        confirm_password.addClass('has-error');
                        $("span#confirm_password_error").text(response.errors.password_confirmation);
                    } else {
                        confirm_password.removeClass('has-error');
                        $("span#confirm_password_error").text('');
                    }
                }
            }
        });

    });
    $("#sample_3").on("submit", ".transaction-status-form-datafield", function (e) {
        e.preventDefault();
        var data = $(this).serialize();
        var url = $(this).attr('action');
        var tr = $(this).closest("tr");
        // ajax submition 
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            cache: false,
            dataType: 'json',
            success: function (response) {
                if (response.success == true) {
                    tr.prev().remove();
                    tr.remove();
                    $('div#message').show().delay(1000).fadeOut();
                }
            }
        });

    });
    $("#sample_3").on("submit", ".transaction-status-form-bakaal", function (e) {
        e.preventDefault();
        var data = $(this).serialize();
        var url = $(this).attr('action');
        var tr = $(this).closest("tr");
        // ajax submition 
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            cache: false,
            dataType: 'json',
            success: function (response) {
                if (response.success == true) {
                    tr.prev().remove();
                    tr.remove();
                    $('div#message').show().delay(1000).fadeOut();
                }
            }
        });

    });

    $("#sample_3").on("click", "button.status-button", function (e) {
        e.preventDefault();
        $("div.status-div").closest("td").find("div.status-div").toggle();

    });
    

// stop transection
    $("#sample_3").on("submit", "form.transaction-stop", function (e) {
        e.preventDefault();
        var data = $(this).serialize();
        var url = $(this).attr('action');
        var tr = $(this).closest("tr");
        // ajax submition 
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            cache: false,
            dataType: 'json',
            success: function (response) {
                if (response.success == true) {
                    tr.prev().remove();
                    tr.remove();
                    console.log(tr);
                    $('div#message').show().delay(1000).fadeOut();
                }
            }
        });

    });

    // stop transection
    $("#sample_3").on("submit", "form.transaction-send-now", function (e) {
        e.preventDefault();
        var data = $(this).serialize();
        var url = $(this).attr('action');
        var tr = $(this).closest("tr");
        // ajax submition 
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            cache: false,
            dataType: 'json',
            success: function (response) {
                if (response.success == true) {
                    tr.prev().remove();
                    tr.remove();
                    console.log(tr);
                    $('div#message').show().delay(1000).fadeOut();
                }
            }
        });

    });
    // change status 
    $("#sample_3").on("submit", "form.user-status-form", function (e) {
        e.preventDefault();
        var data = $(this).serialize();
        var url = $(this).attr('action');
        var tr = $(this).closest("tr");
        var button = $(this).children('button');
        var status = $(this).children('input[name=status]');
        
        // ajax submition 
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            cache: false,
            dataType: 'json',
            success: function (response) {
                    if(button.hasClass("green-sharp")){
                        button.removeClass("green-sharp");
                        button.addClass("red");
                        button.text("Inactive");
                    }else {
                        button.removeClass("red");
                        button.addClass("green-sharp");
                         button.text("active");
                    }
                if (response.success == true) {    
                    status.val(0);
                    var message = $('div#message').find('.alert');
                    message.addClass('alert-success');
                    message.html("<a href='#' class='close' data-dismiss='alert' aria-label='close' title='close'>Ã—</a>" +
                            '<span><strong>Success!</strong> User Activated Successfully. </span>');
                    $('div#message').show().delay(5000).fadeOut();
                } else {
                    status.val(1);
                    var message = $('div#message').find('.alert');
                    message.addClass('alert-warning');
                    message.html("<a href='#' class='close' data-dismiss='alert' aria-label='close' title='close'>Ã—</a>" +
                            '<span><strong>Warning!</strong> User In Activate Successfully. </span>');
                    $('div#message').show().delay(5000).fadeOut();
                }
            }
        });

    });
    

});


