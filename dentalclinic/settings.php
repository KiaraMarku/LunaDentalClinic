<?php
include 'connect.php';
session_start();
$username = $_SESSION['user'];
$role = $_SESSION['user_role'];

if ($role == "Manager")
$read_query = "select * from users where username='$username'";
else  $read_query = "select * from doctors where username='$username'";
$result = mysqli_query($conn, $read_query);

if ($result && mysqli_num_rows($result) > 0) {
$row = mysqli_fetch_assoc($result);
$storedHashedPassword = $row['password'];

}
if (isset($_POST['submitForm'])) {
    $password = $_POST['oldpassword'];
    $newpassword = $_POST['newpassword'];
    $hash = password_hash($newpassword, PASSWORD_DEFAULT);

        if (password_verify($password, $storedHashedPassword)) {
            if ($role == "Manager")
                $update_query = "update users set password='$hash' where username='$username'";
            else $update_query = "update doctors set password='$hash' where username='$username'";
            $result = mysqli_query($conn, $update_query);
            if ($result)
                header('location:logout.php');
        } else {
            $_SESSION['error'] = 'Invalid  password.';
        }
}

else if (isset($_POST['submitDelete'])) {
    $password = $_POST['password'];

        if (password_verify($password, $storedHashedPassword)) {
            if ($role == "Manager")
                $update_query = "delete from users where username='$username'";
            else $update_query = "delete from doctors where username='$username'";
            $result = mysqli_query($conn, $update_query);
            if ($result)
                header('location:logout.php');
        } else {
            $_SESSION['error'] = 'Invalid  password.';
        }
    
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/dashboards.css">
    <link rel="stylesheet" href="css/userdetails.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-e3VLEiVB1q8tVOKF5w0Tte6I4NX8Azv5uVjsnwoHcIlnU2U7JhGow58uXtolFNTF" crossorigin="anonymous"></script>

    <script>
        function closeErrorAlert() {
            document.getElementById('errorAlert').style.display = 'none';
        }
        window.onload = function() {
            var form = document.getElementById("changepassword");

            form.addEventListener("submit", function(event) {

                if (!validatePass()) {
                    event.preventDefault();
                }
            });

        }


        function validatePass() {
            var pass1 = document.getElementById("ps1").value;
            var pass2 = document.getElementById("ps2").value;
            if (pass1 != pass2) {
                console.log("pass doesn't match");
                document.getElementById("error").innerHTML = "<br> Password doesn't match";
                return false;
            } else {
                document.getElementById("error").innerHTML = " ";
                return true;
            }
        }
    </script>

</head>


<body>
    <?php
    if (isset($_SESSION['error'])) {
        echo '<div id="errorAlert" class="alert alert-danger alert-dismissible fade show" role="alert">' .
            $_SESSION['error'] . ' 
            <button type="button" class="btn-close" onclick="closeErrorAlert()" aria-label="Close"></button>
            </div>';
        unset($_SESSION["error"]);
    }
    ?>
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
                <div class="main-board">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6 mx-4 my-3" id="update_section">
                                <div class="card bg-glass">
                                    <div class="card-body px-4 py-3 px-md-5">
                                        <p style="color: blue; font-weight: 500;">Change password</p>
                                        <form id="changepassword" method="post">
                                            <div class="form-outline mb-2">
                                                <label class="form-label">Old Password</label><br>
                                                <input type="password" class="form-control" required name="oldpassword" />

                                            </div>
                                            <div class="form-outline mb-2">
                                                <label class="form-label">New Password</label><br>
                                                <input type="password" id="ps1" class="form-control" required name="newpassword" />

                                            </div>


                                            <div class="form-outline mb-2">
                                                <label class="form-label">Confirm password</label> <span id="error" style="color: red;"></span>
                                                <input type="password" id="ps2" class="form-control" required name="passwordval" />

                                            </div>

                                            <button type="submit" id="updateBtn" name="submitForm" class="btn btn-primary btn-block my-4">
                                                Update
                                            </button>

                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div id="carousel" class="col-lg-5 mx-1 my-3" data-bs-ride="true">
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img src="icons/icons8-settings-144.png" class="d-block w-100" alt="...">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 mx-4 my-3" id="deleteaccount">
                                <div class="card bg-glass">
                                    <div class="card-body px-4 py-3 px-md-5">
                                        <p style="color: red; font-weight: 500;">Delete Account</p>
                                        <form id="delete" method="post">
                                            <p>Please enter your password to confirm</p>

                                            <div class="form-outline mb-2">
                                                <label class="form-label">Password</label><br>
                                                <input type="password" class="form-control" required name="password" />

                                            </div>

                                            <button type="submit" id="deleteBtn" name="submitDelete" class="btn btn-danger btn-block my-4">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>
</body>

</html>