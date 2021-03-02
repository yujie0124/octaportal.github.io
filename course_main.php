<?php 
session_start();
require_once "db_con.php";
date_default_timezone_set('Asia/Kuala_Lumpur');

//if not logged in
if (!$_SESSION['UserName']){
    header("Location: index.html");
}else if(!$_GET['courseID']){
    header("Location: course_list.php");
}

$userID = $_SESSION['UserId']; 
$courseID = $_GET['courseID'];

$course = array();
$cID = array();
$courseDESC = array();
$courseREF = array();
$courseLO = array();



// Get all course name based on userID 
$query = "SELECT * FROM course WHERE course.user_id= $userID and course_id = '$courseID'";
$result = mysqli_query($db_con, $query);
if(mysqli_num_rows($result)>0){
    while($row= mysqli_fetch_assoc($result)){
       array_push($course, $row["course_name"]);
       array_push($cID, $row["course_id"]);
       array_push($courseDESC, $row["course_desc"]);
       array_push($courseREF, $row["course_ref"]);
       array_push($courseLO, $row["course_lo"]);
       $courseName = $row["course_name"];
       $_SESSION['course_name'] = $courseName;
    }
}


if(isset($_POST["submit-desc"])){
    $description = addslashes($_POST['description']);

    $query = "UPDATE course SET course_desc = '$description' WHERE course_id = '$courseID'";
    if(mysqli_query($db_con, $query)){ 
        echo '<script>confirm("The course description is updated successfully.")</script>';
        header("Refresh:0");
    }else{
        echo '<script>alert("ERROR: Unable to execute SQL query. ")</script>';
    }

}

if(isset($_POST["submit-ref"])){
    $ref = addslashes($_POST['reference']);

    $query = "UPDATE course SET course_ref = '$ref' WHERE course_id = '$courseID'";
    if(mysqli_query($db_con, $query)){ 
        echo '<script>confirm("The course reference is updated successfully.")</script>';
        header("Refresh:0");
    }else{
        echo '<script>alert("ERROR: Unable to execute SQL query. ")</script>';
    }
}

