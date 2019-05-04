$(document).ready(function(){
    var path = location.pathname.split('?')[0];
    var start = path.lastIndexOf('/') + 1;
    var activeLink = path.substr(start);

   setURLActive(activeLink);

   if(activeLink == 'allContact.php'){
    getPageNumber();
    getData(1);
   }


   if(activeLink == 'manageUsers.php'){
    getPageNumberUser();
    getUserSData(1);
   }   
  $(document).on('click','#pagination .page-link',function(){
    var pageNum = $(this).data('page');

    getData(pageNum);

    $('#pagination li').removeClass('active');
    $(this).parent().addClass('active');
  });
  $(document).on('click','#pagination_users .page-link',function(){
    var pageNum = $(this).data('page');

    getUserSData(pageNum);

    $('#pagination_users li').removeClass('active');
    $(this).parent().addClass('active');
  });
    
});


/*
* event on click information btn
*/
$("#Users-data").on("click",".user-info-btn",function(){
    
    $('#user-edit-modal').css('display','inline-block');
    $('#user-save-change').css('display','none');
    var cid = $(this).parent().parent().data("contactId");

   
    
    $.ajax({ 
            type: "POST",
            url: "../api/data.php",
            headers : {
              'CsrfToken': $('meta[name="csrf-token"]').attr('content'),
            },
            data: {
             cid:cid ,
             op:"get-user-info",
            },
         }).done(function( msg ) {
      
          $("#edit-user-from-modal").html(msg);
         
      

      });    
});


/*
* event on click privilages btn
*/
$("#Users-data").on("click",".privibtn",function(){
    

    var cid = $(this).parent().parent().data("contactId");

    console.log(cid);
    
    $.ajax({ 
            type: "POST",
            url: "../api/data.php",
            headers : {
              'CsrfToken': $('meta[name="csrf-token"]').attr('content'),
            },
            data: {
             cid:cid ,
             op:"get-user-privi",
            },
         }).done(function( msg ) {
      
          $("#edit-user-privi-from-modal").html(msg);
         
      

      });    
});


/*
* event on delete Users
*/
$('#Users-data').on('click','.deleteUser',function(){
  if(confirm("Do You Want Delete User?")){
    var cid = $(this).parent().parent().data("contactId");
    var td = $(this);
    $.ajax({
            type: "POST",
            url: "../api/data.php",
            headers : {
              'CsrfToken': $('meta[name="csrf-token"]').attr('content'),
            },
            data:{
              op: 'delete-user',
              cid: cid,
            },
            
         }).done(function( msg ) {
      
          if(msg == "true"){

              td.parent().parent().remove();
              
              
          }else{
              
              alert("An Error!");
          }
          
     

      });

  }
});


/*
* event on edit click to enable inputs
*/
$('#user-edit-modal').on("click",function(){
    $("#edit-fullname").removeAttr('disabled');
    $("#edit-username").removeAttr('disabled');
    $("#edit-email").removeAttr('disabled');
    $("#admin-radio").removeAttr('disabled');
    $("#user-radio").removeAttr('disabled');
    $("#active-radio").removeAttr('disabled');
    $("#disabled-radio").removeAttr('disabled');

    $('#user-edit-modal').css('display','none');
    $('#user-save-change').css('display','inline-block');
    $('#user-save-info').css('display','inline-block');
});

/*
* event on edit information to user
*/
$('#edit-user-from-modal').on('submit',function(e){


      e.preventDefault();

      var form_data = new FormData(this);
      form_data.append("op", "update-user-info");


        $.ajax({
              type: "POST",
              url: "../api/data.php",
              headers : {
                'CsrfToken': $('meta[name="csrf-token"]').attr('content'),
              },
              data:form_data,
              processData: false,
              contentType: false ,  
  
           }).done(function( msg ) {
        
            if(msg == "true"){

                $("#InfoUser").modal('hide');
                var pnumb = $(".pagination li.active a").data("page");
                
                getUserSData(pnumb);                
            }else{
                 $("#InfoUser").modal('hide');
                alert("An Error!");
            }
            
       

        });      
});


