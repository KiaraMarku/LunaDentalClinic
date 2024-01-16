<!DOCTYPE html>
<?php
include '../connect.php';
session_start();

$username = $_SESSION['user'];
$role = $_SESSION['role'];
$searchTerm = $_POST['searchTerm'];
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>searchresults</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../projectdemo/css/dashboards.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

    <style>
        a {
            text-decoration: none;
        }

        .search-bar {
            width: 50%;
            margin: 7px;
        }
    </style>
</head>


<div class="page">
    <?php
    include 'dashboard.html';
    ?>
    <section class="main">
        <div class="main-body">
            <h1> Welcome back
                <?php
                echo  '<span style="margin-left:10px" >' . $username . '<span> ';
                echo '<span style="float:right">' . date("Y-m-d") . '<span> ';
                ?>
            </h1>

            <div class="main-board">
                <div class="container" id="searchResults">
                   <?php 
                  
                    echo '
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Username</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Specilaty</th>';
                                
                                if ($_SESSION['user_role'] == "Manager")
                                    echo '
                                    <th scope="col">Operations</th>    
                            </tr>
                        </thead>
                        <tbody>';

                            
                            $read_query = "select * from doctors  where name LIKE '%$searchTerm%' OR  username LIKE '%$searchTerm%' ";
                            $result = mysqli_query($conn, $read_query);
                            if ($result) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $id = $row['id'];
                                    $name = $row['name'];
                                    $doc_username = $row['username'];
                                    $email = $row['email'];
                                    $phone = $row['phone'];
                                    $specilaty = $row['specialty'];

                                    echo '<tr>
                            <th scope="row">' . $id . '</th>
                             <td>' . $doc_username . '</td>
                             <td>' . $name . '</td>
                            <td> <a href="mailto:' . $email . '">' . $email . '<a/>  </td>
                            <td>' . $phone . '</td>
                            <td>' . $specilaty . '</td>';
                                    if ($_SESSION['user_role'] == "Manager")
                                        echo '
                            <td>
                                <button class="btn btn-info my-2" ><a href="updatedoctor.php?update_id=' . $id . '" class="text-light">Update</a></button>
                                <button type="button" class="btn btn-danger delete-btn px-3" data-toggle="modal" data-target="#deleteModal" data-url="deletedoctor.php?delete_id=' . $id . '">Delete</button>

                            </tr>';
                                }
                            }
    
                      echo '</tbody>
                    </table>';
                    echo' <button class="btn btn-info my-5"><a href="managedoctors.php" class="text-light">Back</a></button>';
                     
                   
                    ?>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Delete </h1>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="confirm-delete-btn">Confirm Delete</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
</body>

</html>