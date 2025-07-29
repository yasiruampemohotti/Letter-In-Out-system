<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Letter - University of Colombo</title>
    
    <!-- Add Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            display: flex;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #e6f3ff; /* Light blue background */
        }

        .sidebar {
            width: 250px;
            background-color: #1e3a8a; /* Blue background */
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
            background-color: #f8f9fa; /* White background */
        }

        .container {
            background-color: #ffffff;
            padding: 20px 40px;
            margin-top: 150px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 100%;
            max-width: 500px;
        }

        h1 {
            color: #0056b3; /* Blue heading */
            margin-bottom: 20px;
            font-size: 2rem;
        }

        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            margin: 20px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
            box-sizing: border-box;
        }

        button {
            background-color: #0056b3;
            color: white;
            padding: 10px 20px;
            margin: 20px 0;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #003d80; /* Darker blue */
        }

        .radio-buttons {
            display: flex;
            gap: 20px; /* Space between radio buttons */
            justify-content: center;
        }

        .custom-radio {
            display: flex;
            align-items: center;
            position: relative;
            cursor: pointer;
        }

        .custom-radio input[type="radio"] {
            appearance: none;
            width: 20px;
            height: 20px;
            border: 2px solid #0056b3; /* Blue border */
            border-radius: 50%;
            outline: none;
            margin-right: 10px;
            transition: background 0.3s, box-shadow 0.3s;
        }

        .custom-radio input[type="radio"]:hover {
            box-shadow: 0 0 5px rgba(0, 85, 179, 0.7); /* Blue glow effect */
        }

        .custom-radio input[type="radio"]:checked {
            background-color: #0056b3;
            box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.3);
        }

        .radio-label {
            font-size: 16px;
            color: #333;
            user-select: none;
        }

        @media (max-width: 600px) {
            .container {
                padding: 20px;
            }

            h1 {
                font-size: 1.5rem;
            }

            button {
                width: 100%;
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
            <h1>Update Letter</h1>
            <form method="post" action="/LetterController/updateLetter">
                <input type="text" name="reference_number" placeholder="Reference Number" required><br>

                <div class="radio-buttons">
                    <label class="custom-radio">
                        <input type="radio" name="letter_type" value="Letter In" required>
                        <span class="radio-label">Letter In</span>
                    </label>
                    <label class="custom-radio">
                        <input type="radio" name="letter_type" value="Letter Out"> 
                        <span class="radio-label">Letter Out</span>
                    </label>
                    <label class="custom-radio">
                        <input type="radio" name="letter_type" value="Finished">
                        <span class="radio-label">Finished</span>
                    </label>
                </div>
        
                <button type="submit">Update</button>
            </form>
        </div>
    </div>
</body>
</html>