/*
* event on edit privilages to user
*/
$('#edit-user-privi-from-modal').on('submit',function(e){


      e.preventDefault();

      var form_data = new FormData(this);
      form_data.append("op", "update-user-privi");
        $.ajax({
              type: "POST",
              url: "../api/data.php",
              headers : {
                'CsrfToken': $('meta[name="csrf-token"]').attr('content'),
              },
              data:form_data,
              processData: false,
              contentType: false ,  
  
           }).done(function( msg ) {
        
            if(msg == "true"){

                $("#Userprivi").modal('hide');
                var pnumb = $(".pagination li.active a").data("page");

                getUserSData(pnumb);
                
            }else{
                 $("#Userprivi").modal('hide');
                alert("An Error!");
            }
            
       

        });
           
});

/*
* event on click delete to any Contact
*/
$("#Contact-data").on("click",".delete-contact",function(){
        
        
        var cID = $(this).parent().parent().data("contactId");
        
        if(confirm("Do You Want Delete contact?")){
            
            var td = $(this);
            
           $.ajax({ 
              type: "POST",
              url: "../api/data.php",
              headers : {
                'CsrfToken': $('meta[name="csrf-token"]').attr('content'),
              },
              data: {
                     cId:cID ,
                     op:"delete-contact",
                    },
           }).done(function( msg ) {
          
               if(msg == "true"){
                    td.parent().parent().remove();
                    
               }else{
                    alert("Error Delete Contact!");
               }
                  

          });
   
        } 
    });

/*
* event on click edit to any Contact
*/
$("#Contact-data").on("click",".edit-btn",function(){
  
    
    var cid = $(this).parent().parent().data("contactId");
      console.log(cid);
    $.ajax({ 
              type: "POST",
              url: "../api/data.php",
              headers : {
                'CsrfToken': $('meta[name="csrf-token"]').attr('content'),
              },
              data: {
                     cid:cid ,
                     op:"get-contact-info",
                    },
           }).done(function( msg ) {
        
            $("#edit-contact-form").html(msg);  
        

        });  
});

/*
* event on save contact new info
*/
$("#edit-contact-form").on("submit",function(e){
    e.preventDefault();

    var fn = $("#edit-firstname").val();
    var ln = $("#edit-LastName").val();
    var ph = $("#edit-phone").val();
    var mob = $("#edit-mobile").val();
    var birth = $("#edit-birth").val();
    var loc = $("#edit-location").val();
    var cid = $("#edit-cid").val();

    if(fn && ln && ph && mob && birth && loc && cid){
        var form_data = new FormData(this);
        form_data.append("op", "update-contact-info");
        
        $.ajax({ 
              type: "POST",
              url: "../api/data.php",
              headers : {
                'CsrfToken': $('meta[name="csrf-token"]').attr('content'),
              },
              data:form_data,
              processData: false,
              contentType: false ,
           }).done(function( msg ) {
           
            if(msg == "true"){
                $("#EditContact").modal('hide');
                var pnumb = $(".pagination li.active a").data("page");
                getData(pnumb);       
            }else{
                 $("#EditContact").modal('hide');
                alert(msg);
            }
            
       

        });
        
       }else{
           alert("all Data required");
       }   
});


/*
* event when write in search box
*/
$("#search").on("keyup",function(){
    
        var text = $(this).val();

        if(text != ''){
            
            $.ajax({ 
               type: "POST",
              url: "../api/data.php",
              contentType:"application/x-www-form-urlencoded; charset=utf-8",
              headers : {
                'CsrfToken': $('meta[name="csrf-token"]').attr('content'),
              },
              
              data: {
                     val:text ,
                     op:"get-search-results",
                    },
           }).done(function( msg ) {

                $("#pagination").html('');
              $("#Contact-data").html(msg);

              

              var orginal = $("#all-data").html();

                $("#all-data tr").find("th.edit-delete, td.edit-delete").remove();
                $("#all-data tr").find("th.edit-delete, td.edit-delete").remove();
                var temp = $("#all-data").html();

               $("#all-data").html(orginal);
                
                $("#ex-data").val(temp);
                 $("#pdf-data").val(temp);
                
                
          
        });
            

        }else{
             getPageNumber();
             getData(1);
        }

    });




                  
              


