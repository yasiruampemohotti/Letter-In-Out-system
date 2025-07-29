<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

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
            position: fixed;
            left: 0;
            top: 0;
        }

        .sidebar h3 {
            color: #e0e7ff;
            font-weight: bold;
            text-align: center;
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
            margin-left: 250px;
            padding: 20px;
            background-color: #f0f8ff;
            flex-grow: 1;
            overflow-y: auto;
            height: 100vh;
        }

        .dashboard-container {
            background-color: #ffffff;
            padding: 20px 40px;
            margin-top: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 30px auto;
            text-align: center;
        }

        .profile-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
        }

        .recent-letters, .letter-counts {
            margin-top: 20px;
            padding: 20px;
            background: #ffffff;
            border-radius: 10px;
            max-width: 800px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin: 30px auto;
        }

        th {
            background-color: #1e3a8a;
            color: #2563eb;
            padding: 10px;
            text-align: center;
        }

        td {
            text-align: center;
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
    </style>
</head>

<body>
    <div class="sidebar">
        <h3>Letter In/Out</h3>
        <a href="<?= site_url('dashboard') ?>">Dashboard</a>
        <a href="<?= site_url('addLetter') ?>">Add Letter</a>
        <a href="<?= site_url('updateLetter') ?>">Update Letter</a>
        <a href="<?= site_url('letterList') ?>">Letter List</a>
        <a href="<?= site_url('aboutUs') ?>">About Us</a>
        <div class="sidebar-footer">
            <form action="/logout" method="post">
                <button type="submit" class="btn btn-danger w-100 mt-2">Log Out</button>
            </form>
            <a href="https://expo.dev/accounts/dinn24/projects/newLetter/builds/abac5d3b-33e3-4bbf-83a5-57b24cc69fb3" target="_blank">
                <u>Get the Mobile App</u>
            </a>
        </div>
    </div>

    <div class="content">
        <div class="dashboard-container">
            <h1>User Dashboard</h1>
            <img src="/images/profile.jpg" alt="Profile Picture" class="profile-img">
            <div><strong>User Name:</strong> <?= htmlspecialchars($username); ?></div>
            <div><strong>User Type:</strong> <?= htmlspecialchars($user_type); ?></div>
            <div><strong>Location:</strong> <?= htmlspecialchars($location); ?></div>
        </div>

        <div class="filter-section text-center">
    <form method="get" action="<?= site_url('dashboard') ?>">
        <label for="filter">Filter by Date:</label>
        <select name="filter" id="filter" class="form-select d-inline-block w-auto">
            <option value="">All</option>
            <option value="today" <?= ($filter == 'today') ? 'selected' : '' ?>>Today</option>
            <option value="last7days" <?= ($filter == 'last7days') ? 'selected' : '' ?>>Last 7 Days</option>
            <option value="thismonth" <?= ($filter == 'thismonth') ? 'selected' : '' ?>>This Month</option>
        </select>
        <button type="submit" class="btn btn-primary">Apply</button>
    </form>
</div>


        <!-- Letter Counts by Status -->
        <div class="letter-counts">
    <h2 class="text-center">Letter Summary</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Letter Status</th>
                <th>Count</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($letter_counts)): ?>
                <?php foreach ($letter_counts as $status => $count): ?>
                    <tr>
                        <td><?= htmlspecialchars($status); ?></td>
                        <td><?= $count; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="2">No letter data available.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Recent Letters Table -->
<div class="recent-letters">
    <h2 class="text-center">Letters Details</h2>
    <?php if (!empty($letters)): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Letter Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($letters as $letter): ?>
                    <tr>
                        <td><?= htmlspecialchars($letter['title']); ?></td>
                        <td><?= htmlspecialchars($letter['letter_status']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No recent letters available.</p>
    <?php endif; ?>
</div>

</body>

</html>
