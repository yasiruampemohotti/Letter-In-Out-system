<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Location</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .form-container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }
        h1 {
            color: #1e3a8a;
            margin-bottom: 20px;
            font-size: 2rem;
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"] {
            width: 90%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #2563e5;
            color: white;
            border: none;
            padding: 10px;
            width: 35%;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #1e40af;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h1>Add Location</h1>
    <form action="<?= base_url('/location/addLocation'); ?>" method="post">
        <input type="text" name="location_name" placeholder="Enter location name" required>
        <button type="submit">Save Location</button>
    </form>
</div>

</body>
</html>
