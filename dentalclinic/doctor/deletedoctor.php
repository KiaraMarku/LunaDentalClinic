<!DOCTYPE html>
<?php
include '../connect.php';
session_start();
$role = $_SESSION['user_role'];
if($role!='Manager')
die("You dont have acces in this page");

if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];

    $delete_query = "delete from doctors where id=$id";
    $result = mysqli_query($conn, $delete_query);
    if ($result) {
        header("location:managedoctors.php");
    } else {
        die();
    }
}
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud delete</title>
</head>

<body>

</body>

</html>