$(document).ready(function(){

$('#asset-house').hide();
$(".js-example-placeholder-single").select2({
  placeholder: "Select an Option",
  allowClear: true
});

function validate()
{
 
  
   // var emailID = document.tenantregistration.email.value;
   // atpos = emailID.indexOf("@");
   // dotpos = emailID.lastIndexOf(".");
   // if (atpos < 1 || ( dotpos - atpos < 2 )) 
   // {
   //     alert("Please enter correct email ID")
   //     document.tenantregistration.email.focus() ;
   //     return false;
   // }

   return( true );
}

// ....Function for registering tenants.... //
 $(function(){
       $("#tenantregistration").submit(function(){
          
         

   //         if( document.tenantregistration.tenantfname.value == "" )
   // {
   // 	  swal({   title: "Tenant First Name",   text: "Please the first name!",   timer: 2000 });
     
   //   document.tenantregistration.tenantfname.focus() ;
   //   return false;
   // }

   
   // if( document.tenantregistration.tenantlname.value == "" )
   // {
   // 	swal({   title: "Tenant Last Name",   text: "Please the last name!",   timer: 2000 });
     
   //   document.tenantregistration.tenantlname.focus() ;
   //   return false;
   // }

   // if( document.tenantregistration.nationalpass.value == "" )
   // {
   // 	swal({   title: "Tenant National ID / Passport No",   text: "Please the National ID / Passport!",   timer: 2000 });
     
   //   document.tenantregistration.nationalpass.focus() ;
   //   return false;
   // }

   
   // if( document.tenantregistration.phonenumber.value == "" ||
   //         isNaN( document.tenantregistration.phonenumber.value ) ||
   //         document.tenantregistration.phonenumber.value.length != 10 )
   // {
   // 	swal({   title: "Tenant Mobile Number",   text: "Please provide a number in the format 07########",   timer: 2000 });
     
   //   document.tenantregistration.phonenumber.focus() ;
   //   return false;
   // }

   // if( document.tenantregistration.tenantstatus.value == "" )
   // {
   // 	swal({   title: "Tenant Status",   text: "Please select the status!",   timer: 2000 });
     
   //   document.tenantregistration.tenantstatus.focus() ;
   //   return false;
   // }

   // return true;
     

         var formData = new FormData($(this)[0]);
 
         $.ajax({
           type: "POST",
           url: "tenant/registration",
           data: formData,
           async: false,
           cache: false,
           contentType: false,
           processData: false,
           success: function(data){
               // ....After successful registration, then....//
              
              swal({   title: "Tenant Registration",   text: "Tenant has been registered, please move to assign house",   timer: 3000 });

              $("#registerten").click(function(){
              $("#assignten").tabs( "option", "active", 2 );
              });

           }
 
         });
 
         return false;  //stop the actual form post !important!
 
      });
   });

     // ....end of function.... //



     // ....Function for assigning tenants.... //
 $(function(){
       $("#tenantassigning").submit(function(){
          
      

         var formData = new FormData($(this)[0]);
 
         $.ajax({
           type: "POST",
           url: "tenant/assignhouse",
           data: formData,
           async: false,
           cache: false,
           contentType: false,
           processData: false,
           success: function(data){
               // ....After successful assigning, then....//
              
              swal({   title: "Tenant Assigning",   text: "Tenant has been assigned house",   timer: 3000 });

             
             

           }
 
         });
 
         return false;  //stop the actual form post !important!
 
      });
   });

     // ....end of function.... //




     // ....Function for editing tenants.... //
 $(function(){
       $("#tenantediting").submit(function(){
          
  
     

         var formData = new FormData($(this)[0]);
 
         $.ajax({
           type: "POST",
           url: "tenant/edittenant",
           data: formData,
           async: false,
           cache: false,
           contentType: false,
           processData: false,
           success: function(data){
               // ....After successful editing, then....//
              
              swal({   title: "Tenant Editing",   text: "Tenant has been updated",   timer: 3000 });

           }
 
         });
 
         return false;  //stop the actual form post !important!
 
      });
   });

     // ....end of function.... //

    
                  
            $("#table_search_estate").change(function(){  
                     /*dropdown post */// 
                     var query = $(this).serialize();
                    
                     $.ajax({
                        type: "POST",  
                        url:"tenant/buildDropHouses", 
                        data: query,  
                        dataType: 'json',
                        success:function(data){ 
                           $('#asset-house').show();
                           $("#houseDrp").html(data);  
                        }  
                     });  
            });  
            
         








});


