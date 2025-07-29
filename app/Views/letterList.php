<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Letter List - University of Colombo</title>

    <!-- Add Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            display: flex;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f0f8ff; /* Light blue background */
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
            border-radius: 5px;
            transition: background 0.3s;
        }

        .sidebar a:hover {
            background-color: #2563eb; /* Darker blue */
        }

        .sidebar-link {
            color: #60a5fa; /* Light blue link */
            text-decoration: none;
            padding: 10px;
            transition: color 0.3s ease;
        }

        .sidebar-link:hover {
            color: #93c5fd;
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
            overflow-y: auto;
        }

        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #1e3a8a;
            margin-bottom: 20px;
            font-size: 2rem;
            text-align: center;
        }

        table {
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        th {
            background-color: #1e3a8a;
            color: #2563eb;
            padding: 10px;
            text-align: center;
        }

        td {
            padding: 10px;
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

        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }

            h1 {
                font-size: 1.5rem;
            }

            table {
                font-size: 0.9rem;
            }

            button {
                padding: 5px 8px;
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
            <h1 class="mb-4">Letter List</h1>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Reference Number</th>
                        <th>Title</th>
                        <th>Sender Address</th>
                        <th>Receiver Address</th>
                        <th>Letter Status</th>
                        <th>Letter Edit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($letters)): ?>
                        <?php foreach ($letters as $letter): ?>
                            <tr>
                                <td><?= $letter['reference_number']; ?>
                                    <button 
                                        onclick="copyToClipboard('<?= $letter['reference_number']; ?>')">
                                        Copy
                                    </button>
                                </td>
                                <td><?= $letter['title']; ?></td>
                                <td><?= $letter['sender_address']; ?></td>
                                <td><?= $letter['receiver_address']; ?></td>
                                <td><?= $letter['letter_status']; ?></td>
                                <td>
                                <a href="<?= site_url('/letter/edit/' . $letter['reference_number']); ?>" class="btn btn-primary">Edit</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">No letters found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function () {
                alert('Copied to clipboard: ' + text);
            }).catch(function (err) {
                console.error('Failed to copy text: ', err);
            });
        }
    </script>
</body>

</html>
