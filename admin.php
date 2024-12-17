<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kahaani - Endless Tales</title>
    <style>
        /* Reset Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        /* Base Layout */
        body {
            display: flex;
            min-height: 100vh;
            background-color: #f4f7f6;
            color: #333;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 250px;
            background-color: #1e2a38;
            color: #ecf0f1;
            position: fixed;
            top: 0;
            bottom: 0;
            padding-top: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .sidebar h2 {
            font-size: 1.8rem;
            margin-bottom: 20px;
        }

        .sidebar nav {
            width: 100%;
        }

        .sidebar nav ul {
            list-style-type: none;
            padding: 0;
        }

        .sidebar nav ul li {
            width: 100%;
        }

        .sidebar nav ul li a {
            display: block;
            padding: 15px;
            color: #ecf0f1;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .sidebar nav ul li a:hover, .sidebar nav ul li a.active {
            background-color: #3498db;
        }

        /* Main Content */
        .main-content {
            margin-left: 250px;
            padding: 20px 40px;
            flex: 1;
        }

        .header {
            padding: 15px;
            background-color: #ffffff;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        .header h1 {
            font-size: 2rem;
            color: #2c3e50;
        }

        .stories {
            display: grid;
            gap: 20px;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        }

        .story-card {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease;
        }

        .story-card:hover {
            transform: translateY(-5px);
        }

        .story-card h3 {
            font-size: 1.5rem;
            color: #34495e;
            margin-bottom: 10px;
        }

        .story-card p {
            color: #7f8c8d;
            line-height: 1.5;
        }

        /* Footer Styling */
        footer {
            background-color: #1e2a38;
            color: #ecf0f1;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
            margin-left: 250px;
            font-size: 0.9rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: relative;
            }
            .main-content {
                margin-left: 0;
            }
            footer {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h2>Story App</h2>
    <nav>
        <ul>
            <li><a href="#home" class="active">Home</a></li>
            <li><a href="#featured">Featured Stories</a></li>
            <li><a href="#categories">Categories</a></li>
            <li><a href="#contact">Contact Us</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
    </nav>
</div>

<!-- Main Content -->
<div class="main-content">
    <div class="header">
        <h1>Welcome to Our Story Page</h1>
        <p>Explore a collection of inspiring and engaging stories.</p>
    </div>

    <section class="stories">
        <div class="story-card">
            <h3>Story Title 1</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce nec felis vel orci luctus.</p>
        </div>
        <div class="story-card">
            <h3>Story Title 2</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce nec felis vel orci luctus.</p>
        </div>
        <div class="story-card">
            <h3>Story Title 3</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce nec felis vel orci luctus.</p>
        </div>
        <div class="story-card">
            <h3>Story Title 4</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce nec felis vel orci luctus.</p>
        </div>
    </section>
</div>

<!-- Footer -->
<footer>
    <p>&copy; 2023 Story App. All rights reserved.</p>
</footer>

</body>
</html>
