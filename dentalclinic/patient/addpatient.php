<?php
include '../connect.php';
session_start();
$username = $_SESSION['user'];
if (isset($_POST['submitForm'])) {
  $name = $_POST['name'];
  $address = $_POST['address'];
  $birthday=$_POST['birthday'];
  $phone = $_POST['phone'];
  $profession = $_POST['profession'];

      // Collect selected illnesses
      $illnesses = isset($_POST['illnesses']) ? $_POST['illnesses'] : [];

      // Build an array for medical history
      $medicalHistory = [
          'illnesses' => $illnesses,
          'medications' => $_POST['medications'],  // Replace with actual array of medications
          'allergies' => $_POST['allergies'],    // Replace with actual array of allergies
      ];

      $insert_query = "insert into patients (name,phone,birthday,address,profession,medical_history) values ('$name','$phone','$birthday','$address','$profession',?)";
      $stmt = mysqli_prepare($conn, $insert_query);

      // Bind JSON-encoded medical history object as parameter
      $medicalHistoryJson = json_encode($medicalHistory);
      mysqli_stmt_bind_param($stmt, "s", $medicalHistoryJson);
  
      // Execute the prepared statement
 
  $result = mysqli_stmt_execute($stmt);
  
  if ($result) {
    header("location:managepatients.php");
  } else die("error adding doctor");
  
  mysqli_close($conn);
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
  <title>Document</title>
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
          <div class="col-lg-6 mb-5 mb-lg-0 position-relative my-4" id="update_section">
            <div class="card bg-glass">
              <div class="card-body px-4 py-3 px-md-5">
                <h2>Patient details</h2>
                <div><img src="../icons/patient.png" alt=""></div>
                <form id="registrationForm" method="post">
                  <div class="form-outline mb-2">
                    <label class="form-label">Name</label><br>
                    <input type="text" class="form-control" required name="name" />
                  </div>

                  <div class="form-outline mb-2">
                    <label class="form-label">Birthday</label><br>
                    <input type="date" id="ps1" class="form-control" required name="birthday" />
                  </div>

                  <div class="form-outline mb-2">
                    <label class="form-label">Phone</label> <br>
                    <input type="tel" class="form-control" required name="phone" />
                  </div>

                  <div class="form-outline mb-2">
                    <label class="form-label">Address</label> <span id="error"></span>
                    <input type="text" id="ps2" class="form-control" required name="address" />
                  </div>
                  <div class="form-outline mb-2">
                    <label class="form-label">Profession</label> <span id="error"></span>
                    <input type="text" id="ps2" class="form-control" required name="profession" />
                  </div>
                
              </div>
            </div>
          </div>
          <div class="col-lg-6 mb-5 mb-lg-0 position-relative my-4">
            <div class="card bg-glass">
              <div class="card-body px-4 py-3 px-md-5">
                <h2>Medical History</h2>

                <div class="form-outline mb-2">
                  <label class="form-label">Illnesses (select as many as apply):</label><br>
                  <label for="illness_1">Blood Disease</label>
                  <input type="checkbox" id="illness_1" name="illnesses[]" value="Blood Disease"><br>
                  <label for="illness_2">Heart Disease</label>
                  <input type="checkbox" id="illness_2" name="illnesses[]" value="Heart Disease"><br>

                  <label for="illness_3">Blood Pressure</label>
                  <input type="checkbox" id="illness_3" name="illnesses[]" value="Blood Pressure"><br>

                  <label for="illness_4">Kidney Disease</label>
                  <input type="checkbox" id="illness_4" name="illnesses[]" value="Kidney Disease"><br>

                  <label for="illness_5">Gastrointestinal Disease</label>
                  <input type="checkbox" id="illness_5" name="illnesses[]" value="Gastrointestinal Disease"><br>

                  <label for="illness_6">Diabetes</label>
                  <input type="checkbox" id="illness_6" name="illnesses[]" value="Diabetes"><br>

                  <label for="illness_7">Infectious Diseases</label>
                  <input type="checkbox" id="illness_7" name="illnesses[]" value="Infectious Diseases"><br>
                </div>
                <div class="form-outline mb-2">
                  <label class="form-label">Medications:</label><br>
                  <textarea class="form-control" name="medications" rows="3"></textarea>
                </div>
                <div class="form-outline mb-2">
                  <label class="form-label">Allergies:</label><br>
                  <textarea class="form-control" name="allergies" rows="3"></textarea> 
                </div>
                
                <button type="submit" id="submitBtn" name="submitForm" class="btn btn-primary btn-block my-4">
                    Register
                  </button>
                  <button class="btn btn-secondary"><a href="managepatients.php" class="text-light" style="text-decoration: none;">Cancel</a></button> 
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