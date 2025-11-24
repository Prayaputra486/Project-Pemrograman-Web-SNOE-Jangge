<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SNÖE Jangge</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Pacifico&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <script src="snow.js"></script>
  <header class="mb-4 shadow">
    <div class="container d-flex justify-content-between align-items-center">
      <a href="index.php" class="logo-image">SNÖE Jangge</a>
      <nav>
        <ul class="d-flex">
          <li><a href="index.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">HOME</a></li>
          <li><a href="menu.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'menu.php' ? 'active' : ''; ?>">MENU</a></li>
          <li><a href="blog.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'blog.php' ? 'active' : ''; ?>">BLOG</a></li>
          <li><a href="information.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'information.php' ? 'active' : ''; ?>">INFORMATION</a></li>
          <li><a href="reservation.php" class="<?php 
              $current_page = basename($_SERVER['PHP_SELF']);
              $reservation_pages = ['reservation.php', 'reservation_form.php', 'reservation_tables.php', 'scanner.php'];
              echo in_array($current_page, $reservation_pages) ? 'active' : '';
          ?>">RESERVATION</a></li>
          <?php if (isset($_SESSION['login'])): ?>
            <li><a href="logout.php" class="text-warning text-decoration-none fw-bold">LOGOUT</a></li>
          <?php else: ?>
            <li><a href="login.php" class="text-warning text-decoration-none fw-bold">LOGIN</a></li>
          <?php endif; ?>
        </ul>
      </nav>
    </div>
  </header>