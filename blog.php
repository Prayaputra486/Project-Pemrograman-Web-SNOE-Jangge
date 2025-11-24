<?php
session_start();
include 'db.php';
?>
<?php include 'header.php'; ?>
  <main class="container">
    <section class="content-section">
      <h2 class="welcome-heading">SNÖE Jangge Blog</h2>
      <hr class="separator">
      <div class="blog-container">
        <?php
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $blog_id = $_GET['id'];
            $stmt = $pdo->prepare("SELECT * FROM blog WHERE id_blog = ? AND status = 'published'");
            $stmt->execute([$blog_id]);
            $blog = $stmt->fetch();
            if ($blog) {
                echo '<div class="blog-detail-wide">';
                if (!empty($blog['gambar'])) {
                    echo '<img src="' . htmlspecialchars($blog['gambar']) . '" alt="' . htmlspecialchars($blog['judul']) . '" class="blog-detail-image-wide">';
                }
                echo '<h1 class="blog-detail-title-wide">' . htmlspecialchars($blog['judul']) . '</h1>';
                echo '<div class="blog-detail-meta-wide">';
                echo '<span class="blog-author"><i class="fas fa-user"></i> ' . htmlspecialchars($blog['penulis']) . '</span>';
                echo '<span class="blog-date"><i class="fas fa-calendar"></i> ' . date('F j, Y', strtotime($blog['tanggal'])) . '</span>';
                echo '</div>';
                echo '<div class="blog-detail-content-wide">';
                echo nl2br(htmlspecialchars($blog['isi']));
                echo '</div>';
                echo '<div class="text-center">';
                echo '<a href="blog.php" class="back-to-blog-wide">';
                echo '<i class="fas fa-arrow-left"></i>';
                echo '</a>';
                echo '</div>';
                echo '</div>';
            } else {
                echo '<div class="no-blogs">';
                echo '<i class="fas fa-exclamation-circle"></i>';
                echo '<h3>Blog Post Not Found</h3>';
                echo '<p>The blog post you are looking for does not exist or has been removed.</p>';
                echo '<a href="blog.php" class="read-more-btn-wide">Back to Blog</a>';
                echo '</div>';
            }
        } else {
            $stmt = $pdo->query("SELECT * FROM blog WHERE status = 'published' ORDER BY tanggal DESC");
            $blogs = $stmt->fetchAll();
            if ($blogs) {
                echo '<div class="blog-list-vertical">';
                foreach ($blogs as $blog) {
                    echo '<a href="blog.php?id=' . $blog['id_blog'] . '" class="blog-card-wide clickable-card">';
                    echo '<div class="blog-image-container">';
                    if (!empty($blog['gambar'])) {
                        echo '<img src="' . htmlspecialchars($blog['gambar']) . '" alt="' . htmlspecialchars($blog['judul']) . '" class="blog-image-wide">';
                    } else {
                        echo '<img src="https://via.placeholder.com/350x280/3e2723/ffcc80?text=SNÖE+Jangge" alt="Default Blog Image" class="blog-image-wide">';
                    }
                    echo '</div>';
                    echo '<div class="blog-content-wide">';
                    echo '<div>';
                    echo '<h3 class="blog-title-wide">' . htmlspecialchars($blog['judul']) . '</h3>';
                    if (!empty($blog['excerpt'])) {
                        echo '<p class="blog-excerpt-wide">' . htmlspecialchars($blog['excerpt']) . '</p>';
                    } else {
                        $excerpt = strlen($blog['isi']) > 200 ? substr($blog['isi'], 0, 200) . '...' : $blog['isi'];
                        echo '<p class="blog-excerpt-wide">' . htmlspecialchars($excerpt) . '</p>';
                    }
                    echo '</div>';
                    echo '<div class="blog-meta-wide">';
                    echo '<span class="blog-author"><i class="fas fa-user"></i> ' . htmlspecialchars($blog['penulis']) . '</span>';
                    echo '<span class="blog-date"><i class="fas fa-calendar"></i> ' . date('M j, Y', strtotime($blog['tanggal'])) . '</span>';
                    echo '</div>';
                    echo '</div>';
                    echo '</a>';
                }
                echo '</div>';
            } else {
                echo '<div class="no-blogs">';
                echo '<i class="fas fa-coffee"></i>';
                echo '<h3>No Blog Posts Yet</h3>';
                echo '<p>Stay tuned for exciting updates, coffee tips, and news from SNÖE Jangge!</p>';
                echo '</div>';
            }
        }
        ?>
      </div>
    </section>
  </main>
<?php include 'footer.php'; ?>
</body>
</html>