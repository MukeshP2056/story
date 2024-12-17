<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basic Layout Page</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Reset some default styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    line-height: 1.6;
    color: #333;
    background-color: #f9f9f9;
}

.container {
    width: 90%;
    max-width: 1200px;
    margin: 0 auto;
}

/* Header Styles */
.header {
    background-color: #333;
    color: #fff;
    padding: 20px 0;
}

.header h1 {
    font-size: 1.8rem;
    text-align: center;
    margin-bottom: 10px;
}

.nav ul {
    list-style: none;
    display: flex;
    justify-content: center;
    gap: 15px;
}

.nav a {
    color: #fff;
    text-decoration: none;
    font-weight: bold;
}

.nav a:hover {
    color: #ffdd57;
}

/* Layout Styles */
.layout {
    display: flex;
    gap: 20px;
    margin-top: 20px;
}

/* Sidebar Styles */
.sidebar {
    flex: 1;
    background-color: #ddd;
    padding: 15px;
    border-radius: 5px;
}

.sidebar h2 {
    font-size: 1.4rem;
    margin-bottom: 10px;
}

.sidebar ul {
    list-style: none;
}

.sidebar ul li {
    margin-bottom: 10px;
}

.sidebar a {
    text-decoration: none;
    color: #333;
}

.sidebar a:hover {
    color: #ff5733;
}

/* Main Content Styles */
.content {
    flex: 3;
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.1);
}

.content h2 {
    font-size: 1.6rem;
    margin-bottom: 10px;
}

/* Footer Styles */
.footer {
    background-color: #333;
    color: #fff;
    text-align: center;
    padding: 10px;
    margin-top: 20px;
}

.footer p {
    margin: 0;
}

/* Responsive Design */
@media (max-width: 768px) {
    .layout {
        flex-direction: column;
    }

    .nav ul {
        flex-direction: column;
        text-align: center;
    }
}

    </style>
  

</head>
<body>

<!-- Header -->
<header class="header">
    <div class="container">
        <h1>Website Title</h1>
        <nav class="nav">
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Services</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </nav>
    </div>
</header>

<!-- Main Layout -->
<div class="container layout">
    
    <!-- Sidebar -->
    <aside class="sidebar">
        <h2>Sidebar</h2>
        <ul>
            <li><a href="#">Link 1</a></li>
            <li><a href="#">Link 2</a></li>
            <li><a href="#">Link 3</a></li>
            <li><a href="#">Link 4</a></li>
        </ul>
    </aside>
    
    <!-- Main Content -->
    <main class="content">
        <h2>Main Content Area</h2>
        <p>This is the main area where content goes. Add your articles, blog posts, or other main content here.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec vel massa nunc.</p>
    </main>
</div>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <p>&copy; 2023 Your Website. All rights reserved.</p>
    </div>
</footer>

</body>
</html>
