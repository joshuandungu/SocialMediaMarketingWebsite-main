<!DOCTYPE html>
<html>
<head>
    <title>Order History</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .button {
            display: flex;
            justify-content: flex-end;
            text-align: right;
        }

        .center {
            text-align: center;
        }

        .edit {
            color: blue;
            cursor: pointer;
        }

        .preview-image {
            max-width: 100px;
            height: auto;
        }
    </style>
</head>
<body>
    <h1>Order History</h1>

    <div>
        <br><br><a class="btn btn-success" href="/SCS_Task/project1/index.php" role="button">New Order</a>
    </div>

    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Password</th>
            <th>Email</th>
            <th>Gender</th>
            <th>Platform</th>
            <th>Service</th>
            <th>Quantity</th>
            <th>Language</th>
            <th>Payment Screenshot</th>
            <th>Actions</th>
        </tr>
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "orders";

        $connection = new mysqli($servername, $username, $password, $database);

        if ($connection->connect_error) {
            die("Connection failed: " . $connection->connect_error);
        }

        $sql = "SELECT * FROM orders";
        $result = $connection->query($sql);

        if (!$result) {
            die("Invalid query: " . $connection->error);
        }

        while ($row = $result->fetch_assoc()) {
            echo "
            <tr>
                <th>$row[id]</th>
                <th>$row[username]</th>
                <th>$row[pass]</th>
                <th>$row[email]</th>
                <th>$row[gender]</th>
                <th>$row[platform]</th>
                <th>$row[service]</th>
                <th>$row[quantity]</th>
                <th>$row[lang]</th>
                <th><img src='data:image/jpeg;base64," . base64_encode($row['screenshot']) . "' class='preview-image'></th>
                <th>
                    <a class='btn btn-primary btn-sm' href='/SCS_Task/project1/edit.php?id=$row[id]'>Edit</a>
                    <a class='btn btn-danger btn-sm' href='/SCS_Task/project1/deleterecord.php?id=$row[id]'>Delete</a>
                </th>
            </tr>
            ";
        }
        ?>
    </table>
</body>
</html>
