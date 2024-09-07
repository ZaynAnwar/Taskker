<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="stylesheet" href="login.css" />
  </head>
  <body>
    <div class="container">
      <h2>Login</h2>
      <form id="loginForm" action="login.php" method="post">
        <div class="form-group">
          <label for="username">Username:</label>
          <input type="text" id="username" name="username" required />
        </div>
        <div class="form-group">
          <label for="password">Password:</label>
          <input type="password" id="password" name="password" required />
        </div>
        <div class="form-group">
          <button type="submit">Login</button>
        </div>
      </form>

      <div class="or-separator">
        <span>OR</span>
      </div>

      <div class="signup-section">
        <h3>Don't have an account? Sign up with</h3>
        <div class="social-login">
          <button class="google">Continue with Google</button>
          <button class="facebook">Continue with Facebook</button>
          <button class="apple">Continue with Apple</button>
        </div>
        <p>Or <a href="../sign up/signup.php">create an account</a> manually.</p>
      </div>
    </div>

    <script src="script.js"></script>
  </body>
</html>