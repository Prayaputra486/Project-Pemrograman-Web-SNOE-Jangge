<?php
include 'db.php';
session_start();
$stmt_kategori = $pdo->query("SELECT * FROM kategori_menu WHERE status='aktif' AND id_kategori < 301");
$stmt_set = $pdo->query("SELECT * FROM menu WHERE id_kategori = 301 AND status='aktif'");
?>
<?php include 'header.php'; ?>
<main class="container">
  <section class="content-section">
    <h2 class="welcome-heading" style="margin-top: 0;">SNÖE Jangge Menu List</h2>
    <hr class="separator">
    <div class="row g-4 justify-content-center">
      <?php
      while ($kategori = $stmt_kategori->fetch()) {
          echo '<div class="col-md-3">';
          echo '<div class="menu-item-box">';
          echo '<h3>' . htmlspecialchars($kategori['nama_kategori']) . '</h3>';
          echo '<ul class="menu-list-utama">';
          $id_kategori = $kategori['id_kategori'];
          $stmt_menu = $pdo->prepare("SELECT * FROM menu WHERE id_kategori = :id_kategori AND status = 'aktif'");
          $stmt_menu->execute(['id_kategori' => $id_kategori]);
          while ($menu = $stmt_menu->fetch()) {
              echo '<li>';
              echo '<span class="menu-item-name">' . htmlspecialchars($menu['nama_menu']) . '</span>';
              echo '<span class="menu-item-price"> €' . rtrim(rtrim(number_format($menu['harga_euro'], 2, '.', ''), '0'), '.') . ' | $' . rtrim(rtrim(number_format($menu['harga_dollar'], 2, '.', ''), '0'), '.') . '</span>';
              echo '</li>';
          }
          echo '</ul>';
          echo '</div>';
          echo '</div>';
      }
      ?>
    </div>
  </section>
</main>
<br><br>
<section class="container py-5">
  <h2 class="welcome-heading">SNÖE Jangge Set Menu</h2>
  <hr class="separator">
  <div class="row g-4 justify-content-center">
    <?php
    while ($set = $stmt_set->fetch()) {
        echo '<div class="col-md-4">';
        echo '<div class="promo-box">';
        echo '<h4>' . htmlspecialchars($set['nama_menu']) . '</h4>';
        echo '<ul class="list-unstyled">';
        $deskripsi_list = explode(',', $set['deskripsi']);
        foreach ($deskripsi_list as $item) {
            if (preg_match('/(.+?)\((.+)\)/', trim($item), $match)) {
                echo '<li><span class="menu-item-name">' . htmlspecialchars(trim($match[1])) . '</span></li>';
                echo '<li>(' . htmlspecialchars(trim($match[2])) . ')</li>';
                echo '<hr class="separator">';
            } else {
                echo '<li>' . htmlspecialchars(trim($item)) . '</li>';
                echo '<hr class="separator">';
            }
        }
        $harga_euro = rtrim(rtrim($set['harga_euro'], '0'), '.');
        $harga_dollar = rtrim(rtrim($set['harga_dollar'], '0'), '.');
        echo '</ul>';
        echo '<span class="promo-price">€' . $harga_euro . ' - $' . $harga_dollar . '</span>';
        echo '</div>';
        echo '</div>';
    }
    ?>
  </div>
  <div class="text-center mt-5">
    <p class="fw-bold fs-5" style="color:#ffcc80;">Make your reservation now!</p>
  </div>
</section>
<?php include 'footer.php'; ?>
</body>
</html>