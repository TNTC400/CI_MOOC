<script src="<?php echo site_url('assets/js/signup.js'); ?>"></script>

<body class="text-center">
    <form class="form-signup" id="formSignUp" action="usersignup" method="post">
      <!-- User name -->
      <p>
        <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
        <label for="username" class="sr-only">Username</label><br>
        <input type="text" id="username" class="text-center" placeholder="Username" required autofocus>
      </p>
      <!-- Email -->
      <p>
        <label for="email" class="sr-only">Email address</label><br>
        <input type="text" id="email" class="text-center" placeholder="Email address" required>
      </p>
      <!-- Password -->
      <p>
        <label for="password" class="sr-only">Password</label><br>
        <input type="password" id="password" class="text-center" placeholder="Password" required>
      </p>
      <!-- Confirm password -->
      <p>
        <label for="passwordconf" class="sr-only">Confirm Password</label><br>
        <input type="password" id="passwordconf" class="text-center" placeholder="Confirm Password" required>
      </p>

      <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      <p></p>
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