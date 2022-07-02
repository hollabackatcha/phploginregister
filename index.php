<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Log In or Register</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <?php
  session_start();
  ?>
  <link rel="stylesheet" href="css/style.css">
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>
  <div id="error_box" class="hidden">
    <p></p><button onclick="hideError();" id="btn_close-error">OK</button>
  </div>
  <div class="container" id="container">
    <div class="form-container sign-up-container">
      <form id="frm-register" method="post" class="needs-validation" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" novalidate>
        <h1>Create Account</h1>
        <div class="input_register-container">
          <input id="input_register-uname" name="register_username" type="text" class="form-control" placeholder="Username" required />
          <div class="valid-feedback">Looks good!</div>
        </div>
        <div class="input_register-container">
          <input id="input_register-email" name="register_email" type="email" class="form-control" placeholder="Email" required />
          <div class="valid-feedback">Looks good!</div>
        </div>
        <div class="input_register-container has-validation">
          <input id="input_register-pwd" type="password" class="form-control" placeholder="Password" pattern="^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s:])([^\s]){8,}$" required />
          <div class="invalid-feedback">
            Your password must be minimum 8 characters and have at least one small letter, capital letter, special & numeric characters.
          </div>
          <div class="valid-feedback">Looks good!</div>
        </div>
        <div class="input_register-container has-validation">
          <input type="text" id='input_register-cnfm-pwd' class="form-control" name="register_password-cnfm" placeholder="Confirm Password" required />
          <div class="invalid-feedback">Passwords do not match.</div>
          <div class="valid-feedback">Looks good!</div>
        </div>
        <div id="captcha" class="g-recaptcha" data-sitekey="6Lf9HYUgAAAAACE9ojUB1fjYYJ9-CQT_v1Ssl4qx"></div>
        <input id="btn_register" type="submit" value="Sign Up" />
      </form>
    </div>
    <div class="form-container sign-in-container">
      <form id='frm_login' method="POST" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
        <h1>Sign in</h1>
        <input id="input_login-uname" type="text" name="login_username" placeholder="Username" required />
        <input id="input_login-pwd" type="password" name="login_password" placeholder="Password" required />
        <a href="./forgotpassword.php">Forgot your password?</a>
        <button id="login_btn">Sign In</button>
      </form>
    </div>
    <div class="overlay-container">
      <div class="overlay">
        <div class="overlay-panel overlay-left">
          <h1>Already registered!?</h1>
          <p>To keep connected with us please login with your personal info</p>
          <button class="ghost" id="signIn">Sign In</button>
        </div>
        <div class="overlay-panel overlay-right">
          <h1>New here!?</h1>
          <p>Enter your personal details and start journey with us!</p>
          <button class="ghost" id="signUp">Sign Up</button>
        </div>
      </div>
    </div>
  </div>
  </section>
  <script src="js/app.js"></script>
  <?php
  require_once 'connection.php';
  require_once 'functions.php';
  if (isset($_POST['login_username']) && isset($_POST['login_password'])) {
    login($connection);
  }
  if (isset($_POST['register_username']) && isset($_POST['register_email']) && isset($_POST['register_password'])) {
    createAccount(($connection));
  }


  ?>
</body>

</html>