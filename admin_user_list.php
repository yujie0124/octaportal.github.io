<?php
session_start();
require_once "db_con.php";
$message = "";


if(!isset($_SESSION["UserId"]))
{
    echo"<script>window.open('index.php?mes=Access Denied...','_self');</script>";
    
}	


if(isset($_POST["ADDI"]))
{

                $uid = mysqli_real_escape_string($db_con, $_REQUEST['iid']);
                $uname = mysqli_real_escape_string($db_con, $_REQUEST['iname']);
                $uphone = mysqli_real_escape_string($db_con, $_REQUEST['iphone']);
                $uemail = mysqli_real_escape_string($db_con, $_REQUEST['iemail']);
                $upassword = mysqli_real_escape_string($db_con, $_REQUEST['psw']);


                $check = "SELECT COUNT(user_id) FROM users WHERE user_id = '$uid'";
                $r=mysqli_query($db_con,$check);
                $row=mysqli_fetch_row($r);

    
                
                $sql = "INSERT INTO users (user_id, user_name, user_email, user_phone, user_password, user_level) VALUES ('$uid', '$uname', '$uemail','$uphone','$upassword','Instructor')";
                if(mysqli_query($db_con, $sql)){
                        echo '<script>alert("The new instructor has been added successfully.")</script>';
                       
                }
                else{
                    
                    echo "ERROR: Unable to execute. ";
                }

}


