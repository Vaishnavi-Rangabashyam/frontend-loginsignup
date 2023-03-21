<script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js">
</script>
<script type="text/javascript">
  function submitData(){
    $(document).ready(function(){
      var data = {
        username: $("#username").val(),
        email: $("#email").val(),
        password: $("#password").val(),
        action: $("#action").val(),

      };
     

      $.ajax({
        url: 'function.php',
        type: 'post',
        data: data,
        success:function(response){
          alert(response);
          
          if(response == "Login Successful"){
            window.location.reload();
          }
        }
      });
    });
    
  }
 
</script>

               
<script>
    const passwordInput = document.querySelector("#password");
    const eye = document.querySelector("#eye");
    eye.addEventListener("click", function(){
    this.classList.toggle("fa-eye-slash");
    const type = passwordInput.getAttribute("type") === "password" ? "text" : "password" ;
    passwordInput.setAttribute("type", type);
    });

</script>

