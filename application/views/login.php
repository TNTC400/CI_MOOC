<body class="text-center">
    <form class="form-signin" id="formLogin" action="userlogin" method="post">
      <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
      <p>
        <label for="username" class="sr-only">Username</label><br>
        <input type="text" id="username" class="text-center" placeholder="Username" required autofocus>
      </p>      
      <p>
        <label for="password" class="sr-only">Password</label><br>
        <input type="password" id="password" class="text-center" placeholder="Password" required>
      </p>
      <!-- <div class="checkbox mb-3">
        <label>
          <input type="checkbox" value="remember-me"> Remember me
        </label>
      </div> -->
      <p>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </p>
      <a href="<?php echo base_url() . 'signup'  ?>"> Don't have an account? </a>
    </form>



    <script type="text/javascript">
    $("#formLogin").submit(function(event)
    {
        event.preventDefault();
        Login.login();
        return false;
    });
</script>
</body>