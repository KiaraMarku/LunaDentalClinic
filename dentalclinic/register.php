<!DOCTYPE html>
<html lang="en">
<?php
include ("navbar.html");
include "connect.php";

if (isset($_POST['submitForm'])) {
    $role=$_POST['role'];
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $specialty=$_POST['specialty'];
    if ($role=="Manager") {

      $read_query = "select * from users where username='$username'";
      $result = mysqli_query($conn, $read_query);
      if ($result && mysqli_num_rows($result)>0) {
        echo '<div id="errorAlert" class="alert alert-danger alert-dismissible fade show" role="alert">' .
        '<strong>Username already exists!</strong> 
        <button type="button" class="btn-close" onclick="closeErrorAlert()" aria-label="Close"></button>
        </div>';
      }
      else{
        $insert_query = "insert into users (name,username,email,phone,password) values ('$name','$username','$email','$phone','$hash')";

        $result = mysqli_query($conn, $insert_query);
        if ($result) {
            header("location:login.php");
        }
        else die("error adding user");
      }
        
    } 
    else if ($role=="Doctor"){
       
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
          header("location:login.php");
      }
      else die("error adding doctor");
      }
    }
    else {
      echo "erorr";
      die("Role doesn't match");
    }
    
}

?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/login_reg.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        function closeErrorAlert() {
            document.getElementById('errorAlert').style.display = 'none';
        }
        
    window.onload = function() {
      var roleSelect = document.getElementById("role");
      var specializationSelect = document.getElementById("specialization");
      roleSelect.onchange = function() {
        if (roleSelect.value == "Doctor") {
          specializationSelect.style.display = "block";
        } else {
          specializationSelect.style.display = "none";
        }
      }

    var form = document.getElementById("registrationForm");

    form.addEventListener("submit", function(event) {
    
      if(!validatePass()) {
        event.preventDefault();
  }
    });
   }
   
    function validatePass(){
    var pass1 = document.getElementById("ps1").value;
    var pass2 = document.getElementById("ps2").value;
    if(pass1 != pass2){
      console.log("pass doesn't match");
      document.getElementById("error").innerHTML = "<br> Password doesn't match";
      return false;
    }
    else {
      document.getElementById("error").innerHTML = " ";
      return true;
    }
}

    </script>
</head>

<body>
<section class="background-radial-gradient overflow-hidden">
  

  <div class="container px-4 py-5 px-md-5 text-center text-lg-start my-5">
    <div class="row gx-lg-5 align-items-center mb-5">
      <div class="col-lg-6 mb-5 mb-lg-0" style="z-index: 10">
        
        <p class="mb-4 opacity-70 " >
         <img src="icons/luna-logo.png" alt="logo" class="img-fluid ">
        </p>
         <h1 class="my-5 display-5 fw-bold text-end" style="color: hsl(218, 81%, 95%)">
          The best choice <br />
          <span style="color: rgba(37,168,218,255)">for your smile</span>
        </h1>
      </div>

      <div class="col-lg-6 mb-5 mb-lg-0 position-relative" >
        <div class="card bg-glass">
          <div class="card-body px-4 py-3 px-md-5">
            <h2 class="mb-3 opacity-70" style="color:rgba(37,168,218,255)"> Register</h2>
            
            <form id="registrationForm" method="post">
              <div class="form-outline mb-2">
                <label class="form-label">Role</label> <br>
                <select id="role" class="form-select" required name="role">
                  <option value="Manager">Manager</option>
                  <option value="Doctor">Doctor</option>
                </select>
              </div>
                  <div class="form-outline mb-2">
                    <label class="form-label">Name</label><br>
                    <input type="text"  class="form-control" required name="name"/> 
                  </div>
        
              <div class="form-outline mb-2">
                <label class="form-label">Username</label> <br>
                <input type="text"  class="form-control" required name="username"/>
                
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
                <label class="form-label">Email</label>
                <input type="email"  class="form-control" required name="email" />
                
              </div>

              <div class="form-outline mb-2">
                <label class="form-label">Phone</label> <br>
                <input type="tel"  class="form-control" required name="phone"/>  
              </div>

              <div id="specialization" class="form-outline mb-4" style="display: none;">
                <label class="form-label">Specialization</label> <br>
                  <select class="form-select" name="specialty">
                  <option value="general dentist">General dentist</option>
                  <option value="orthodontist">Orthodontist</option>
                  <option value="dental surgeon">Dental Surgeon</option>
                  <!-- Add more options as needed -->
                </select>
              </div>
              <button type="submit" id="submitBtn" name="submitForm" class="btn btn-primary btn-block mb-4">
                Register
              </button>
            </form> 
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
  
</body>
</html>
