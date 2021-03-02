<?php
session_start();
require_once "db_con.php";
$message = "";

if(!isset($_SESSION["UserId"]))
{
    echo"<script>window.open('index.php?mes=Access Denied...','_self');</script>";
    
}	


if(isset($_POST["ADDC"]))
{

                $code = mysqli_real_escape_string($db_con, $_REQUEST['ccode']);
                $name = mysqli_real_escape_string($db_con, $_REQUEST['cname']);
                $desc = mysqli_real_escape_string($db_con, $_REQUEST['cdescription']);
                $instruct = mysqli_real_escape_string($db_con, $_REQUEST['cinstructor']);

                $check = "SELECT COUNT(course_id) FROM course WHERE course_id = '$code'";
                $r=mysqli_query($db_con,$check);
                $row=mysqli_fetch_row($r);

                $check2 = "SELECT user_id FROM users WHERE user_id = '$instruct'";
                $r2 = mysqli_query($db_con,$check2);
                $row2=mysqli_fetch_row($r2);
                
                $sql = "INSERT INTO course (course_id, course_name, course_desc, user_id) VALUES ('$code', '$name', '$desc','$instruct')";

                $sql2 = "INSERT INTO whiteboard (whiteboard_id, course_id) VALUES(CONCAT('W', (SELECT SUBSTRING('$code', 2, 4))), '$code')";

                $sql3 = "INSERT INTO assignment (assignment_id, course_id) VALUES(CONCAT('S', (SELECT SUBSTRING('$code', 2, 4))), '$code')";

                if(mysqli_query($db_con, $sql)){
                        echo '<script>alert("The new course is added successfully.")</script>';

                        if(mysqli_query($db_con, $sql2) && mysqli_query($db_con, $sql3)){
                            echo '<script>alert("A whiteboard and assignment discussion platform has been created successfully for this course.")</script>';
                        }
                       
                }
                elseif($row[0] >= 1){
                    echo '<script>alert("This course code is already taken, the course cannot be added.")</script>';
                }
                elseif(!$row2[0]>=1){
                    echo '<script>alert("There is no instructor with this ID exists in database, the course cannot be added.")</script>';
                }
                else{
                    
                    echo '<script>alert("There is error to perform your request. Please check if your entered information are valid and try again.")</script>';
                }

}


if(isset($_POST["DELETEC"]))
{
                

                $code = mysqli_real_escape_string($db_con, $_REQUEST['ccode']);
                $name = mysqli_real_escape_string($db_con, $_REQUEST['cname']);
                
                $sql = "DELETE FROM course WHERE course_id = '$code' AND course_name = '$name'";
                $sql2 = "DELETE FROM whiteboard WHERE course_id = '$code'";
                $sql3 = "DELETE FROM assignment WHERE course_id = '$code'";
                $result = mysqli_query($db_con, $sql);
                
                if(mysqli_affected_rows ($db_con) == 0) {
                    echo '<script>alert("No course deleted.")</script>';
                }
                elseif(mysqli_query($db_con, $sql) && mysqli_query($db_con, $sql2) && mysqli_query($db_con, $sql3)){
                    echo '<script>alert("The course is deleted successfully.")</script>';
                       
                } 
                else{
                    echo '<script>alert("There is error to perform your request. Please check if your entered information are valid and try again.")</script>';
                }

}


