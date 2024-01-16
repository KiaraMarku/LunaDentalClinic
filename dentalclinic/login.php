<!DOCTYPE html>

<html lang="en">
<?php
include ("navbar.html");
include 'connect.php';
session_start();
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/login_reg.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-e3VLEiVB1q8tVOKF5w0Tte6I4NX8Azv5uVjsnwoHcIlnU2U7JhGow58uXtolFNTF" crossorigin="anonymous"></script>
    <script>
        function closeErrorAlert() {
            document.getElementById('errorAlert').style.display = 'none';
        }
    </script>
  </head>
 
 <?php
    if (isset($_POST['submit'])) {
      $role=$_POST['role'];
      $_SESSION['user_role'] = $role;
      $username = $_POST['username'];  
      $_SESSION['user'] = $username;
      $password = $_POST['password'];
     if ($role=="Manager") {
      
      $read_query = "select * from users where username='$username'";
      $result = mysqli_query($conn, $read_query);
      if ($result && mysqli_num_rows($result)>0) {
        $row = mysqli_fetch_assoc($result);
        $storedHashedPassword = $row['password'];

        // Verify the entered password against the stored hashed password
        if (password_verify($password, $storedHashedPassword)) {
            header('location:user.php');
            exit();
        } else {
            $_SESSION['error']= 'Invalid  password.';
        }
        } 
         else   $_SESSION['error'] = 'Invalid username. ';
       }  
       
      else if ($role=="Doctor"){
      $read_query = "select * from doctors where username='$username'";
      $result = mysqli_query($conn, $read_query);
      if ($result && mysqli_num_rows($result)>0) {
        $row = mysqli_fetch_assoc($result);
        $storedHashedPassword = $row['password'];

        // Verify the entered password against the stored hashed password
        if (password_verify($password, $storedHashedPassword)) {
         
            header('location:user.php');
            exit();
        } else {
            $_SESSION['error'] = 'Invalid password.';
        }
        } 
        else   $_SESSION['error'] = 'Invalid username.';
      
      }
      } 
  ?>
<body>
<section class="background-radial-gradient overflow-hidden">
<?php    
      if (isset($_SESSION['error'])) {
        echo '<div id="errorAlert" class="alert alert-danger alert-dismissible fade show" role="alert">' .
            $_SESSION['error'] .
            '<strong>Login unsuccessful!</strong> 
            <button type="button" class="btn-close" onclick="closeErrorAlert()" aria-label="Close"></button>
            </div>';
        unset($_SESSION["error"]);
        }
        ?>


  <div class="container px-4 py-5 px-md-5 text-center text-lg-start my-5">
    <div class="row gx-lg-5 align-items-center mb-5">
      <div class="col-lg-6 mb-5 mb-lg-0" style="z-index: 10">
        
        <p class="mb-4 opacity-70 " >
         <img src="icons/luna-logo.png"  alt="logo" class="img-fluid ">
        </p>
         <h2 class="my-5 display-5 fw-bold text-end" style="color: hsl(218, 81%, 95%)">
          The best choice <br />
          <span style="color: rgba(37,168,218,255)">for your smile</span>
        </h2>
      </div>

      <div class="col-lg-6 mb-5 mb-lg-0 position-relative" >
      <div class="card bg-glass">
          <div class="card-body px-4 py-5 px-md-5">
            <h2 class="mb-4 opacity-70" style="color:rgba(37,168,218,255)"> Login</h2>
            
            <form  method="post">
              <div class="form-outline mb-4">
                <select name="role" class="form-select" aria-label="Role select">
                  <option selected value="Manager">Manager</option>
                  <option value="Doctor">Doctor</option>
                </select>
              </div>
              <div class="form-outline mb-4">
                   <label class="form-label" >Username</label> <br>
                   <input type="text" name="username" class="form-control" />
              </div>

              <div class="form-outline mb-4">
                <label class="form-label">Password</label> <br>
                <input type="password"   name="password"class="form-control" />
                
              </div>
              <button type="submit" name ="submit" class="btn btn-primary btn-block mb-4">
                Log in
              </button>
             
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
  
</body>
</html>
