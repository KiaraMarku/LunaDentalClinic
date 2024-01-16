<!DOCTYPE html>
<?php
include '../connect.php';
session_start();

$username = $_SESSION['user'];

$_SESSION['role']="appointment";
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage doctors</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../projectdemo/css/dashboards.css">
    <style>
        h1 {
            font-size: 25px;
        }

        a {
            text-decoration: none;
        }

        .search_bar {
            display: flex;
            padding: 10px;
            justify-content: space-between;
        }

        .search-bar {
            width: 50%;
            margin: 7px;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            // When the delete button is clicked, store the delete URL in the modal
            $('.delete-btn').on('click', function() {
                var url = $(this).data('url');
                $('#deleteModal').data('url', url);
            });

            // When the confirm button is clicked, redirect to the delete URL
            $('#confirm-delete-btn').on('click', function() {
                var url = $('#deleteModal').data('url');
                window.location.href = url;
            });
        });
    </script>
</head>
</head>

<body>
    <div class="page">
        <?php
        include 'dashboard.html';
        ?>
        <section class="main">>
            <div class="main-body">
                <h1> Welcome back
                    <?php
                    echo  '<span style="margin-left:10px" >' . $username . '<span> ';
                    echo '<span style="float:right">' . date("Y-m-d") . '<span> ';
                    ?>
                </h1>
                <div class="search-bar">
                    <div class="container-fluid">
                        <form class="d-flex" method="post" action="searchappointment.php">
                            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="searchTerm">
                            <button class="btn btn-info text-light" type="submit" name="search"> Search </a></button>
                        </form>
                    </div>
                  
                </div>
                <div class="main-board">
                    <div class="container">
                    <?php
                        echo
                        '<button class="btn btn-primary my-2"><a href="addAppointment.php" class="text-light">Add appointment</a></button>';
                        ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Id</th>
                                    <th scope="col">Patient</th>
                                    <?php
                                    if ($_SESSION['user_role'] == "Manager")
                                        echo '  <th scope="col">Doctor</th>';
                                    ?>
                                    <th scope="col">Schedule</th>
                                    <th scope="col">Operations</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($_SESSION['user_role'] == "Manager")
                                    $read_query = "SELECT appointments.id,appointments.schedule,patients.name,doctors.username  FROM appointments INNER JOIN patients ON appointments.patient_id=patients.id INNER JOIN doctors ON appointments.doctor_id=doctors.id WHERE schedule>NOW() ORDER BY schedule ";
                                else  $read_query = "SELECT appointments.id,appointments.schedule,patients.name,doctors.username FROM appointments INNER JOIN patients ON appointments.patient_id=patients.id  INNER JOIN doctors  ON appointments.doctor_id=doctors.id WHERE doctors.username='$username' AND  schedule>NOW() ORDER BY schedule";
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
                                <button class="btn btn-info"><a href="updateappointment.php?update_id=' . $id . '&patient_name='.$patient.'&doc_username='.$doctor.'&schedule='.$schedule.'" class="text-light">Update</a></button>
                                <button type="button" class="btn btn-danger delete-btn" data-toggle="modal" data-target="#deleteModal" data-url="deleteappointment.php?delete_id=' . $id . '">Delete</button>

                            </td>
                            </tr>';
                                    }
                                }
                                 ?>

                                <?php
                                if ($_SESSION['user_role'] == "Manager")
                                    $read_query = "SELECT appointments.id,appointments.schedule ,patients.name,doctors.username FROM appointments INNER JOIN patients ON appointments.patient_id=patients.id INNER JOIN doctors ON appointments.doctor_id=doctors.id WHERE schedule<=NOW() ORDER BY schedule ";
                                else  $read_query = "SELECT appointments.id,appointments.schedule,patients.name,doctors.username FROM appointments INNER JOIN patients ON appointments.patient_id=patients.id INNER JOIN doctors ON appointments.doctor_id=doctors.id WHERE doctors.username='$username' AND  schedule<=NOW() ORDER BY schedule";
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
                                <button type="button" class="btn btn-danger delete-btn" data-toggle="modal" data-target="#deleteModal" data-url="deleteappointment.php?delete_id=' . $id . '">Delete</button>
                            </td>
                            </tr>';
                                    }
                                }
                                ?>

                            </tbody>
                        </table>
                     

                    </div>

                 </div>
             </div>
         </section>
     </div>




    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Delete appointment</h1>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete oppointment?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="confirm-delete-btn">Confirm Delete</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>