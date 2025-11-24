<?php include 'db.php';?>
<?php include 'header.php'; ?>
  <main class="container">
    <section class="content-section">
      <h2 class="welcome-heading">SNÖE Jangge Member Login</h2>
      <hr class="separator">
      <div class="d-flex justify-content-center mt-5">
        <div class="card shadow-lg p-4"
          style="background-color: rgba(62,39,35,0.85); color:#f5f5dc; width: 100%; max-width: 400px; border-radius: 15px;">
          <form action="login_proses.php" method="POST">
            <div class="mb-3">
              <h5 style="color: #ffd180;" ;>Username:</h5>
              <input type="text" id="username" name="username" class="form-control" placeholder="Enter your username"
                required>
            </div>
            <div class="mb-3">
              <h5 style="color: #ffd180;" ;>Password:</h5>
              <input type="password" id="password" name="password" class="form-control"
                placeholder="Enter your password" required>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-3">
              <div class="form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label for="remember" class="form-check-label text-light">Remember me</label>
              </div>
              <a href="#" class="text-warning text-decoration-none small">Forgot password?</a>
            </div>
            <div class="d-grid">
              <button type="submit" class="btn fw-bold" style="background-color:#ffffffff;">Login</button>
            </div>
            <hr class="my-4" style="border-color: rgba(255, 204, 128, 0.4);">
            <p class="text-center text-light mb-0">Don't have an account? <a href="register.php"
                class="text-warning text-decoration-none fw-bold">Register here</a></p>
          </form>
        </div>
      </div>
    </section>
  </main>
<?php include 'footer.php'; ?>
</body>
</html>