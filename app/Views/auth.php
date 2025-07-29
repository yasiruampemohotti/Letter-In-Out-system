<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auth Page</title>
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
            margin-bottom: 20px;
        }

        .text-center {
            text-align: center;
        }

        .mb-4 {
            margin-bottom: 16px;
            align: center;
        }

        .success {
            color: #28a745;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 16px;
            width: 80%;
            margin: 16px auto;
            text-align: center;
        }

        .error {
            color: #dc3545;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 16px;
            width: 80%;
            margin: 16px auto;
            text-align: center;
        }

        .btn {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            display: block;
            margin: 0 auto 16px;
            text-align: center;
        }

        .btn-primary {
            background-color: #8c08c9;
        }

        .btn:hover {
            background-color: #0056b3;
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
            background-color: #8c08c9; /* Fixed header background color */
            color: white;
        }

        tr:hover {
            background-color: #c0c0c0;
        }

        table tr:hover thead {
            background-color: #8c08c9 !important; /* Keep the header color constant even on hover */
        }

        /* Exclude the header from hover styles */
        thead tr:hover {
            background-color: inherit;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #dee2e6;
        }

        thead th {
            cursor: default; /* No pointer effect for headers */
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #c0c0c0;
        }

        td[colspan="7"] {
            text-align: center;
        }

        @media (max-width: 768px) {
            .table {
                font-size: 14px;
            }

            th, td {
                padding: 8px;
            }
        }

        /* New flexbox container */
        .flex-container {
            display: flex;
            justify-content: center;
            gap: 10px; /* Adjusts the space between the elements */
            align-items: center; /* Aligns the items vertically centered */
        }

        .flex-container input[type="text"] {
            padding: 8px;
            font-size: 14px;
            width: 250px; /* Adjusts width of the search input box */
        }

        .flex-container .btn {
            padding: 10px 20px;
        }
    </style>
</head>
<body>
    <h1 class="mb-4 text-center">All Letters</h1>

    <?php if (session()->getFlashdata('success')): ?>
        <p class="success"><?= session()->getFlashdata('success'); ?></p>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <p class="error"><?= session()->getFlashdata('error'); ?></p>
    <?php endif; ?>

    <!-- View to provide the PDF download option -->
    <form action="<?= site_url('letter/downloadPdf'); ?>" method="get">
        <button type="submit" class="btn btn-primary">Download Letter List as PDF</button>
    </form>

    <!-- Search bar, search button, and download button on the same level -->
    <form action="<?= site_url('letter/search'); ?>" method="get" class="flex-container mb-4">
        <input type="text" name="query" placeholder="Search letters..." value="<?= isset($query) ? esc($query) : ''; ?>" />
        <button type="submit" class="btn btn-primary">Search</button>
        
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Sender Address</th>
                <th>Receiver Address</th>
                <th>Reference Number</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Updated At</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($letters) && is_array($letters)): ?>
                <?php foreach ($letters as $letter): ?>
                    <tr>
                        <td><?= esc($letter['id']); ?></td>
                        <td><?= esc($letter['title']); ?></td>
                        <td><?= esc($letter['sender_address']); ?></td>
                        <td><?= esc($letter['receiver_address']); ?></td>
                        <td><?= esc($letter['reference_number']); ?></td>
                        <td><?= esc($letter['letter_status']); ?></td>
                        <td><?= esc($letter['created_at']); ?></td>
                        <td><?= esc($letter['updated_at']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">No letters found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