if(isset($_POST["submit-lo"])){
    $lo = addslashes($_POST['lo']);

    $query = "UPDATE course SET course_lo = '$lo' WHERE course_id = '$courseID'";
    if(mysqli_query($db_con, $query)){ 
        echo '<script>confirm("The course learning outcome is updated successfully.")</script>';
        header("Refresh:0");
    }else{
        echo '<script>alert("ERROR: Unable to execute SQL query. ")</script>';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="img/favicon.png">
    <title><?php echo $course[0];?></title>

    <link rel="icon" href="img/octagon.png" type="image/icon type">
    
    <!-- bootstrap theme -->
    <link href="css/bootstrap-theme.css" rel="stylesheet">
    <!--external css-->
    <!-- font icon -->
    <link href="css/elegant-icons-style.css" rel="stylesheet" />
    
    <!-- Custom styles -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/course_whiteboard_style.css" rel="stylesheet">

    <script type="text/javascript">
         
        function blink(id){
                var target = document.getElementById(id);
                target.classList.add("blink");
                setTimeout(function(){
                        target.classList.remove("blink");
                }, 1000);
        }

        function showPopUp1(courseDESC){
                document.getElementById("modify-desc").style.display = "block";
                document.getElementById("description").value = courseDESC;
        }

        function showPopUp2(courseREF){
                document.getElementById("modify-ref").style.display = "block";
                document.getElementById("reference").value = courseREF;
        }

        function showPopUp3(courseLO){
                document.getElementById("modify-lo").style.display = "block";
                document.getElementById("lo").value = courseLO;
        }

        function closePopUp1(){
                document.getElementById("modify-desc").style.display="none";
        }

        function closePopUp2(){
                document.getElementById("modify-ref").style.display="none";
        }

        function closePopUp3(){
                document.getElementById("modify-lo").style.display="none";
        }


    </script>


</head>

<style>
    
.arrow_down:before {
    content: "\22";
}
    
.arrow_triangle-down_alt2:before {
    content: "\47";
}
    
</style>
    
<body style="background: #fffded">
    <!-- container section start -->
    <section id="container">
        <!--header start-->

        <header class="header dark-bg">

            <!--logo start-->
            <img id="octa_logo" src="img/octagon_white.png" alt="Octa Logo">
            <a href="dashboard.php" class="logo" style="margin-top:14px;">Octa <span class="lite">Learning Portal</span></a>
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
            <div id="sidebar" style="background: #fffef5">
                <!-- sidebar menu start-->
                <ul class="sidebar-menu">
                    <li>
                        <a href="dashboard.php">
                            <i class=arrow_left_alt style="color: orange;"></i><span style="color: orange; font-weight: 500;">&nbsp Dashboard</span>
                        </a>
                    </li>
                    <li class="active">
                        <a href="<?php echo "course_main.php?courseID=" .$courseID; ?>">
                            <i class="icon_book"></i>
                            <span>Course Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo "course_whiteboard.php?courseID=" .$courseID; ?>">
                            <i class="icon_comment"></i>
                            <span>Whiteboard</span>
                        </a>

                    </li>

                    <li>
                        <a href="<?php echo "course_assignment.php?courseID=" .$courseID; ?>">
                            <i class="icon_pencil"></i>
                            <span>Assignment</span>
                        </a>

                    </li>

                </ul>
                <!-- sidebar menu end-->
            </div>
        </aside>
        <!--sidebar end-->

        <!--main content start-->
        <section id="main-content">
            <section class="wrapper" style="background: #fffded">
                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="page-header"><i class="icon_book"></i><?php echo $_SESSION['course_name']; ?> </h3>
                        <ol class="breadcrumb">
                            <li><i class="icon_house"></i><a href="dashboard.php">Home</a></li>
                            <li><i class="icon_book"></i>Course Dashboard</li>

                        </ol>
                    </div>
                </div>
                <!-- page start-->

                <?php
                if (count($course) >0){
                    for ($i=0; $i<= count($course)-1; $i++){
                        $directlink = "course_main.php?courseID=" .$cID[$i];
                        if ($i % 2 == 0){
                            ?>
                   <tr>
                    <td>
                
                <!-- Bootstrap Static Header -->
                <div style="background: url('img/course-bg.jpg'); background-position:center; background-repeat: no-repeat;background-size: cover;" class="jumbotron bg-cover text-white">
                    <div class="container py-5 text-right">
                        <a href="<?php echo $directlink; ?>">
                        <h3 style="font-style: bold;color:cornflowerblue;"><?php echo $course[$i]?></h3>
                        <p style="font-style:italic;color:cadetblue;"><?php echo $cID[$i]?></p>
                        </a>

                    </div>
                </div>

                <div class="container">

                <div class="overlay" id="modify-desc">
                        <div class="popup-box" >
                            <form method="post" action="#">
                                <label for="name" style="text-align: right;font-size:18px;color:blue;">Modify Course Description<span>*</span></label>
                                <div class="item">
                                    <textarea style="height:180px; font-size:16px; resize:none" id="description" type="textarea" placeholder="Type your content here" name="description" required></textarea>
                                </div>

                                <div class="btn-block">
                                    <button onclick="closePopUp1()">CANCEL</button>
                                    <button style="margin-left: 10px" type="submit" name="submit-desc">SUBMIT</button>
                                </div>
                            </form>
                        </div>
                </div>


                <div class="overlay" id="modify-ref">
                        <div class="popup-box" >
                            <form method="post" action="#">
                                <label for="name" style="text-align: right;font-size:18px;color:blue;">Modify Course Reference<span>*</span></label>
                                <div class="item">
                                    <textarea style="height:180px; font-size:16px; resize:none" id="reference" type="textarea" placeholder="Type your content here" name="reference" required></textarea>
                                </div>

                                <div class="btn-block">
                                    <button onclick="closePopUp2()">CANCEL</button>
                                    <button style="margin-left: 10px" type="submit" name="submit-ref">SUBMIT</button>
                                </div>
                            </form>
                        </div>
                </div>


                <div class="overlay" id="modify-lo">
                        <div class="popup-box" >
                            <form method="post" action="#">
                                <label for="name" style="text-align: right;font-size:18px;color:blue;">Modify Course Learning Outcome<span>*</span></label>
                                <div class="item">
                                    <textarea style="height:180px; font-size:16px; resize:none" id="lo" type="textarea" placeholder="Type your content here" name="lo" required></textarea>
                                </div>

                                <div class="btn-block">
                                    <button onclick="closePopUp3()">CANCEL</button>
                                    <button style="margin-left: 10px" type="submit" name="submit-lo">SUBMIT</button>
                                </div>
                            </form>
                        </div>
                </div>
                    
                    <div class="row">
                        <div class="col-lg-12">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-default">
                                        <!-- course desc -->
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a>
                                                                  Course Description &nbsp;&nbsp;<i class="arrow_down"></i>
                                                </a>
                                            </h4>
                                        </div>
                                        <div>
                                            <div class="panel-body">
                                            
                                            <tr>
                                            <td><?php echo $courseDESC[$i]?></td>
                                            <td><a title="Modify Course Description" onclick="showPopUp1('<?php echo $courseDESC[$i];?>')" style="margin-left: 10px; margin-right: 10px;">
                                            <span class='icon_pencil-edit'></a></td>
                                            </tr>

                                            </div>
                                        </div>
                                        <!-- course reference -->
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a>
                                                                  Course Reference &nbsp;&nbsp;<i class="arrow_down"></i>
                                                              </a>
                                            </h4>
                                        </div>
                                        <div>
                                            <div class="panel-body">
                                            <tr>
                                            <td><?php echo $courseREF[$i]?></td>
                                            <td><a title="Modify Course Reference" onclick="showPopUp2('<?php echo $courseREF[$i];?>')" style="margin-left: 10px; margin-right: 10px;">
                                            <span class='icon_pencil-edit'>
                                            </a></td>
                                            </tr>
                                            </div>
                                        </div>
                                        <!-- learning outcome -->
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a>
                                                            Learning Outcome &nbsp;&nbsp;<i class="arrow_down"></i>
                                                </a>
                                            </h4>
                                        </div>
                                        <div>
                                            <div class="panel-body">
                                            <tr>
                                            <td><?php echo $courseLO[$i]?></td>
                                            <td><a title="Modify Course Learning Outcome" onclick="showPopUp3('<?php echo $courseLO[$i];?>')" style="margin-left: 10px; margin-right: 10px;">
                                            <span class='icon_pencil-edit'>
                                            </a></td>
                                            </tr>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End .entry-content -->
                                <?php
                                     }
                            }
                                    }
                    ?>
                                    
                                    <!-- Instructor's Detail -->
                                    <?php 
                                           $q = "SELECT * FROM users WHERE user_id='$userID'"; 
                                           $r = mysqli_fetch_array(mysqli_query($db_con, $q));
                                    ?>
                                    <div class="panel-body">
                                        <table class="table" style="border:0px;margin-top:-30px;margin-top:-30px;">
                                        </table>
                                        <div class="col-sm-3">
                                            <img src='img/default-profile.jpg' width="200px" height="280px" class="thumbnail">
                                        </div>
                                        <div class="col-sm-9">
                                            <div style="font-size:24px;color: slateblue!important; margin-left:-50px;padding-bottom: 10px; display:inline; margin-top:-30px;">
                                               <span> <?php echo "&nbsp". $r['user_name'] ?> </span> <br>
                                            </div>
                                            </br>
                                            <h4><img src='img/phone-icon.jpg' width="23px" height="20px" style="margin-left:-50px;margin-bottom:0.5px;"> <?php echo $r['user_phone'] ?>
                                            </h4> <br>
                                            <h4><img src='img/email-icon.jpg' width="20px" height="16px" alt="" style="margin-left:-50px;margin-bottom:0.5px;"> <?php echo $r['user_email'] ?></h4><br>
                                            <div class="col-sm-6">
                                            </div>
                                        </div>
                                        <br><br><br>
                                    </div>
                                    <!--End.Instructor's Detail-->
                                    <hr>

                                <!--Post from whiteboard-->

                                <div class="col-lg-12">
                                            <section class="panel">
                                            <header class="panel-heading" style="font-size:17px; font-family:Lato;">
                                                    Lastest Announcements
                                            </header>
                                
                                <?php 
                                           $t = "SELECT * FROM post WHERE whiteboard_id = (SELECT whiteboard_id FROM whiteboard WHERE course_id='$courseID') ORDER BY post_date DESC LIMIT 3";
                                
                                if($result = mysqli_query($db_con, $t)) {
                                    $c = mysqli_num_rows($result);
                                    
                                    if($c > 0) {
                                        while($r = mysqli_fetch_array($result)) {
                                            echo'
                                                <div class="panel-body">
                                                    <div class="panel panel-primary">
                                                    
                                                    <div class="panel panel-info">
                                                        <div class="panel-heading" style="font-size:17px; font-family:Lato;"><b>'.$r['post_title'].'</b></div>
                                                        
                                                    <div class="panel-content" style="font-size:15px;">    
                                                        Posted on '.$r['post_date'].'<br>  
                                                        <br>
                                                        '. $r['post_content'] .'<br> <br>
                                                    </div>
                                                    
                                                    </div>
                                                </div>
                                            </div>';
                                                }
                                            }
                                    
                                        else {
                                            echo '
                                            <div class="panel-content" style="font-size:15px;margin-left:20px;">
                                                <br>No posts from whiteboard yet...
                                            </div>';
                                        }
                                    }
                                ?>
                                
                                <br>
                                <br>
                                
                                <!-- End of All Post-->

                                        <!-- End .entry-content -->

                                    </div>
                                    <!-- End .entry-body -->
                                </div>
                                <!-- End .col-md-7 -->
                            </div>
                            <!-- End .row -->

                            <!-- End .entry -->

                        </div>
                        <!-- End .col-lg-9 -->


                    </div>
                    <!-- End .row -->
                </div>
                <!-- End .container -->


                <!-- page end-->

            </section>
        </section>
        <!--main content end-->

    </section>
    <!-- container section end -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>

</body>

</html>