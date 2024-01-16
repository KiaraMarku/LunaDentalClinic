<?php
include '../connect.php';
session_start();
$username = $_SESSION['user'];

$read_query = "select * from doctors where username='$username'";
$result = mysqli_query($conn, $read_query);

if ($result && mysqli_num_rows($result)>0) {
   $row = mysqli_fetch_assoc($result) ;
        $doctor = $row['id'];
      }


if (isset($_POST['submitForm'])) {
  if($_SESSION['user_role']=="Manager")
  $doctor=$_POST['doctor'];

  $patient= $_POST['patient'];
  $schedule = $_POST['schedule'];
  
    $read_query = "select * from appointments where schedule='$schedule'";

    $busy=0;
    $docError=0;
    $patientError=0;
    $result = mysqli_query($conn, $read_query);
    if ($result && mysqli_num_rows($result)>0) {
      $busy=true;
    }

    else{  
      $doctor=confirmDoc($doctor,$conn);
      $patient=confirmPatient($patient,$conn);
    if($doctor==null){
      $docError = true;
    }
    
    else if($patient==null){
      $patientError = true;
    }
    
    else {
      $insert_query = "insert into appointments (doctor_id,patient_id,schedule) values ('$doctor','$patient','$schedule')";

      $result = mysqli_query($conn, $insert_query);
      if ($result) {
          header("location:manageappointments.php");
      }
      else die("error adding doctor");
      }
    }
    
  }

  function confirmdoc($id,$conn){
    $sql = "select id from doctors where id='$id'";
    $result = mysqli_query($conn, $sql);
    if ($result) 
       ($row = mysqli_fetch_assoc($result));
       if ($row) 
        return $row['id'];
      else 
        return null;
      }

      function confirmPatient($id,$conn){
        $sql = "select id from patients where id='$id'";
        $result = mysqli_query($conn, $sql);
        if ($result) 
           ($row = mysqli_fetch_assoc($result));
           if ($row) 
            return $row['id'];
           else 
            return null;
          }


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="../projectdemo/css/dashboards.css">
  <link rel="stylesheet" href="../projectdemo/css/userdetails.css">

  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
  <title>Document</title>
  <script>
    function update() {
      var component1 = document.getElementById("update_section");
      var component2 = document.getElementById("carousel");

      component1.style.display = "block";
      component2.style.display = "none";

    }
   
   var isBusy = <?php echo $busy;?>;
   console.log(isBusy);
   var docError = <?php echo $docError; ?>;
   console.log(docError);

   
   var patientError = <?php echo $patientError; ?>;
      $(document).ready(function() {
        if (isBusy=='1') {
          $('#busyModal').modal('show');
        }
      });

      $(document).ready(function() {
        if (docError=='1') {
          $('#docModal').modal('show');
        }
      });
      $(document).ready(function() {
        if (patientError=='1') {
          $('#patientModal').modal('show');
        }
      });


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
                   <h2>Add appointment</h2>
                <form id="registrationForm" method="post">
                  <div class="form-outline mb-2">
                    <label class="form-label">Patient Name
                    </label><br>
                    <select class="form-select" name="patient">'
                    <?php 
          
                    $read_query = "select * from patients";
                    $result = mysqli_query($conn, $read_query);
                  
                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $id = $row['id'];
                            $name = $row['name'];

                echo '
                 <option value="'.$id.'">' . $name . '</option>
               ';
                        }
                      }
                  
                  ?>   
                </select> 
                  </div>
                  <div class="form-outline mb-2">
                 
                    <?php 
                  if($_SESSION['user_role']=="Manager") {
                    echo' <label class="form-label">Doctor Name</label> <br>
                   <select class="form-select" name="doctor">';
                    $read_query = "select * from doctors";
                    $result = mysqli_query($conn, $read_query);
                  
                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $id = $row['id'];
                            $name = $row['name'];

                echo '
                 <option value="'.$id.'">' . $name . '</option>
               ';
                        }
                      }
                      echo '</select>';
                  } 
                  ?>   
                
                  </div>
                 
                  <div class="form-outline mb-2">
                    <label class="form-label">Schedule</label>
                    <input type="datetime-local" class="form-control" required name="schedule" />
                  </div>

                  <button type="submit" id="submitBtn" name="submitForm" class="btn btn-primary btn-block my-4">
                    Register
                  </button>
                  <button class="btn btn-secondary"><a href="manageappointments.php" class="text-light" style="text-decoration: none;">Cancel</a></button>
                  <h4 id="error"></h4> 
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

  <div class="modal" tabindex="-1" role="dialog" id="busyModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Busy schedule</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>There is a nother oppointment in this time.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="docModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"> Doctor is not registered</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Please register doctor .</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="patientModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Patient id not valid</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Please enter a valid patient.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
</body>
</html>