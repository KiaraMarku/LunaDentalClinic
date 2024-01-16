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
                                <th scope="col">Patient</th>';
                                
                                if ($_SESSION['user_role'] == "Manager")
                                    echo '  <th scope="col">Doctor</th>';
                                echo '
                                <th scope="col">Schedule</th>
                                <th scope="col">Operations</th>
                            </tr>
                        </thead>
                        <tbody>';
                            
                            if ($_SESSION['user_role'] == "Manager")
                                $read_query = "SELECT appointments.id,doctors.username,appointments.schedule ,patients.name FROM appointments INNER JOIN patients ON appointments.patient_id=patients.id INNER JOIN doctors ON appointments.doctor_id=doctors.id WHERE schedule>NOW() AND (doctors.username LIKE '%$searchTerm%' OR patients.name LIKE '%$searchTerm%') ORDER BY schedule ";
                            else  $read_query = "SELECT appointments.id,appointments.schedule,doctors.username,patients.name FROM appointments INNER JOIN patients ON appointments.patient_id=patients.id INNER JOIN doctors ON appointments.doctor_id=doctors.id WHERE doctors.username='$username' AND patients.name LIKE '%$searchTerm%' AND  schedule>NOW() ORDER BY schedule";
                            $result = mysqli_query($conn, $read_query);
                            if ($result) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $id = $row['id'];
                                    $patient = $row['name'];
                                    $doctor = $row['username'];
                                    $schedule = $row['schedule'];

                                    echo '<tr>
                            <th scope="row">' . $id . '</th>
                            <td>' . $patient  . '</td>';
                                    if ($_SESSION['user_role'] == "Manager")
                                        echo '
                            <td>' .  $doctor . '</td>';
                                    echo '
                            <td>' . $schedule . '</td>';
                                    echo '
                            <td>
                                <button class="btn btn-info"><a href="updateappointment.php?update_id=' . $id . '" class="text-light">Update</a></button>
                                <button type="button" class="btn btn-danger delete-btn" data-toggle="modal" data-target="#deleteModal" data-url="deleteappointment.php?delete_id=' . $id . '">Delete</button>

                            </td>
                            </tr>';
                                }
                            }
                            

                            
                            if ($_SESSION['user_role'] == "Manager")
                                $read_query = "SELECT appointments.id,doctors.username,appointments.schedule ,patients.name FROM appointments INNER JOIN patients ON appointments.patient_id=patients.id INNER JOIN doctors ON appointments.doctor_id=doctors.id  WHERE schedule<=NOW() AND (doctors.username LIKE '%$searchTerm%'OR patients.name LIKE '%$searchTerm%') ORDER BY schedule ";
                            else  $read_query = "SELECT appointments.id,appointments.schedule,doctors.username,patients.name FROM appointments INNER JOIN patients ON appointments.patient_id=patients.idINNER JOIN doctors ON appointments.doctor_id=doctors.id  WHERE doctors.username='$username' AND doctor_username LIKE '%$searchTerm%' AND patients.name LIKE '%$searchTerm%' AND  schedule<=NOW() ORDER BY schedule";
                            $result = mysqli_query($conn, $read_query);
                            if ($result) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $id = $row['id'];
                                    $patient = $row['name'];
                                    $doctor = $row['username'];
                                    $schedule = $row['schedule'];

                                    echo '<tr>
                            <th scope="row">' . $id . '</th>
                            <td>' . $patient  . '</td>';
                                    if ($_SESSION['user_role'] == "Manager")
                                        echo '
                            <td>' .  $doctor . '</td>';
                                    echo '
                            <td>' . $schedule . '</td>';
                                }
                            }
                
                       echo '  </tbody>
                    </table>'; 
                    echo'<button class="btn btn-info my-5"><a href="manageappointments.php" class="text-light">Back</a></button>';
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