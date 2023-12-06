<?php
if(isset($_GET["id"])){
    $id = $_GET["id"];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "orders";

    $connection = new mysqli($servername, $username, $password, $database);

    $sql = "DELETE FROM orders WHERE id = $id";
    $connection -> query($sql);
    header("location : /SCS_Task/project1/order_history.php");
    exit;
}

header("location : /SCS_Task/project1/order_history.php");
exit;

?>