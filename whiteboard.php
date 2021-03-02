<?php

session_start();
require_once "db_con.php";

 //if not logged in
 if (!$_SESSION['UserName']){
    header("Location: index.html");
}

$userID = $_SESSION['UserId'];
$course = array();
$courseID = array();

// Get all whiteboard course name based on userID 
$query = "SELECT * FROM course JOIN whiteboard ON course.course_id=whiteboard.course_id and course.user_id= $userID"; 
$result = mysqli_query($db_con, $query);
if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
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

    <title>Whiteboard</title>
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
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
            color: white;
        }
        
        .centered {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        
        td {
            padding: 0 15px 25px 15px;
        }
    </style>

</head>

<body>
    <!-- container section start -->
    <section id="container">
        <!--header start-->

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
        <li>
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
        <li class="active">
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
                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="page-header"><i class="icon_book_alt"></i> Whiteboard</h3>
                        <ol class="breadcrumb">
                            <li><i class="icon_house"></i><a href="dashboard.php">Home</a></li>
                            <li><i class="icon_clipboard"></i>All Whiteboards</li>
                        </ol>
                    </div>
                </div>
                <!-- page start-->
                <table>

                <!-- Display all course whiteboard-->
                <?php
                if (count($course) >0) {
                    for ($i = 0; $i <= count($course)-1; $i++) { 
                        $directlink = "course_whiteboard.php?courseID=" . $courseID[$i];
                        if ($i % 2 == 0){ 
                            ?>
                            <tr>
                                <td>
                                <div class="container2">
                                    <img src="img/wbbg2.jpg" style="width:100%;">
                                    <div class="centered">
                                        <a href="<?php echo $directlink; ?>">
                                            <h3 style="color: black;"> <?php echo $course[$i]?> </h3>
                                            <p style="color: gray; font-size:16px">Discussion Here</p>
                                        </a>
                                    </div>
                                </div>
                                </td>
                    <?php
                        } 
                        if ($i % 2 == 1){  ?> 
                                <td>
                                <div class="container2">
                                    <img src="img/wbbg2.jpg" style="width:100%;">
                                    <div class="centered">
                                        <a href="<?php echo $directlink; ?>">
                                            <h3 style="color: black;"> <?php echo $course[$i]?> </h3>
                                            <p style="color: gray; font-size:16px;">Discussion Here</p>
                                        </a>
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

                <!-- page end-->
            </section>
        </section>
        <!--main content end-->

    </section>
    <!-- container section end -->
    
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <script>
        //knob
        $(".knob").knob();
    </script>


</body>

</html>