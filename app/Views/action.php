<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
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

        form {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            border-radius: 4px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3;
        }

        a {
            display: inline-block;
            padding: 8px 16px;
            margin-top: 10px;
            background-color: #ccc;
            text-decoration: none;
            border-radius: 4px;
            font-size: 16px;
            color: #333;
        }

        a:hover {
            background-color: #999;
        }

        @media (max-width: 768px) {
            form {
                width: 100%;
                padding: 15px;
            }

            h1 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <h1>Edit User</h1>

    <?php if (session()->getFlashdata('error')): ?>
        <p class="error"><?= session()->getFlashdata('error'); ?></p>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
        <p class="success"><?= session()->getFlashdata('success'); ?></p>
    <?php endif; ?>

    <form action="<?= base_url('/user/edit/' . $user['id']); ?>" method="post">
        <label for="user_type">User Type:</label>
        <select name="user_type" id="user_type" required>
            <option value="normal" <?= $user['user_type'] === 'normal' ? 'selected' : ''; ?>>Normal</option>
            <option value="admin" <?= $user['user_type'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
            <option value="auth" <?= $user['user_type'] === 'auth' ? 'selected' : ''; ?>>Auth</option>
            <option value="officer" <?= $user['user_type'] === 'officer' ? 'selected' : ''; ?>>Officer</option>
        </select><br>

        <label for="account_status">Account Status:</label>
        <select name="account_status" id="account_status" required>
            <option value="active" <?= $user['account_status'] === 'active' ? 'selected' : ''; ?>>Active</option>
            <option value="deactivate" <?= $user['account_status'] === 'deactivate' ? 'selected' : ''; ?>>Deactivate</option>
        </select><br>

        <label for="location">Location:</label>
        <select name="location_id" id="location" required>
            <?php foreach ($locations as $location): ?>
                <option value="<?= $location['id']; ?>" <?= $user['location_id'] === $location['id'] ? 'selected' : ''; ?>>
                    <?= $location['location_name']; ?>
                </option>
            <?php endforeach; ?>
        </select><br>

        <button type="submit">Save Changes</button>
        <a href="<?= base_url('/admin'); ?>">Cancel</a>
    </form>
</body>
</html>
