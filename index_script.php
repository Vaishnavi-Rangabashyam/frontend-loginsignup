<script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js">
</script>
<script type="text/javascript">
  
   function submitData() {
     document.getElementById("button").addEventListener("click",submitData);
    //  document.getElementById("subForm").addEventListener("click",Submit);
    // window.location = "login.php";
          
        
       
    $(document).ready(function()
    {
     var data1 = {
        username: $("#username").val(),
        firstname: $("#firstname").val(),
        lastname: $("#lastname").val(),
        birthday: $("#birthday").val(),
        phone: $("#phone").val(),
        country: $("#country").val(),
        state: $("#state").val(),
        gender: $("#gender").val(),
        action: $("#action").val(),
        
      };

      $.ajax({              
              url: 'function.php',
              type: 'post',
              data: data1,
              success: function(response){
                alert(response);
                window.location = "home.php";
              if(response == "User data submitted Successfully!")
              {
                // alert(response);
                // window.location.reload();
                 return alert("You Form Is not submitted");
              }
              
              }
            });
            
    });
    
}
</script>


         
