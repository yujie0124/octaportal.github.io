<?php
session_start();
require_once "db_con.php";
$message = "";


if(!isset($_SESSION["UserId"]))
{
    echo"<script>window.open('index.php?mes=Access Denied...','_self');</script>";
    
}	
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin | Instructors Feedback </title>
    <link rel="icon" href="img/octagon.png" type="image/icon type">

    <link rel="shortcut icon" href="img/favicon.png">
    <link href="css/bootstrap-theme.css" rel="stylesheet">
    <link href="css/elegant-icons-style.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet">
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
            <div id="sidebar">
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
                    <li>
                        <a href="admin_user_list.php">
                            <i class="icon_profile"></i>
                            <span>Instructor List</span>
                        </a>
                    </li>

                    <li class="active">
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
                        <h3 class="page-header"><i class="icon_house"></i> System Feedbacks</h3>
                        <ol class="breadcrumb">
                         <li><i class="icon_house"></i><a href="admin_dashboard.php">Admin Dashboard</a></li>
                            <li><i class="icon_datareport"></i>Users' Feedback</li>
                        </ol>
                    </div>
                </div>
                <!-- page start-->
                <div class="row">
                     
                <div class="row" style="margin-top: 40px; margin-left: 30px; margin-right: 30px;">
                    <section class="panel">
                        <h4 class="panel-heading" style="color: white; padding-bottom: 10px; padding-top: 10px;">
                            Feedbacks From System Users
                        </h4>

                        <?php
                        $selectSQL = "SELECT * FROM contact";
                        $selectResult = mysqli_query($db_con, $selectSQL);

                        if( !$selectResult ){
                            echo 'Retrieval of data from Database Failed - #'.mysql_errno().': '.mysql_error();
                          }else{

                        ?>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Feedback User's Name</th>
                                    <th>Feedback User's ID</th>
                                    <th>Feedback User's Email</th>
                                    <th>Feedback Title</th>
                                    <th>Feedback Message</th>
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
                                    echo "<tr><td>{$no}</td><td>{$row['name']}</td><td>{$row['user_id']}</td><td>{$row['email']}</td><td>{$row['subject']}</td><td>{$row['message']}</td></tr>\n";
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
    
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/bootstrap.min.js"></script>


</body>

</html>