<!-- Bootstrap CSS -->
<style>
    /* Sidebar */
    .sidebar {
  width: 250px;
  background: linear-gradient(to right, #1A0F18, #3D1E31);
   color: white;
  height: 100vh;
  padding: 20px;
  box-shadow: 2px 0 8px rgba(0, 0, 0, 0.1);
  position: fixed;
  top: 0;
  left: 0;
  z-index: 1000;
}

.sidebar h2 {
  font-size: 22px;
  margin-bottom: 30px;
  text-align: center;
  font-weight: 700;
  color: #ffff
}

.sidebar a {
  display: block;
  color: white;
  text-decoration: none;
  padding: 10px 15px;
  margin-bottom: 10px;
  border-radius: 8px;
  transition: background 0.3s;
  font-size: 16px;
}

.sidebar a:hover {
  background: #444;
}

.sidebar a.active {
  background: #333;
  font-weight: 700;
}
</style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">


<div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="admin.php"><i class="fas fa-chart-line"></i> Dashboard</a>
        <a href="addgenre.php"><i class="fas fa-tags"></i> Genres</a>
        <a href="./stories_add.php"><i class="fas fa-book"></i> Stories</a>
        <a href="./author_add.php"><i class="fas fa-book"></i> authors</a>
        <a href="./add_quiz.php"><i class="fas fa-book"></i> add quiz</a>
        <a href="./video_add.php"><i class="fas fa-book"></i> Manage Video</a>
        <a href="./user_stories.php"><i class="fas fa-book"></i> Users Story</a>
        <a href="manage-users.php"><i class="fas fa-users"></i> Users</a>
        <a href="content_moderation.php"><i class="fas fa-gavel"></i> Moderation</a>
        <a href="contant_page.php"><i class="fas fa-gavel"></i> Contact Review</a>
    </div>

    