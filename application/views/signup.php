<script src="<?php echo site_url('assets/js/signup.js'); ?>"></script>

<body class="text-center">
    <form class="form-signup" id="formSignUp" action="usersignup" method="post">
      <!-- User name -->
      <p>
        <h1 class="h3 mb-3 font-weight-normal">Sign up</h1>
        <label for="username" class="sr-only">Username</label><br>
        <input type="text" id="username" class="text-center" required autofocus>
      </p>
      <!-- Email -->
      <p>
        <label for="email" class="sr-only">Email address</label><br>
        <input type="text" id="email" class="text-center" required>
      </p>
      <!-- Password -->
      <p>
        <label for="password" class="sr-only">Password</label><br>
        <input type="password" id="password" class="text-center" required>
      </p>
      <!-- Confirm password -->
      <p>
        <label for="passwordconf" class="sr-only">Confirm Password</label><br>
        <input type="password" id="passwordconf" class="text-center" required>
      </p>

      <button class="btn btn-lg btn-primary btn-block" type="submit">Sign up</button>
      <p></p>

      <a href="<?php echo base_url() . 'login'  ?>"> Have an account? </a>
    </form>

    <script type="text/javascript">
    $("#formSignUp").submit(function(event)
    {
        event.preventDefault();
        SignUp.signup();
        return false;
    });
</script>
</body>