/*
* Print table of contacts
*/
function printTable() {
        var style = "public/css/phones1.css";
        var Table = document.getElementById('all-data');
        newWin = window.open("");
        newWin.document.write('<html><head><link rel="stylesheet" href="public/css/bootstrap.min.css"><link rel="stylesheet" href="public/fontawesome/css/all.min.css"><link rel="stylesheet" href="public/css/phones1.css"><script src="public/js/jquery-3.1.1.min.js"></script></head><body onload="javascript:window.print();window.close();">'+Table.outerHTML+'<script>$("#all-data tr").find("th:last, td:last").remove(); window.print();window.close();</script></body></html>');
       // newWin.print();
       // newWin.close();
       }


/*
* Get Number of page to show all Contacts in page n
*/
function getPageNumber(){

  $.ajax({
    type: "POST",
    url: "../api/data.php",
    headers : {
      'CsrfToken': $('meta[name="csrf-token"]').attr('content'),
    },
    data: {
         op:"get-pages",
       },
     }).done(function(number){
      $("#pagination").html('');
      
      for(i=0;i<number;i++){
          if(i==0){
            $("#pagination").html($("#pagination").html()+'<li class="page-item active"><a class="page-link" href="#" data-page="' + (i+1) + '">'+ (i+1) +'</a></li>');  
          }else{

            $("#pagination").html($("#pagination").html()+'<li class="page-item"><a class="page-link" href="#" data-page="' + (i+1) + '">'+ (i+1) +'</a></li>');

          }
        }
        
     });
}

/*
* Get Number of page to show all users in page n
*/  
function getPageNumberUser(){
  $.ajax({
    type: "POST",
    url: "../api/data.php",
    headers : {
      'CsrfToken': $('meta[name="csrf-token"]').attr('content'),
    },
    data: {
         op:"get-pages-users",
       },
     }).done(function(number){
      $("#pagination").html('');

      for(i=0;i<number;i++){
          if(i==0){
            $("#pagination_users").html($("#pagination_users").html()+'<li class="page-item active"><a class="page-link" href="#" data-page="' + (i+1) + '">'+ (i+1) +'</a></li>');  
          }else{

            $("#pagination_users").html($("#pagination_users").html()+'<li class="page-item"><a class="page-link" href="#" data-page="' + (i+1) + '">'+ (i+1) +'</a></li>');

          }
        }
        
     });
}

/*
* Get all Users in page n
*/  
function getUserSData(pageNumber = 1){
  $('#Users-data').html("<tr><td colspan='6'><div class='loader' id='loader'></div></td></tr>");
        $.ajax({ 
              type: "POST",
              url: "../api/data.php",
              headers : {
                'CsrfToken': $('meta[name="csrf-token"]').attr('content'),
              },
              data: {  
                     op:"get-data-users",
                     page : pageNumber,
                    },
           }).done(function( msg ) {


             
            setTimeout(function() {
                
                $("#Users-data").html(msg);
           
                
                
            }, 2000);
            

        });
}

/*
* Get all Contact in page n
*/            
function getData(pageNumber = 1){

  $('#Contact-data').html("<tr><td colspan='7'><div class='loader' id='loader'></div></td></tr>");

        $.ajax({ 
              type: "POST",
              url: "../api/data.php",
              headers : {
                'CsrfToken': $('meta[name="csrf-token"]').attr('content'),
              },
              data: {  
                     op:"get-data",
                     page : pageNumber,
                    },
           }).done(function( msg ) {


             
            setTimeout(function() {
                
                $("#Contact-data").html(msg);

                var orginal = $("#all-data").html();

                $("#all-data tr").find("th.edit-delete, td.edit-delete").remove();
                $("#all-data tr").find("th.edit-delete, td.edit-delete").remove();
                var temp = $("#all-data").html();

               $("#all-data").html(orginal);
                
                $("#ex-data").val(temp);
                 $("#pdf-data").val(temp);
            }, 2000);
            

        });

}


function setURLActive(activeLink) {
    if(activeLink == '') activeLink = 'index.php';
    $('.navbar .navbar-nav a[href^="' + activeLink + '"]').addClass('active');
    }