if(isset($_POST["DELETEI"]))
{

                $id = mysqli_real_escape_string($db_con, $_REQUEST['iid']);
                $iname = mysqli_real_escape_string($db_con, $_REQUEST['iname']);
                
                $sql = "DELETE FROM users WHERE user_id = '$id' AND user_name = '$iname'";
                $result = mysqli_query($db_con, $sql);
                
                if(mysqli_affected_rows ($db_con) == 0) {
                    echo '<script>alert("There is error with your input data. The instructor may not exist in database. so no instructor is deleted.")</script>';
                }
                elseif($result){
                    print('<script>alert("The instructor is deleted successfully.")</script>');
                       
                } 
                else{
                        echo "ERROR: Unable to execute $sql " . mysqli_error($db_con);
                }

}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin | User List </title>
    <link rel="icon" href="img/octagon.png" type="image/icon type">

    <link rel="shortcut icon" href="img/favicon.png">
  
    <link href="css/bootstrap-theme.css" rel="stylesheet">
    <link href="css/elegant-icons-style.css" rel="stylesheet" />
    
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />

    <script type="text/javascript">
        function addInstructor() {
            document.getElementById("addinstructor").style.display = "block";
        }

        function deleteInstructor() {
            document.getElementById("deleteinstructor").style.display = "block";
        }

        function closeAForm() {
            document.getElementById("addinstructor").style.display = "none";
        }

        function closeDForm() {
            document.getElementById("deleteinstructor").style.display = "none";
        }
    </script>

    <style>
        * {
            box-sizing: border-box;
        }
        
        .addPopup {
            position: relative;
            text-align: center;
            width: 100%;
        }
        
        .addPopup2 {
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
        
        .formContainer input[type=text],
        .formContainer input[type=password],
        .formContainer input[type=email] {
            width: 100%;
            padding: 15px;
            margin: 5px 0 20px 0;
            border: none;
            background: #eee;
        }
        
        .formContainer input[type=text]:focus,
        .formContainer input[type=password]:focus,
        .formContainer input[type=email]:focus {
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

                    <li>
                        <a href="admin_course_list.php">
                            <i class="icon_document"></i>
                            <span>Course List</span>
                        </a>
                    </li>
                    <li class="active">
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
                        <h3 class="page-header"><i class="icon_profile"></i> Instructor List</h3>
                        <ol class="breadcrumb">
                            <li><i class="icon_house"></i><a href="admin_dashboard.php">Admin Dashboard</a></li>
                            <li><i class="icon_genius"></i>Instructor List</li>
                        </ol>
                    </div>
                </div>
                <!-- page start-->
                <!-- Add / Delete course button -->
                <div class="row" style="text-align: right; margin-right: 30px;">

                    <a class="btn btn-primary" onclick="addInstructor()" title="Add New Instructor">
                        <span class="icon_plus_alt"> &nbsp;</span> Add New Instructor</a>

                    <a class="btn btn-danger" style="margin-left: 30px" onclick="deleteInstructor()" title="Delete An Instructor">
                        <span class="icon_minus_alt"> &nbsp;</span> Delete An Instructor</a>

                </div>


                <div class="addPopup">
                    <div class="formPopup" id="addinstructor">
                        <form action="admin_user_list.php" method="POST" class="formContainer">
                            <h2 style="font-weight: 600;">Please Add New Instructor</h2>
                            <label for="iid">
                                <strong>ID</strong>
                              </label>
                            <input type="text" id="iid" placeholder="Instructor ID" name="iid" required>

                            <label for="iname">
                              <strong>Name</strong>
                            </label>
                            <input type="text" id="iname" placeholder="Instructor Name" name="iname" required>

                            <label for="iphone">
                                <strong>Phone</strong>
                              </label>
                            <input type="text" id="iphone" placeholder="Instructor Phone" name="iphone" required>

                            <label for="iemail">
                                <strong>E-mail</strong>
                              </label>
                            <input type="email" id="iemail" placeholder="Instructor Email" name="iemail" required>

                            <label for="psw">
                                <strong>Password</strong>
                              </label>
                            <input type="password" id="psw" placeholder="Instructor Password" name="psw" required>


                            <input type="submit" class="btn" value="Add" name="ADDI"></input>
                            <button type="button" class="btn cancel" onclick="closeAForm()">Cancel</button>
                        </form>
                    </div>
                </div>

                <div class="addPopup2">
                    <div class="formPopup" id="deleteinstructor">
                        <form action="admin_user_list.php" method="POST" class="formContainer">
                            <h2 style="font-weight: 600;">Please Delete An Instructor</h2>
                            <label for="iid">
                                <strong>Instructor ID</strong>
                              </label>
                            <input type="text" id="iid" placeholder="Instructor Code" name="iid" required>

                            <label for="iname">
                              <strong>Instructor Name</strong>
                            </label>
                            <input type="text" id="iname" placeholder="Instructor Name" name="iname" required>

                            <input type="submit" class="btn" value="Delete" name="DELETEI" onclick="return confirm('Are you sure you want to delete?');"></input>
                            <button type="button" class="btn cancel" onclick="closeDForm()">Cancel</button>
                        </form>
                    </div>
                </div>


                <div class="row"></div>
                <!-- List -->
                <div class="row" style="margin-top: 40px; margin-left: 30px; margin-right: 30px;">
                    <section class="panel">
                        <h4 class="panel-heading" style="color: white; padding-bottom: 10px; padding-top: 10px;">
                            List of All Instructors
                        </h4>

                        <?php
                        $selectSQL = "SELECT * FROM users WHERE user_level = 'Instructor'";
                        $selectResult = mysqli_query($db_con, $selectSQL);

                        if( !$selectResult ){
                            echo 'Retrieval of data from Database Failed - #'.mysql_errno().': '.mysql_error();
                          }else{

                        ?>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Instructor ID</th>
                                    <th>Instructor Name</th>
                                    <th>Instructor Email</th>
                                    <th>Instructor Phone</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php

                            if( mysqli_num_rows( $selectResult )==0 )
                            {
                                    echo '<tr><td colspan="4">No Instructor Added</td></tr>';
                            }
                            else{
                                    $no = 1;
                                    while( $row = mysqli_fetch_assoc( $selectResult ) ){
                                    echo "<tr><td>{$no}</td><td>{$row['user_id']}</td><td>{$row['user_name']}</td><td>{$row['user_email']}</td><td>{$row['user_phone']}</td></tr>\n";
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