if(isset($_POST["EDITC"])){
    $ncode = mysqli_real_escape_string($db_con, $_POST['newcode']);
    $nname = mysqli_real_escape_string($db_con, $_POST['newname']);
    $ndesc = mysqli_real_escape_string($db_con, $_POST['newdescription']);
    $ninstruct = mysqli_real_escape_string($db_con, $_POST['newinstructor']);

    $equery = "UPDATE course SET course_name = '$nname',course_desc = '$ndesc', user_id='$ninstruct' WHERE course_id = '$ncode'";

    if(mysqli_query($db_con, $equery)){ 
        echo '<script>alert("The course is successfully updated.")</script>';
        
    }
    elseif(mysqli_affected_rows ($db_con) == 0) {
        echo '<script>alert("No course is edited.")</script>';
    }
    else{
         echo  '<script>alert("There is error in your request. Your Course ID may be existed already or the Instructor ID entered does not exist. Please check and try again.")</script>';
    }

}




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin | Course List </title>
    <link rel="icon" href="img/octagon.png" type="image/icon type">

    <link rel="shortcut icon" href="img/favicon.png">
    <link href="css/bootstrap-theme.css" rel="stylesheet">
    <link href="css/elegant-icons-style.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />

    <script type="text/javascript">
        function addCourse() {
            document.getElementById("addcourse").style.display = "block";
        }

        function deleteCourse() {
            document.getElementById("deletecourse").style.display = "block";
        }

        function edit(val){
            document.getElementById("editcourse").style.display = "block";
            document.getElementById("newcode").value = val;
            document.getElementById("newcode").innerHTML = val;

        }

        function closeAForm() {
            document.getElementById("addcourse").style.display = "none";
        }

        function closeDForm() {
            document.getElementById("deletecourse").style.display = "none";
        }

        function closeEForm(){
            document.getElementById("editcourse").style.display="none";
        }
    </script>

    <style>
        * {
            box-sizing: border-box;
        }
        
        .addPopup,
        .addPopup2,
        .addPopup3 {
            position: relative;
            text-align: center;
            width: 100%;
        }      
        
        .formPopup {
            color: black;
            overflow: auto;
            font-weight: 500;
            display: none;
            position: fixed;
            left: 55%;
            top: 18%;
            transform: translate(-50%, 5%);
            border: 4px solid whitesmoke;
            z-index: 9;
            background-color: snow;
        }
        
        .formContainer {
            max-height: 530px;
            max-width: 450px;
            padding: 20px;
        }
        
        .formContainer input[type=text] {
            width: 100%;
            padding: 15px;
            margin: 5px 0 20px 0;
            border: none;
            background: #eee;
        }
        
        .formContainer input[type=text]:focus {
            background-color: #ddd;
            outline: none;
        }
        
        .formContainer .btn {
            padding: 12px 20px;
            border: none;
            background-color: #8ebf42;
            color: #fff;
            cursor: pointer;
            width: 100%;
            margin-bottom: 15px;
            opacity: 0.8;
        }
        
        .formContainer .cancel {
            background-color: #cc0000;
        }
        
        .formContainer .btn:hover {
            opacity: 2;
        }
    </style>

</head>

