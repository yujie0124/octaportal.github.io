<?php

session_start();
require_once "db_con.php";

 //if not logged in
 if (!$_SESSION['UserName']){
    header("Location: index.html");
}

$userID = $_SESSION['UserId'];
$UserName = $_SESSION['UserName'];
$course = array();
$courseID = array();



// Get course list, whiteboard list based on UserID

$result= mysqli_query($db_con,"SELECT * FROM course WHERE course.user_id= $userID");
if(mysqli_num_rows($result)>0){
    while($row= mysqli_fetch_assoc($result)){
       array_push($course, $row["course_name"]);
       array_push($courseID, $row["course_id"]);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Dashboard</title>
    <link rel="icon" href="img/octagon.png" type="image/icon type">

    <!-- bootstrap theme -->
    <link href="css/bootstrap-theme.css" rel="stylesheet">
  
    <!-- font icon -->
    <link href="css/elegant-icons-style.css" rel="stylesheet" />

    <!-- Custom styles -->
    
    <link href="css/style.css" rel="stylesheet">
    
    <style>
        .container2 {
            position: relative;
            max-width: 423px;
            /* Maximum width */
            margin: 0 auto;
            /* Center it */
        }
        
        .container2 .content {
            position: absolute;
            /* Position the background text */
            bottom: 0;
            /* At the bottom. Use top:0 to append it to the top */
            background: rgb(0, 0, 0);
            /* Fallback color */
            background: rgba(0, 0, 0, 0.5);
            /* Black background with 0.5 opacity */
            color: #f1f1f1;
            /* Grey text */
            width: 100%;
            /* Full width */
            padding: 20px;
            /* Some padding */
        }
        
        td {
            padding: 0 15px 25px 15px;
        }
    </style>

</head>

<body>
    <!-- container section start -->
    <section id="container">


        <header class="header dark-bg">

            <!--logo start-->
            <img id="octa_logo" src="img/octagon_white.png" alt="Octa Logo">
            <a href="dashboard.php" class="logo">Octa <span class="lite">Learning Portal</span></a>
            <!--logo end-->

            <div class="top-nav notification-row">
                <ul class="nav pull-right top-menu">

                      <!-- user login dropdown start-->
                        <li class="dropdown">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="profile-ava">
                                    <img alt="pic" src="img/user.png" width="30" height="30">
                                </span>
                                <span style="font-size: 18px;">&nbsp<?php echo $_SESSION['UserName']; ?> </span>
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
            </div>
        </header>
        <!--header end-->

        <!--sidebar start-->
        <aside>
            <div id="sidebar">
                <!-- sidebar menu start-->
                <ul class="sidebar-menu">
                    <li class="active">
                        <a href="dashboard.php">
                            <i class="icon_house_alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li>
                        <a href="course_list.php">
                            <i class="icon_documents_alt"></i>
                            <span>Course List</span>
                        </a>
                    </li>
                    <li>
                        <a href="whiteboard.php">
                            <i class="icon_comment"></i>
                            <span>Whiteboard</span>
                        </a>

                    </li>

                    <li>
                        <a href="profile.php">
                            <i class="icon_profile"></i>
                            <span>Profile</span>
                        </a>

                    </li>

                    <li>
                        <a href="contact.php">
                        <i class="icon_puzzle"></i>
                        <span>Contact Us</span></a>

                    </li>

                </ul>
                <!-- sidebar menu end-->
            </div>
        </aside>
        <!--sidebar end-->

        <!--main content start-->
        <section id="main-content">
            <section class="wrapper">
                <!--overview start-->
                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="page-header" style="margin-left: 10px; font-size: 35px; color: #0098b9 ; font-weight: 350;">
                            Welcome,
                            <text style="color:orange"><?php echo $_SESSION["UserName"]?></text>
                        </h3>
                        <ol class="breadcrumb">
                            <li><i class="icon_house"></i><a href="#">Home</a></li>
                            <li><i class="icon_laptop"></i>Dashboard</li>
                        </ol>
                    </div>
                </div>

                <!-- page start -->
                <div class=".col-lg-10">
                    
                    <!--/class box start-->

                    <section class="panel">
                        <div class="panel-body progress-panel">
                            <div class="row">
                                <div class="col-lg-10 task-progress">
                                    <h1 style="font-size: 25px; font-family: sans-serif; margin:1px; ">Your Assigned Courses</h1>
                                </div>
                            </div>
                        </div>
                    </section>
                    <table>
                    <!--/ display class box-->
                          <?php
                    if (count($course) >0){
                        for ($i=0; $i<= count($course)-1; $i++){
                            $directlink = "course_main.php?courseID=" .$courseID[$i];
                            if ($i % 2 == 0){
                            ?>
                        <tr>
                        <td>
                            <div class="container2">
                                <img src="img/class.jpg" style="width:100%;">
                                <div class="content">
                                    <a href="<?php echo $directlink; ?>">
                                        <h1 style="color: white;"><?php echo $course[$i]?></h1>
                                    </a>
                                    <p><?php echo $courseID[$i]; ?></p>
                                </div>
                            </div>
                        </td>
                        <?php
                            }
                        if ($i % 2 == 1){ ?>
                        <td>
                             <div class="container2">
                                <img src="img/class.jpg" style="width:100%;">
                                <div class="content">
                                    <a href="<?php echo $directlink; ?>">
                                        <h1 style="color: white;"><?php echo $course[$i]?></h1>
                                    </a>
                                    <p><?php echo $courseID[$i]; ?></p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php
                                        }
                        }
                    }else{
                       echo "<p> <font color=blue font face='arial'>There is no course assigned for you yet...</font></p><br>";
                        
                    }
                    ?>
                </table>
                    </div>
                    <!-- Class Box ended -->


                    <!-- Whiteboard Box start -->
                    <section class="panel">
                        <div class="panel-body progress-panel">
                            <div class="row">
                                <div class="col-lg-10 task-progress">
                                    <h1 style="font-size:25px; font-family: sans-serif; margin:1px;">Whiteboard Discussion for Your Courses</h1>
                                </div>
                            </div>
                        </div>
                    </section>
                    
                     <table>
                         <?php
                    if (count($course) >0){
                        for ($i=0; $i<= count($course)-1; $i++){
                            $directlink = "course_whiteboard.php?courseID=" .$courseID[$i];
                            if ($i % 2 == 0){
                              ?>
                        <tr>
                        <td>
                            <div class="container2">
                                <img src="img/team.jpg" style="width:100%;">
                                <div class="content">
                                    <a href="<?php echo $directlink; ?>">
                                        <h1 style="color: white;"><?php echo $course[$i]?></h1>
                                    </a>
                                    <p><?php echo $courseID[$i]; ?></p>
                                </div>
                            </div>
                        </td>
                        <?php
                            }
                            if ($i % 2 == 1){ ?>
                        <td>
                            <div class="container2">
                                <img src="img/team.jpg" style="width:100%;">
                                <div class="content">
                                    <a href="<?php echo $directlink; ?>">
                                        <h1 style="color: white;"><?php echo $course[$i]?></h1>
                                    </a>
                                    <p><?php echo $courseID[$i]; ?></p>
                                </div>
                            </div>
                        </td>
                    </tr>
                           <?php
                            }
                        }
                        
                    }else{
                       echo "<p> <font color=blue font face='arial'>There is no whiteboard assigned for you yet...</font></p>";
                        
                    }
                    ?>
                </table>
                    <!--White box end-->
            </section>
            <!--main content end-->
        </section>

    <!-- javascripts -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/bootstrap.min.js"></script>
       
      

</body>

</html>