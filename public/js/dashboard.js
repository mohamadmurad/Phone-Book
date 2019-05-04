$(document).ready(function(){
    
   getallDataFromDB();
    

    
    
    
    
    
    
    
});

$("#search").on("keyup",function(){
    
        var text = $(this).val();

        if(text != ''){
            
            $.ajax({ 
              type: "POST",
              url: "data.php",
              data: {
                     val:text ,
                     op:"search",
                    },
           }).done(function( msg ) {
                
            $("#Contact-data").html(msg);
                $("#ex-data").val($("#all-data").html());
                $("#pdf-data").val($("#all-data").html());
                
                
          
        });
            

        }else{
            getallDataFromDB();
        }

    });


$("#Contact-data").on("click",".delete-contact",function(){
        console.log("d");
        
        var cID = $(this).parent().parent().data("contactId");
        console.log(cID);
        if(confirm("Do You Want Delete contact?")){
            
            var td = $(this);
            
           $.ajax({ 
              type: "POST",
              url: "data.php",
              data: {
                     cId:cID ,
                     op:"delete-data",
                    },
           }).done(function( msg ) {
               
             //  $(this).parent().parent().remove();
               if(msg == "true"){
                    td.parent().parent().remove();
                    
               }else{
                    console.log("f");
               }
                   

          /*
          
          INSERT INTO `contacts` (`contact_id`, `c_first_name`, `c_last_name`, `phone_number`, `mobile_number`, `birthdate`, `location`, `user_id`) VALUES (NULL, 'saeed', 'eid', '3452419', '+963930302628', '2019-02-04', 'damascus', '11')
          */

        });
   
        }else{
            
        }
        //return false;
    });

$("#Contact-data").on("click",".edit-btn",function(){
    
    
    var cid = $(this).parent().parent().data("contactId");
    
    $.ajax({ 
              type: "POST",
              url: "data.php",
              data: {
                     cid:cid ,
                     op:"get-info",
                    },
           }).done(function( msg ) {
        
            $("#edit-modal-body").html(msg);
           
        

        });
    
});

$("#save-change").on("click",function(){
    
    var fn = $("#edit-firstname").val();
    var ln = $("#edit-LastName").val();
    var ph = $("#edit-phone").val();
    var mob = $("#edit-mobile").val();
    var birth = $("#edit-birth").val();
    var loc = $("#edit-location").val();
    var cid = $("#edit-cid").val()
    if(fn && ln && ph && mob && birth && loc && cid){
      
        $.ajax({ 
              type: "POST",
              url: "data.php",
              data: {
                     fn:fn ,
                     ln:ln,
                     ph:ph,
                     mob:mob,
                     birth:birth,
                     loc:loc,
                     cid:cid,
                     op:"update-contact",
                    },
           }).done(function( msg ) {
           
            if(msg == "true"){
                $("#EditContact").modal('hide');
                getallDataFromDB();
                
            }else{
                 $("#EditContact").modal('hide');
                alert("An Error!");
            }
            
       

        });
        
       }else{
           alert("all Data required");
       }
    
    
});

$("#add-contact-btn").on("click",function(){
    
    $("#add-firstname").val("");
    $("#add-LastName").val("");
    $("#add-phone").val("");
    $("#add-mobile").val("");
    $("#add-birth").val("");
    $("#add-location").val("");
    
});

$("#save-contact").on("click",function(){
    
    var fn = $("#add-firstname").val();
    var ln = $("#add-LastName").val();
    var ph = $("#add-phone").val();
    var mob = $("#add-mobile").val();
    var birth = $("#add-birth").val();
    var loc = $("#add-location").val();
    
    if(fn && ln && ph && mob && birth && loc){
      
        $.ajax({ 
              type: "POST",
              url: "data.php",
              data: {
                     fn:fn ,
                     ln:ln,
                     ph:ph,
                     mob:mob,
                     birth:birth,
                     loc:loc,
                     op:"add-contact",
                    },
           }).done(function( msg ) {
           
            if(msg == "true"){
                $("#addContact").modal('hide');
                getallDataFromDB();
                
            }else{
                alert("An Error!");
            }
            
       

        });
        
       }else{
           alert("all Data required");
       }
    
});





function getallDataFromDB(){
    
     $('#Contact-data').html("<tr><td colspan='6'><div class='loader' id='loader'></div></td></tr>");
        $.ajax({ 
              type: "POST",
              url: "data.php",
              data: {  
                     op:"get-all-data",
                    },
           }).done(function( msg ) {



            setTimeout(function() {
                
                $("#Contact-data").html(msg);
           
                
                $("#ex-data").val($("#all-data").html());
                 $("#pdf-data").val($("#all-data").html());
            }, 2000);
            
            
            
           


        });
    
}


function printTable() {
        var Table = document.getElementById('all-data');
        newWin = window.open("");
        newWin.document.write(Table.outerHTML);
        newWin.print();
        newWin.close();
       }


