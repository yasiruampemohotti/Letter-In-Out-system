<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }

        h1 {
            font-size: 24px;
            margin: 20px 0;
            text-align: center;
        }

        .success {
            color: #28a745;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            padding: 10px;
            border-radius: 4px;
            margin: 16px auto;
            width: 80%;
            text-align: center;
        }

        .error {
            color: #dc3545;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 10px;
            border-radius: 4px;
            margin: 16px auto;
            width: 80%;
            text-align: center;
        }

        .table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        }

        .table-bordered {
            border: 1px solid #dee2e6;
        }

        thead {
            background-color: #007BFF;
            color: white;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #dee2e6;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #c0c0c0;
        }

        table tr:hover thead {
            background-color: #8c08c9 !important; /* Keep header color fixed */
        }

        thead tr:hover {
            background-color: inherit; /* Ensure header doesn't change on hover */
        }

        td[colspan="8"] {
            text-align: center;
        }

        .btn-edit {
            display: inline-block;
            padding: 6px 12px;
            font-size: 14px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-edit:hover {
            background-color: #0056b3;
        }

        @media (max-width: 768px) {
            .table {
                font-size: 14px;
            }

            th, td {
                padding: 8px;
            }
        }
    </style>
</head>
<body>
    <h1>All Users</h1>

    <div style="text-align: center; margin-bottom: 20px;">
        <a href="<?= base_url('/location/add'); ?>" class="btn-edit" style="background-color: #28a745;">Add Location</a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <p class="success"><?= session()->getFlashdata('success'); ?></p>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <p class="error"><?= session()->getFlashdata('error'); ?></p>
    <?php endif; ?>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Password</th>
            <th>User Type</th>
            <th>User Status</th>
            <th>Location</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
            <?php if (!empty($users) && is_array($users)): ?>
                <?php foreach ($users as $user): ?>
                    <?php if ($user['id'] == session()->get('id')) continue; ?>
                    <tr>
                        <td><?= esc($user['id']); ?></td>
                        <td><?= esc($user['username']); ?></td>
                        <td><?= esc($user['email']); ?></td>
                        <td><?= esc($user['password']); ?></td>
                        <td><?= esc($user['user_type']); ?></td>
                        <td><?= esc($user['account_status']); ?></td>
                        <td><?= esc($user['location_name']); ?></td>
                        <td>
                            <a href="<?= base_url('/user/edit/' . $user['id']); ?>" class="btn-edit">Edit</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">No Users found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>

</html>
