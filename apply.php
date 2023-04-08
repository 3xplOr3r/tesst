<!-- PHP SECTION -->

<!-- connecting with DB -->
<?php

  include "includes/conn.php";
  include "success.php";

    //SANITIZING USER INPUT FIELDS

    function sanitize ($input){

        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        $input = preg_replace("/[^a-zA-Z]/", "", $input);
        $input = preg_replace("/ +/", " ", $input);
        $input = str_replace(array('0','1','2','3','4','5','6','7','8','9'),'',$input);
        return $input;
        }

        function sanitize_int ($data) {
            $data = filter_var($data,FILTER_SANITIZE_NUMBER_INT);
            $data = preg_replace('/[^0-9\.]/', '', $data);
            return $data;
        }

    // Initializing code.

  if($_SERVER['REQUEST_METHOD'] == 'POST'){

    // <!-- PHP code to upload data and store on DB -->

      $file_name =  $_FILES['file']['name'];
      $tmp_name = $_FILES['file']['tmp_name']; 
      $file_up_name = time().$file_name; 
      move_uploaded_file($tmp_name, "includes/files/".$file_up_name);

    // ARRAY OF INPUT FIELDS.


    $name = sanitize($_POST['user_name']);

    $dob = sanitize_int($_POST['dob']);

    $email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);

    $num = sanitize_int($_POST['number']);

    $gender = sanitize($_POST['gender']);

    $jobrole = sanitize($_POST['ocupation']);

    $exam = sanitize($_POST['exam']);

    $gpa = $_POST['gpa'];

    $pass_year = sanitize_int($_POST['pass_year']);

    $dep = sanitize($_POST['department']);

    $img = $file_up_name;



    // SENDING DATA TO DATABASE 

    $sql = "INSERT INTO candidates (uname, dob, email, num, gender, jobrole, exam, gpa, pass_year, dep,pic) VALUES ('$name', '$dob', '$email', '$num', '$gender', '$jobrole', '$exam', '$gpa', '$pass_year', '$dep', '$img')";

    $data = mysqli_query($conn,$sql);

    // Checking if data has been recorded or not
    
    if($data) {
        $_SESSION['status'] ="Admission Done";
        $_SESSION['status_text'] = "your form has been submitted";
        $_SESSION['status_code'] = "success";
        header('Location: apply.php');
    } else {
        $_SESSION['status'] ="Submittion Failed";
        $_SESSION['status_text'] = "your form could not be submitted";
        $_SESSION['status_code'] = "error";
        header('Location: apply.php');
    }
  }
  mysqli_close($conn);

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!----======== CSS ======== -->
    <link rel="stylesheet" href="apply.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <script>
            if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
            }
    </script>
    <title></title> 
</head>
<body>
    <div class="container">
        <header>Admission Form</header>

        <form action="apply.php" method="post" enctype="multipart/form-data">
            <div class="form first">
                <div class="details personal">
                    <span class="title">Personal Details</span>

                    <div class="fields">
                        <div class="input-field">
                            <label>Full Name</label>
                            <input type="text" placeholder="Enter your name" name="user_name" required>
                        </div>

                        <div class="input-field">
                            <label>Date of Birth</label>
                            <input type="date" placeholder="Enter birth date" name="dob" required>
                        </div>

                        <div class="input-field">
                            <label>Email</label>
                            <input type="text" placeholder="Enter your email" name="email" required>
                        </div>

                        <div class="input-field">
                            <label>Mobile Number</label>
                            <input type="tel" placeholder="+880 XXXXXXXXXX" pattern="^\+?(88)?0?1[3-9][0-9]{8}$" name="number" required>
                        </div>

                        <div class="input-field">
                            <label>Gender</label>
                            <select name="gender" required>
                                <option disabled selected>Select gender</option>
                                <option>Male</option>
                                <option>Female</option>
                                <option>Others</option>
                            </select>
                        </div>

                        <div class="input-field">
                            <label>Ocupation</label>
                            <input type="text" placeholder="Enter your ocupation" name="ocupation" >
                        </div>
                    </div>
                </div>

                <div class="details ID">
                    <span class="title">Academic Details</span>

                    <div class="fields">
                        <div class="input-field">
                            <label>Result Type</label>
                            <select name="exam" required>
                                <option disabled selected>Result Type</option>
                                <option>SSC</option>
                                <option>HSC</option>
                                <option>DAKHIL</option>
                            </select>
                        </div>

                        <div class="input-field">
                            <label>GPA</label>
                            <input type="text" placeholder="Enter your gpa" name="gpa" required>
                        </div>

                        <div class="input-field">
                            <label>Passing Year</label>
                            <input type="text" placeholder="Your Passing Year" name="pass_year" required>
                        </div>

                        <div class="input-field">
                            <label>Chose Department</label>
                            <select name="department" required>
                                <option disabled selected>Chose Department</option>
                                <option>CSE</option>
                                <option>Civil</option>
                                <option>Textile</option>
                                <option>Electrical</option>
                                <option>Electronics</option>
                            </select>
                        </div>

                        <div class="input-field">
                            <label>Semester Type</label>
                            <select>
                                <option>Fall</option>
                            </select>
                        </div>

                    </div>


                    <button class="nextBtn" >
                        <span class="btnText">Next</span>
                        <i class="uil uil-navigator"></i>
                    </button>
                </div> 
            </div>

            <div class="form second">
                <div class="details address">
                    <span class="title">Upload Docs</span>

                    <div class="file-upload">
                        <div class="file-area">
                            <input type="file" class="file-input" name="file" hidden>
                            <i class="fas fa-cloud-upload-alt"></i>
                            <p>Browse files to upload</p>
                        </div>
                        <section class="progress-area"></section>
                        <section class="uploaded-area"></section>
                    </div>



                    <div class="buttons">
                        <div class="backBtn">
                            <i class="uil uil-navigator"></i>
                            <span class="btnText">Back</span>
                        </div>
                        
                        <button class="sumbit" type="submit">
                            <span class="btnText">Submit</span>
                            <i class="uil uil-navigator"></i>
                        </button>
                    </div>
                </div> 
            </div>
        </form>
    </div>

    <script type="text/javascript" src="apply.js"></script>
    <script type="text/javascript" src="upload.js"></script>
</body>
</html>

