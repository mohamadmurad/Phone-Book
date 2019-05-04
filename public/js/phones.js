var error = false;
var Emailfilter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
var Namefilter = /^[a-zA-Z \u0600-\u06FF]{5,30}$/;
var UserNamefilter = /^[a-zA-Z0-9]{5,30}$/;

$(document).ready(function(){
     $(".home").css("padding-top","0px");
     $(".home").css("padding-top",($(".home").height() / 2) - ($("#search-form").height()/2));

        if ($('#error-alert').children().length != 0){

            $('html, body').animate({
              scrollTop: $("#error-alert").offset().top
            }, 1000);


        }

    });
        
 $(document).keypress(function(event){
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13'){
        $("#login_btn").click();
        $("#reset_btn").click();
        $("#register_btn").click();
    }
});


$(window).on("resize",function(){
    $(".home").css("padding-top","0px");
    $(".home").css("padding-top",($(".home").height() / 2) - ($("#search-form").height()/2));
    
});

var errorusrname = false;
var errorpass = false;




$("#pass1").on("keyup",function(){
     
     var password = $("#pass1").val();
    
     if(password.length < 8){
        $("#pass1").css("border-color","#ff0000");
        $("#pass_label").html("Password : <span> password length must > 8<span>");
        $("#register_btn").attr("disabled", "disabled");
        errorpass = true;
        return false;
    }else{
        errorpass =false; 
        $("#pass1").css("border-color","#46b0e4");
        $("#pass_label").html( "Password :");
        if(errorusrname == false)
            $("#register_btn").removeAttr("disabled");
        return true;

    }

});

 $("#pass2").on("keyup",function(){
     
     var password = $("#pass1").val();
     var password2 = $("#pass2").val();
     checkPassword(password,password2);

});



$("#login_btn").on('click',function(){
    
    if($('#login-username').val() && $('#login-pass').val() ){
        $("#login_form").submit();
    }else{
        $('#error-alert').html('<div class="alert alert-danger" role="alert">All Field is Required</div>')
        $('html, body').animate({
              scrollTop: $("#error-alert").offset().top
            }, 1000);
    }


});

$("#register_btn").on('click',function(){



    
    error = false;

    if($('#fullname').val() && $('#username').val() &&
       $('#email').val() && $('#pass1').val() &&
        $('#pass2').val()){

        RegisterValidation();
        if(error === false){
            $("#register_form").submit();
        }


    }else{
        $('#error-alert').html('<div class="alert alert-danger" role="alert">All Field is Required</div>')
        $('html, body').animate({
              scrollTop: $("#error-alert").offset().top
            }, 1000);

    }
    


});


$("#reset_btn").on('click',function(){

    
    if($('#reset-email').val() ){

        if(Emailfilter.test($('#reset-email').val())){

            $("#reset-form").submit();

        }else{
            $('#error-alert').html('<div class="alert alert-danger" role="alert">'+ $('#reset-email').val() + ' is not a valid email</div>')
            $('html, body').animate({
              scrollTop: $("#error-alert").offset().top
            }, 1000);
        }

        
    }else{
        $('#error-alert').html('<div class="alert alert-danger" role="alert">All Field Required</div>')
        $('html, body').animate({
              scrollTop: $("#error-alert").offset().top
            }, 1000);
    }


});

/*
$("#new_pass_btn").on('click',function(){

    
    if($('#reset-email').val() && Emailfilter.test($('#reset-email').val()) ){

        $("#reset-form").submit();
    }else{
        $('#error-alert').html('<div class="alert alert-danger" role="alert">'+ $('#reset-email').val() + ' is not a valid email</div>')
        $('html, body').animate({
              scrollTop: $("#error-alert").offset().top
            }, 1000);
    }


});

*/




function RegisterValidation(){

    if(!Namefilter.test($('#fullname').val())){
        $("#fullname-error").html('Full Name must be between 5 - 30 characters <span class="alert-link">Only</span>');
        error = true;
    }else{
        $("#fullname-error").html('');
    }

    if(!Emailfilter.test($('#email').val())){
        $("#email-error").html($('#email').val() + ' is not a valid email');
        error = true;
    }else{
        $("#email-error").html('');
    }

    if(!UserNamefilter.test($('#username').val())){
        $("#username-error").html('UserName must be between 5 - 30 characters And Numbers <span class="alert-link">Only</span>');
        error = true;
    }else{
        $("#username-error").html('');
    }
}


function checkPassword( pass1, pass2){
    if(pass1 === pass2){
        
         errorpass =false; 
        $("#pass2").css("border-color","#46b0e4");
        $("#re-pass").html( "Re-type password :");
        if(errorusrname == false)
            $("#register_btn").removeAttr("disabled");
        return true;
    }else{
        $("#pass2").css("border-color","#ff0000");
        $("#re-pass").html("Re-type password : <span> password not match<span>");
        $("#register_btn").attr("disabled", "disabled");
        errorpass = true;
        return false;
    }
}


