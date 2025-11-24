<?php include 'db.php';?>
<?php include 'header.php'; ?>
<main class="container">
  <section class="content-section">
    <h2 class="welcome-heading" style="margin-top: 0;">SNÖE Jangge Member Registration</h2>
    <hr class="separator">
    <div class="d-flex justify-content-center mt-5">
      <div class="card shadow-lg p-4" style="background-color: rgba(62,39,35,0.85); color:#f5f5dc; width: 100%; max-width: 450px; border-radius: 15px;">
        <form action="register_proses.php" method="POST">
          <div class="mb-3">
            <h5 style="color: #ffd180;";>Full Name:</h5>
            <input type="text" id="nama" name="nama" class="form-control" placeholder="Enter your full name" required>
          </div>
          <div class="mb-3">
            <h5 style="color: #ffd180;";>Email:</h5>
            <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email address" required>
          </div>
          <div class="mb-3">
            <h5 style="color: #ffd180;";>Phone Number:</h5>
            <input type="text" id="no_telp" name="no_telp" class="form-control" placeholder="Enter your phone number" required>
          </div>
          <div class="mb-3">
            <h5 style="color: #ffd180;";>Username:</h5>
            <input type="text" id="username" name="username" class="form-control" placeholder="Choose a username" required>
          </div>
          <div class="mb-3">
            <h5 style="color: #ffd180;";>Password:</h5>
            <input type="password" id="password" name="password" class="form-control" placeholder="Create a password" required>
          </div>
          <div class="d-grid mt-4">
            <button type="submit" class="btn fw-bold" style="background-color:#ffffffff;">Register</button>
          </div>
          <hr class="my-4" style="border-color: rgba(255, 204, 128, 0.4);">
          <p class="text-center text-light mb-0">Already have an account? <a href="login.php" class="text-warning text-decoration-none fw-bold">Login here</a></p>
        </form>
      </div>
    </div>
  </section>
</main>
<?php include 'footer.php'; ?>
</body>
</html>