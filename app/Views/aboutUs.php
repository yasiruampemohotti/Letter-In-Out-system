<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - University of Colombo</title>

    <!-- Add Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            display: flex;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
        }

        .sidebar {
            width: 250px;
            background-color: #1e3a8a;
            color: white;
            height: 100vh;
            display: flex;
            flex-direction: column;
            padding-top: 20px;
            position: relative; /* Ensure proper positioning of footer */
        }

        .sidebar h3 {
            color: #e0e7ff;
            font-weight: bold;
        }

        .sidebar a {
            color: #e0e7ff;
            text-decoration: none;
            padding: 10px 20px;
            display: block;
        }

        .sidebar a:hover {
            background-color: #2563eb;
            color: #ffffff;
        }

        .sidebar-link {
            color: #93c5fd;
            text-decoration: none;
            padding: 10px;
            transition: color 0.3s ease;
        }

        .sidebar-link:hover {
            color: #bfdbfe;
        }

        .sidebar-footer {
            margin-top: auto;
            padding: 10px 20px;
            text-align: center;
        }

        .sidebar-footer a {
            color: #60a5fa;
            text-decoration: none;
        }

        .sidebar-footer a:hover {
            color: #93c5fd;
        }

        .content {
            flex-grow: 1;
            padding: 20px;
            background-color: #f0f8ff;
        }

        .container {
            background-color: #ffffff;
            padding: 20px 40px;
            margin-top: 75px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 100%;
            max-width: 800px;
        }

        h1 {
            color: #1e3a8a;
            margin-bottom: 20px;
            font-size: 2rem;
        }

        h2 {
            color: #2563eb;
            margin-top: 15px;
            font-size: 1.5rem;
        }

        p {
            font-size: 1rem;
            color: #555;
            line-height: 1.6;
        }

        button {
            background-color: #2563eb;
            color: white;
            padding: 10px 20px;
            margin: 20px 0;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
        }

        button:hover {
            background-color: #1e40af;
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <h3 class="text-center">Letter In/Out</h3>
        <a href="<?= site_url('dashboard') ?>">Dashboard</a>
        <a href="<?= site_url('addLetter') ?>">Add Letter</a>
        <a href="<?= site_url('updateLetter') ?>">Update Letter</a>
        <a href="<?= site_url('letterList') ?>">Letter List</a>
        <a href="<?= site_url('aboutUs') ?>">About Us</a>

        <div class="sidebar-footer">
            <form action="<?= site_url('logout') ?>" method="post">
                <?= csrf_field() ?> <!-- Include CSRF token for security -->
                <button type="submit" class="btn btn-danger w-100 mt-2">Log Out</button>
            </form>  
            <a href="https://expo.dev/accounts/dinn24/projects/newLetter/builds/abac5d3b-33e3-4bbf-83a5-57b24cc69fb3" target="_blank" class="sidebar-link">
                <u>Get the Mobile App</u>
            </a>
        </div>
    </div>
    
    <div class="content">
        <div class="container">
            <h1>About Us</h1>

            <h2>Our Vision</h2>
            <p>At the University of Colombo, our vision is to be a global leader in education, research, and innovation. We aim to produce graduates who are well-equipped to meet the challenges of the modern world.</p>

            <h2>Our Mission</h2>
            <p>Our mission is to foster an environment of academic excellence, support cutting-edge research, and serve the community by offering innovative programs that address global and local challenges.</p>

            <h2>Our Values</h2>
            <p>We value integrity, innovation, diversity, and collaboration. These values guide our decisions, actions, and interactions, allowing us to develop not only academically proficient individuals but responsible global citizens.</p>

            <h2>Join Us</h2>
            <p>If you are passionate about learning and contributing to society through research and innovation, we invite you to explore the opportunities at the University of Colombo.</p>
        </div>
    </div>
</body>

</html>
