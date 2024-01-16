<?php
include '../connect.php';
session_start();

$role = $_SESSION['user_role'];
if($role!='Manager')
die("You dont have acces in this page");

$username = $_SESSION['user'];
if (isset($_POST['submitForm'])) {
  $role=$_POST['role'];
  $name = $_POST['name'];
  $username = $_POST['username'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $password = $_POST['password'];
  $hash = password_hash($password, PASSWORD_DEFAULT);
  $specialty=$_POST['specialty'];
     
    $read_query = "select * from doctors where username='$username'";
    $result = mysqli_query($conn, $read_query);
    if ($result && mysqli_num_rows($result)>0) {
      echo '<div id="errorAlert" class="alert alert-danger alert-dismissible fade show" role="alert">' .
      '<strong>Username already exists!</strong> 
      <button type="button" class="btn-close" onclick="closeErrorAlert()" aria-label="Close"></button>
      </div>';
    }
    else{
    $insert_query = "insert into doctors (name,username,email,phone,password,specialty) values ('$name','$username','$email','$phone','$hash','$specialty')";

    $result = mysqli_query($conn, $insert_query);
    if ($result) {
        header("location:managedoctors.php");
    }
    else die("error adding doctor");
    }
  }


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/dashboards.css">
  <link rel="stylesheet" href="../css/userdetails.css">
  <title>Document</title>
  <script>
    function update() {
      var component1 = document.getElementById("update_section");
      var component2 = document.getElementById("carousel");

      component1.style.display = "block";
      component2.style.display = "none";

    }
  </script>
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
        <div class="main-board">
          <div class="col-lg-6 mb-5 mb-lg-0 position-relative my-4" id="update_section" >
            <div class="card bg-glass">
              <div class="card-body px-4 py-3 px-md-5">
                   <h2>Doctor details</h2>
                <form id="registrationForm" method="post">
                  <div class="form-outline mb-2">
                    <label class="form-label">Name</label><br>
                    <input type="text" class="form-control" required name="name"  />
                  </div>

                  <div class="form-outline mb-2">
                    <label class="form-label">Username</label> <br>
                    <input type="text" class="form-control" required name="username"  />

                  </div>

                  <div class="form-outline mb-2">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" required name="email"  />
                  </div>

                  
                  <div class="form-outline mb-2">
                    <label class="form-label">Password</label><br>
                    <input type="password" id="ps1" class="form-control" required  name="password"/>
                    
                  </div>
                     
                  <div class="form-outline mb-2">
                    <label class="form-label">Confirm password</label> <span id="error"></span>
                    <input type="password" id="ps2" class="form-control" required  name="passwordval"/>
                    
                  </div>

            

                  <div class="form-outline mb-2">
                    <label class="form-label">Phone</label> <br>
                    <input type="tel" class="form-control" required name="phone"  />
                  </div>
                  <div id="specialization" class="form-outline mb-4" >
                    <label class="form-label">Specialization</label> <br>
                    <select class="form-select" name="specialty">
                      <option value="general dentist">General dentist</option>
                      <option value="orthodontist">Orthodontist</option>
                      <option value="dental surgeon">Dental Surgeon</option>
                      <!-- Add more options as needed -->
                    </select>
                  </div>
                  <button type="submit" id="submitBtn" name="submitForm" class="btn btn-primary btn-block my-4">
                    Register
                  </button>
                  <button class="btn btn-secondary"><a href="managedoctors.php" class="text-light" style="text-decoration: none;">Cancel</a></button> 
               </form>
              </div>
            </div>
          </div>
          <div id="carousel" class="carousel slide mx-4 my-5" data-bs-ride="true">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="../icons/dentalphoto3.jpg" class="d-block w-100" alt="...">
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</body>

</html>