<body>
    <!-- container section start -->
    <section id="container">


        <header class="header dark-bg">
         

            <!--logo start-->
            <img id="octa_logo" src="img/octagon_white.png" alt="Octa Logo">
            <a href="index.html" class="logo">Octa <span class="lite">Learning Portal</span></a>
            <!--logo end-->

            <div class="top-nav notification-row">
                <!-- notificatoin dropdown start-->
                <ul class="nav pull-right top-menu">

                    <!-- user login dropdown start-->
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="profile-ava">
                                <img alt="pic" src="img/user.png" width="30" height="30">
                            </span>
                            <span style="font-size: 18px; color: white" class="username">&nbspAdmin</span>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu extended">
                            <div class="log-arrow-up"></div>
                            <li>
                                <a href="login.php"><i class="icon_key_alt"></i> &nbsp Log Out</a>
                            </li>
                        </ul>
                    </li>
                    <!-- user login dropdown end -->
                </ul>
                <!-- notificatoin dropdown end-->
            </div>
        </header>
        <!--header end-->

        <!--sidebar start-->
        <aside>
            <div id="sidebar" class="nav-collapse ">
                <!-- sidebar menu start-->
                <ul class="sidebar-menu">
                    <li>
                        <a href="admin_dashboard.php">
                            <i class="icon_house_alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li class="active">
                        <a href="admin_course_list.php">
                            <i class="icon_document"></i>
                            <span>Course List</span>
                        </a>
                    </li>
                    <li>
                        <a href="admin_user_list.php">
                            <i class="icon_profile"></i>
                            <span>Instructor List</span>
                        </a>
                    </li>
                    <li>
                        <a href="admin_feedback.php">
                            <i class="icon_datareport"></i>
                            <span>System Feedback</span>
                        </a>
                    </li>

                </ul>
                <!-- sidebar menu end-->
            </div>
        </aside>
        <!--sidebar end-->

        <!--main content start-->
        <section id="main-content">
            <section class="wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="page-header"><i class="icon_book"></i>Course List</h3>
                        <ol class="breadcrumb">
                            <li><i class="icon_house"></i><a href="admin_dashboard.php">Admin Dashboard</a></li>
                            <li><i class="icon_folder"></i>Course List</li>
                        </ol>
                    </div>
                </div>
                <!-- page start-->
                <!-- Add / Delete course button -->
                <div class="row" style="text-align: right; margin-right: 30px;">

                    <a class="btn btn-primary" data-modal="modalOne" title="Add New Course" onclick="addCourse()">
                        <span class="icon_plus_alt"> &nbsp;</span> Add New Course</a>



                    <a class="btn btn-danger" style="margin-left: 30px" data-modal="modalTwo" title="Delete A Course" onclick="deleteCourse()">
                        <span class="icon_minus_alt"> &nbsp;</span> Delete A Course</a>

                </div>


                <div class="addPopup">
                    <div class="formPopup" id="addcourse">
                        <form action="admin_course_list.php" method="POST" class="formContainer">
                            <h2 style="font-weight: 600;">Please Add New Course</h2>
                            <label for="ccode">
                                <strong>Course Code</strong>
                              </label>
                            <input type="text" id="ccode" placeholder="Course Code" name="ccode" required>
                            <label for="cname">
                              <strong>Course Name</strong>
                            </label>
                            <input type="text" id="cname" placeholder="Course Name" name="cname" required>
                            <label for="cdescription">
                              <strong>Course Description</strong>
                            </label>
                            <input type="text" id="cdescription" placeholder="Short Description" name="cdescription" required>
                            <label for="cinstructor">
                                <strong>Course Instructor</strong>
                              </label>
                            <input type="text" id="cinstructor" placeholder="Instructor ID" name="cinstructor" required>

                            <input type="submit" class="btn" name="ADDC" value="Add"></input>
                            <button type="button" class="btn cancel" onclick="closeAForm()">Cancel</button>
                        </form>
                    </div>
                </div>

                <div class="addPopup2">
                    <div class="formPopup" id="deletecourse">
                        <form action="admin_course_list.php" method="POST" class="formContainer">
                            <h2 style="font-weight: 600;">Please Delete A Course</h2>
                            <label for="ccode">
                                <strong>Course Code</strong>
                              </label>
                            <input type="text" id="ccode" placeholder="Course Code" name="ccode" required>
                            <label for="cname">
                              <strong>Course Name</strong>
                            </label>
                            <input type="text" id="cname" placeholder="Course Name" name="cname" required>

                            <input type="submit" class="btn" name="DELETEC" value="Delete" onclick="return confirm('Are you sure you want to delete?');"></input>
                            <button type="button" class="btn cancel" onclick="closeDForm()">Cancel</button>
                        </form>
                    </div>
                </div>


                <div class="addPopup3">
                    <div class="formPopup" id="editcourse">
                        <form action="admin_course_list.php" method="POST" class="formContainer">
                            <h2 style="font-weight: 600;">Edit This Course</h2></span>
                            <label for="newcode">
                                <input type="text" id="newcode" name="newcode" value="" readonly>
                            </label>
                            <br>
                            <label for="newname">
                              <strong>Course Name</strong>
                            </label>
                            <input type="text" id="newname" placeholder="New Course Name" name="newname" required>
                            <label for="newdescription">
                              <strong>Course Description</strong>
                            </label>
                            <input type="text" id="newdescription" placeholder="Short Description" name="newdescription" required>
                            <label for="newinstructor">
                                <strong>Assigned Course Instructor</strong>
                              </label>
                            <input type="text" id="newinstructor" placeholder="Instructor ID" name="newinstructor" required>

                            <input type="submit" class="btn" name="EDITC" value="Submit"></input>
                            <button type="button" class="btn cancel" onclick="closeEForm()">Cancel</button>
                        </form>
                    </div>
                </div>


                <div class="row"></div>
                <!-- List -->
                <div class="row" style="margin-top: 40px; margin-left: 30px; margin-right: 30px;">
                    <section class="panel">
                        <h4 class="panel-heading" style="color:white; padding-bottom: 10px; padding-top: 10px;">
                            List of All Courses
                        </h4>
                        
                <?php
                        $selectSQL = "SELECT * FROM course";
                        $selectResult = mysqli_query($db_con, $selectSQL);

                        if( !$selectResult ){
                            echo 'Retrieval of data from Database Failed - #'.mysql_errno().': '.mysql_error();
                          }else{

                ?>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Course Code</th>
                                    <th>Course Name</th>
                                    <th>Course Description</th>
                                    <th>Instructor</th>
                                    <th> </th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php

                                if( mysqli_num_rows( $selectResult )==0 ){
                                        echo '<tr><td colspan="4">No Course Added</td></tr>';
                                }
                                else{
                                    $id;
                                    $no = 1;
                                    while( $row = mysqli_fetch_assoc( $selectResult ) ){
                                        $id = $row['course_id'];
                                        echo "<tr>
                                        <td>{$no}</td>
                                        <td>{$row['course_id']}</td>
                                        <td>{$row['course_name']}</td>
                                        <td>{$row['course_desc']}</td>
                                        <td>{$row['user_id']}</td>
                                        <td><a onclick='edit(\"$id\")'><span class='icon_pencil-edit'></a></td>
                                        </tr>\n";
                                        $no++;
                                    }
                            }
                            
                               
                            
                            ?>
                            </tbody>
                        </table>
                        <?php
                    }

                    ?>

                    </section>

                </div>

                <!-- page end-->
            </section>
        </section>
        <!--main content end-->

    </section>
    <!-- container section end -->
    <!-- javascripts -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
   
    <!--custome script for all page-->
    <script src="js/scripts.js"></script>


</body>

</html>