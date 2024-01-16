<?php
include '../connect.php';
session_start();
$username = $_SESSION['user'];
$role = $_SESSION['user_role'];

if($role=='Manager')
die("You dont have acces in this page");

if (isset($_GET['update_id'])) {
    $id = $_GET['update_id'];

    $read_query = "select * from patients where id='$id'";
    $result = mysqli_query($conn, $read_query);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $name = $row['name'];
        $birthday = $row['birthday'];
        $phone = $row['phone'];
        $address = $row['address'];
        $profession = $row['profession'];
        $diagnosis = $row['diagnosis'];
        $treatment = $row['treatment'];
        $medicalHistoryJson = $row['medical_history'];
        $medicalHistory = json_decode($medicalHistoryJson, true);
        $illnesses = $medicalHistory['illnesses'] ?? [];
        $medications = $medicalHistory['medications']?? "";
        $allergies = $medicalHistory['allergies']?? "";
        $diagnosis = $row['diagnosis'];
        $treatment = $row['treatment'];
    }

    if (isset($_POST['submitForm'])) {

        $name = $_POST['name'];
        $birthday = $_POST['birthday'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $profession = $_POST['profession'];
        $update_query = "UPDATE patients SET name = '$name', birthday = '$birthday', phone = '$phone', address ='$address',profession='$profession' WHERE id = '$id'";
        $update_result = mysqli_query($conn, $update_query);
        if ($update_result) {
            header("location:#");
        }
    }

    if (isset($_POST['submitMedicalForm'])) {
        $illnesses = isset($_POST['illnesses']) ? $_POST['illnesses'] : [];
        $diagnosis = $_POST['diagnosis'];
        $treatment = $_POST['treatment'];
        $medicalHistory = [
            'illnesses' => $illnesses,
            'medications' => $_POST['medications'],  // Replace with actual array of medications
            'allergies' => $_POST['allergies'],    // Replace with actual array of allergies
        ];
        $medicalHistoryJson = json_encode($medicalHistory);
        $update_query = "update patients set diagnosis='$diagnosis',treatment='$treatment',medical_history='$medicalHistoryJson' where id='$id' ";
      

        $update_result = mysqli_query($conn, $update_query);
        if ($update_result) {
            header("location:#");
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
    <style>
        h2 {
            color:red;
            font-weight: 600;
        }
        h5 {
            color:green;
            font-weight: 600;
        }
        ol li {
            color: red;
            margin: 0;
            padding: 5px;
            list-style: decimal;
        }

        #medicalInfo ul li {
            color: black;
            list-style: circle;
        }

        #accountDetails,
        #medicalInfo {
            box-shadow: 10px 10px 10px 5px lightblue;
            flex: 1 ;
            height: auto;
            margin: 5px;

        }

        summary{
            color: lightskyblue;
            list-style: inside;
        }
       
    </style>
    <script>
        function update(c1, c2) {
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
                    <div class="col-lg-6 mb-5 mb-lg-0 position-relative my-4" id="update_section" style="display: none; ">
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
                                    <button class="btn btn-secondary"  onclick="update('carousel','update_section')">Cancel</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div id="accountDetails" class="my" style="flex-grow: 1;">
                        <p><img src="../icons/health-report.png" alt=""></p>
                        <h2 id="name">Name: <?php echo $name; ?> </h2>
                        <p id="birthday">Birthday: <?php echo  '<br>' . $birthday; ?></p>
                        <p id="phone">Phone: <?php echo  '<br>' . $phone; ?></p>
                        <p id="phone">Address: <?php echo  '<br>' . $address; ?></p>
                        <p id="phone">Profession: <?php echo  '<br>' . $profession; ?></p>
                        <button id="editButton" onclick="update('update_section','accountDetails')" class="btn btn-primary btn-block my-4">Edit Details</button>
                    </div>
                
                    <div id="medicalInfo" class="my" style="flex-grow: 2;">
                        <h2>Medical Info </h2>
                        <ol>
                            <li>Illnesses:</li>
                            <ul>
                                <?php foreach ($illnesses as $illness) { ?>
                                    <li><?php echo $illness; ?></li>
                                <?php } ?>
                            </ul>
                            <li>Medications: <?php echo $medications; ?></li>
                            <li>Allergies: <?php echo $allergies; ?></li>
                        </ol>
                        <h5 id="birthday">Diagnosis:</h5> <?php echo $diagnosis. '<br>'; ?>
                        <h5 id="phone">Treatment:</h5> <?php echo $treatment .'<br>'; ?>

                        <button id="editButton" class="btn btn-primary btn-block my-4" onclick="update('medical_update','medicalInfo')">Edit Data</button>
                    </div>

                    <div class="col-lg-6 mb-5 mb-lg-0 position-relative my-4" id="medical_update" style="display: none; ">
                        <div class="card bg-glass">
                            <div class="card-body px-4 py-3 px-md-5">
                                <form id="registrationForm" method="post">
                                    <h2>Treatment plan</h2>
                                    <div class="form-outline mb-2">
                                        <label class="form-label">Diagnosis:</label><br>
                                        <textarea class="form-control" name="diagnosis" rows="3"><?php echo $diagnosis; ?></textarea>
                                    </div>
                                    <div class="form-outline mb-2">
                                        <label class="form-label">Treatment:</label><br>
                                        <textarea class="form-control" name="treatment" rows="5"><?php echo $treatment; ?></textarea>
                                    </div>
                                    <details>
                                        <summary >Medical History</summary>
                                    <div class="form-outline mb-2">
                                        <label class="form-label">Illnesses (select as many as apply):</label><br>
                                        <label for="illness_1">Blood Disease</label>
                                        <input type="checkbox" id="illness_1" name="illnesses[]" value="Blood Disease" <?php if(in_array("Blood Disease",$illnesses)) echo 'checked'?> ><br>
                                        <label for="illness_2">Heart Disease</label>
                                        <input type="checkbox" id="illness_2" name="illnesses[]" value="Heart Disease"  <?php if(in_array("Heart Disease",$illnesses)) echo 'checked'?>><br>

                                        <label for="illness_3">Blood Pressure</label>
                                        <input type="checkbox" id="illness_3" name="illnesses[]" value="Blood Pressure"  <?php if(in_array("Blood Pressure",$illnesses)) echo 'checked'?>><br>

                                        <label for="illness_4">Kidney Disease</label>
                                        <input type="checkbox" id="illness_4" name="illnesses[]" value="Kidney Disease" <?php if(in_array("Kidney Disease",$illnesses)) echo 'checked'?>><br>

                                        <label for="illness_5">Gastrointestinal Disease</label>
                                        <input type="checkbox" id="illness_5" name="illnesses[]" value="Gastrointestinal Disease"  <?php if(in_array("Gatrointestinal Disease",$illnesses)) echo 'checked'?>><br>

                                        <label for="illness_6">Diabetes</label>
                                        <input type="checkbox" id="illness_6" name="illnesses[]" value="Diabetes" <?php if(in_array("Diabetes",$illnesses)) echo 'checked'?>><br>

                                        <label for="illness_7">Infectious Diseases</label>
                                        <input type="checkbox" id="illness_7" name="illnesses[]" value="Infectious Diseases" <?php if(in_array("Infectious Diseases",$illnesses)) echo 'checked'?>><br>
                                    </div>
                                    <div class="form-outline mb-2">
                                        <label class="form-label">Medications:</label><br>
                                        <textarea class="form-control" name="medications" rows="3" ><?php echo $medications; ?></textarea>
                                    </div>
                                    <div class="form-outline mb-2">
                                        <label class="form-label">Allergies:</label><br>
                                        <textarea class="form-control" name="allergies" rows="3"><?php echo $allergies; ?></textarea>
                                    </div>
                                    </details>
                                    <button type="submit" id="submitBtn" name="submitMedicalForm" class="btn btn-primary btn-block my-4">
                                        Update
                                    </button>
                                    <button class="btn btn-secondary"  onclick="update('carousel','update_section')">Cancel</button>
                                </form>  
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>
</body>

</html>