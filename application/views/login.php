<div>
  <h1 class="h3 mb-3 font-weight-normal page-title">Please sign in</h1>
</div>

<div class="page-body">
  <body class="text-center">
    <div>
      <h6 id="message" class="error-message"></h6>
    </div>
    <form class="form-signin" id="formLogin" action="userlogin" method="post">
      <p>
        <label for="username" class="sr-only">Username</label><br>
        <input type="text" id="username" class="text-center" required autofocus>
      </p>      
      <p>
        <label for="password" class="sr-only">Password</label><br>
        <input type="password" id="password" class="text-center" required>
      </p>
      <p>
        <button class="orange-button" type="submit">Sign in</button>
      </p>
      <div class="row">
        <a href="<?php echo base_url() . 'forgotpassword'  ?>"> Forgot password? </a>
        <a href="<?php echo base_url() . 'signup'  ?>"> Don't have an account? </a>
      </div>
    </form>
  </body>
</div>
<script type="text/javascript">
  $("#formLogin").submit(function(event)
  {
      event.preventDefault();
      Login.login();
      return false;
  });
</script>