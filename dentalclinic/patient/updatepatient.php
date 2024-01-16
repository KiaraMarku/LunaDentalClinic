<?php
include '../connect.php';
session_start();
$username = $_SESSION['user'];
if (isset($_GET['update_id'])) {
  $id = $_GET['update_id'];

  $read_query = "select * from patients where id='$id'";
  $result = mysqli_query($conn, $read_query);
  if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $name = $row['name'];
    $birthday = $row['birthday'];
    $phone = $row['phone'];
    $address=$row['address'];
    $profession = $row['profession'];
  }


  if (isset($_POST['submitForm'])) {

    $name = $_POST['name'];
    $birthday = $_POST['birthday'];
    $phone = $_POST['phone'];
    $address= $_POST['address'];
    $profession = $_POST['profession'];
    $update_query = "UPDATE patients SET name = '$name', birthday = '$birthday', phone = '$phone', address ='$address',profession='$profession' WHERE id = '$id'";
    $update_result = mysqli_query($conn, $update_query);
    if ($update_result) {
      header("location:managepatients.php");
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
          <div id="accountDetails" class="my">
            <p><img src="icons/health-report.png" alt=""></p>
            <h2 id="name">Name: <?php echo $name; ?> </h2>
            <p id="birthday">Birthday: <?php echo  '<br>' . $birthday; ?></p>
            <p id="phone">Phone: <?php echo  '<br>' . $phone; ?></p>
            <p id="phone">Address: <?php echo  '<br>' . $address; ?></p>
            <p id="phone">Profession: <?php echo  '<br>' . $profession; ?></p>
           
            <button id="editButton" onclick="update()"  class="btn btn-primary btn-block my-4">Edit Details</button>
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
                    <label class="form-label">Bithday</label>
                    <input type="birthday" class="form-control" required name="birthday" value="<?php echo $birthday; ?>" />

                  </div>

                  <div class="form-outline mb-2">
                    <label class="form-label">Phone</label> <br>
                    <input type="tel" class="form-control" required name="phone" value="<?php echo $phone; ?>" />
                  </div>
                  
                  <div class="form-outline mb-2">
                    <label class="form-label">Address</label> <br>
                    <input type="tel" class="form-control" required name="address" value="<?php echo $address; ?>" />
                  </div>
                  
                  <div class="form-outline mb-2">
                    <label class="form-label">Profession</label> <br>
                    <input type="tel" class="form-control" required name="profession" value="<?php echo $profession; ?>" />
                  </div>
                  <button type="submit" id="submitBtn" name="submitForm" class="btn btn-primary btn-block my-4">
                    Update
                  </button>
                  <button class="btn btn-secondary"><a href="managepatients.php" class="text-light" style="text-decoration: none;">Cancel</a></button> 
               </form>
              </div>
            </div>
          </div>

        <div id="carousel" class="carousel slide mx-4 my-5" data-bs-ride="true">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="../icons/dentalphoto2.webp" class="d-block w-100" alt="...">
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</body>

</html>