<?php
include 'connect.php';
session_start();
$username = $_SESSION['user'];
$role = $_SESSION['user_role'];
if ($role == "Manager") {
  $read_query = "select * from users where username='$username'";
  $result = mysqli_query($conn, $read_query);
  if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $name = $row['name'];
    $email = $row['email'];
    $phone = $row['phone'];
  }


  if (isset($_POST['submitForm'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $update_query = "UPDATE users SET name = '$name', email = '$email', phone = '$phone' WHERE username = '$username'";
    $update_result = mysqli_query($conn, $update_query);
    if ($update_result) {
      header("location:user.php");
    }
  }
}

else if ($role == "Doctor") {

  $read_query = "select * from doctors where username='$username'";
  $result = mysqli_query($conn, $read_query);
  if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $name = $row['name'];
    $email = $row['email'];
    $phone = $row['phone'];
    $specialty = $row['specialty'];
  }


  if (isset($_POST['submitForm'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $specialty = $_POST['specialty'];
    $update_query = "UPDATE doctors SET name = '$name', email = '$email', phone = '$phone' WHERE username = '$username'";
    $update_result = mysqli_query($conn, $update_query);
    if ($update_result) {
      header("location:user.php");
    }
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="css/dashboards.css">
  <link rel="stylesheet" href="css/userdetails.css">
  
  <title>Document</title>
  

  <style>

    #specialization {
      display: none;
    }
    <?php
  if ($role == "Doctor")
    echo '
    #specialization{
      display: block;
    }'
  ?>
  </style>

 
  <script>
    function update(c1,c2) {
      var component1 = document.getElementById(c1);
      var component2 = document.getElementById(c2);

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
          <div id="accountDetails" class="my">
          <?php if ($role == "Manager")
              echo  ' <p><img src="icons/icons8-user-94.png" alt=""></p> ';
              else echo ' <p><img src="icons/icons8-dentist-64.png" alt=""></p>';
            ?>
            <h2 id="name">Name: <?php echo $name; ?> </h2>
            <p id="username">Username: <?php echo   '<br>' . $username; ?></p>
            <p id="email">Email: <?php echo  '<br>' . $email; ?></p>
            <p id="phone">Phone: <?php echo  '<br>' . $phone; ?></p>
            <?php if ($role == "Doctor")
              echo  ' <p id="phone">Specialty:' . $specialty . '</p><br>';
            ?>
            <button id="editButton" class="btn btn-primary btn-block my-4" onclick="update('update_section','carousel')">Edit Details</button>
          </div>

          <div class="col-lg-6 mb-5 mb-lg-0 position-relative my-4" id="update_section" style="display: none;">
            <div class="card bg-glass">
              <div class="card-body px-4 py-3 px-md-5">

                <form id="registrationForm" method="post">
                  <div class="form-outline mb-2">
                    <label class="form-label">Name</label><br>
                    <input type="text" class="form-control" required name="name" value="<?php echo $name; ?>" />
                  </div>

                  <div class="form-outline mb-2">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" required name="email" value="<?php echo $email; ?>" />

                  </div>

                  <div class="form-outline mb-2">
                    <label class="form-label">Phone</label> <br>
                    <input type="tel" class="form-control" required name="phone" value="<?php echo $phone; ?>" />
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
                    Update
                  </button>
                  <button class="btn btn-secondary"  onclick="update('carousel','update_section')">Cancel</button> 
               </form>
              </div>
            </div>
          </div>

        <div id="carousel" class="carousel slide mx-4 my-5" data-bs-ride="true">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="icons/dentalphoto1.webp" class="d-block w-100" alt="...">
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</body>

</html>