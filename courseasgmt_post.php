<?php
    session_start();
    require_once "db_con.php";
    date_default_timezone_set('Asia/Kuala_Lumpur');

    //if not logged in
    if (!$_SESSION['UserName']){
        header("Location: index.html");
    }else if(!$_GET['asgmtpost_id']){
        header("Location: course_assignment.php");
    }

    //get current post_id
    $_SESSION['asgmtpost_id'] = $_GET['asgmtpost_id'];

    //get all details of current post (author, assignment_id, etc.)
    $query = "SELECT * FROM asgmt_post, users, course, assignment 
                WHERE asgmt_post.assignment_id=assignment.assignment_id AND assignment.course_id=course.course_id 
                    AND asgmt_post.user_id=users.user_id AND asgmtpost_id='".$_SESSION['asgmtpost_id']."'";

    if($result=mysqli_query($db_con, $query)){ 
        $rowcount = mysqli_num_rows($result);

        if($rowcount > 0)  //if post exists
            $row = mysqli_fetch_assoc($result);
        else
            header("Location: course_assignment.php");
    } else{
         echo "<script>alert('Unable to execute SQL query');</script>";
    }


    if(isset($_POST["submit-asgmt_comment"])){   //if submit button is pressed
        $asgmt_comment = addslashes($_POST['asgmt_comment']);
        $asgmtcomment_date = date("Y-m-d H:i:s", time()); 
        $user_id = 201;
        $asgmtpost_id = $row['asgmtpost_id'];
        $assignment_id = $row['assignment_id'];

        $query = "INSERT INTO asgmt_comment (asgmtcomment_msg, asgmtcomment_date, user_id, asgmtpost_id, assignment_id) VALUES('$asgmt_comment', '$asgmtcomment_date', '".$_SESSION['UserId']."', '$asgmtpost_id', '$assignment_id')";
        if(!mysqli_query($db_con, $query)){ 
            echo "<script>alert('Unable to execute SQL query');</script>";
        }
    }


    if(isset($_POST["submit-modified-post"])){
        $title = addslashes($_POST['title']);
        $description = addslashes($_POST['description']);
        $startdate = addslashes($_POST["startdate"]);
        $enddate = addslashes($_POST["enddate"]);

        $query = "UPDATE asgmt_post SET asgmtpost_title='$title', asgmtpost_desc='$description', asgmt_startdate='$startdate', asgmt_enddate='$enddate' WHERE asgmtpost_id='".$_SESSION['asgmtpost_id']."'";
        if(mysqli_query($db_con, $query)){ 
            header("Refresh:0");
        }else{
              echo "<script>alert('Unable to execute SQL query');</script>";
        }

    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Course Assignment</title>
    <link rel="icon" href="img/octagon.png" type="image/icon type">

    <!-- bootstrap theme -->
    <link href="css/bootstrap-theme.css" rel="stylesheet">

    <!-- font icon -->
    <link href="css/elegant-icons-style.css" rel="stylesheet" />

    <!-- Custom styles -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/course_whiteboard_style.css" rel="stylesheet">

</head>

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
                    <li style="border-bottom: double">
                        <a href="dashboard.php">
                            <i class=arrow_left_alt style="color: orange;"></i><span style="color: orange; font-weight: 500;">&nbsp Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo "course_main.php?courseID=" .$_SESSION['courseID']; ?>">
                            <i class="icon_book"></i>
                            <span>Course Main</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo "course_whiteboard.php?courseID=" .$_SESSION['courseID']; ?>">
                            <i class="icon_comment"></i>
                            <span>Whiteboard</span>
                        </a>

                    </li>

                    <li  class="active">
                        <a href="<?php echo "course_assignment.php?courseID=" .$_SESSION['courseID']; ?>">
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
        <section id="main-content" style="background: #fffded">
            <section class="wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="page-header"><i class="icon_book"></i><?php echo $_SESSION['course_name'];?></h3> 
                        <ol class="breadcrumb">
                        <li><i class="icon_house"></i><a href="dashboard.php">Home</a></li>
                            <li><i class="icon_book"></i>Course Assignment</li>
                            <li><i class="icon_document_alt"></i>Assignment Post</li>
                        </ol>
                    </div>
                </div>
                <!-- page start-->


                <body>
                     <!-- pop up box-->
                        
                     <div class="overlay" id="modify-post">
                        <div class="popup-box" >
                            <form method="post" action="#">
                                <label for="name" style="text-align: right;font-size:18px;color:blue;">Modify Assignment<span>*</span></label>
                                <div class="item">

                                    <input style = "font-size:16px" id="name" type="text" placeholder="Title" name="title" required/>
                                </div>
                                <div class="item">
                                    <textarea style="height:180px; font-size:16px; resize:none" id="description" type="textarea" placeholder="Type your content here" name="description" required></textarea>
                                </div>
                                <div class="item">

                                    <input style = "font-size:16px" id="startdate" type="text" placeholder="New start date and time" name="startdate" required/>
                                </div>
                                <div class="item">

                                    <input style = "font-size:16px" id="enddate" type="text" placeholder="New end date and time" name="enddate" required/>
                                </div>

                                <div class="btn-block">
                                    <button onclick="closePopUp()">CANCEL</button>
                                    <button style="margin-left: 10px" type="submit" name="submit-modified-post">SUBMIT</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!--end of pop up box-->



                    <!--BACK button-->

                    <button style="margin-left: 20px; width:100px" onclick="location.href='course_assignment.php?courseID=<?php echo $_SESSION['courseID']; ?>'">
                        <img style="float:left;" alt="" src="img/left-arrow_white.png" width="10" height="20">
                        BACK
                    </button>

                    <!--End of BACK button-->


                    <!--Create Comment Button-->

                    <button class="btn-create" style="float:right" onclick="window.scrollTo(0, document.body.scrollHeight); blink('create-comment')">
                        <img style="float:left;" alt="" src="img/create.png" width="25" height="25">
                        COMMENT
                    </button>

                    <!-- End of Create Comment Button-->


                    <!--show post-->
                    <div class="post-box">

                        <!-- modify and delete icon-->
                        <?php 
                            $asgmtpost_title = addslashes($row['asgmtpost_title']);      
                            $asgmtpost_desc = addslashes($row['asgmtpost_desc']);
                            $asgmt_startdate = addslashes($row["asgmt_startdate"]);
                            $asgmt_enddate = addslashes($row["asgmt_enddate"]);

                            if($_SESSION['UserName'] == $row["user_name"]){
                                echo'
                                    <div class="icons" style="float:right; margin-top: 20px;">
                                        <a title="Delete post" onclick="showAlertBox(\'asgmt_post\',\''.$row['asgmtpost_id'].'\',\''.$_SESSION['courseID'].'\', \'0\')">
                                            <img alt="delete" src="img/delete.png" onmouseover="this.src=\'img/delete_dark.png\'" onmouseout="this.src=\'img/delete.png\'"width="20" height="20">
                                        </a>

                                        <a title="Modify post" onclick="showPopUp(\''.$asgmtpost_title.'\',`'.$asgmtpost_desc.'`,`'.$asgmt_startdate.'`,`'.$asgmt_enddate.'`)" style="margin-left: 10px; margin-right: 10px;">
                                            <img alt="edit" src="img/edit.png" onmouseover="this.src=\'img/edit_dark.png\'" onmouseout="this.src=\'img/edit.png\'"width="20" height="20">
                                        </a>
                                    </div>';                        
                            }
                        ?>
                        <!-- end of modify and delete icon-->

                        <!--AUTHOR DETAILS-->
                        <span class="profile-ava">
                            <br>
                            <img style="float:left;" alt="" src="img/user.png" width="40" height="40">
                            <p style="color: inherit; font-size:18px">
                                <b><?php echo "&nbsp&nbsp".$row["user_name"]; ?></b><br>
                                <text style="color: darkgray; font-size: 14px;"><?php echo "&nbsp&nbsp".$row["asgmtpost_date"]; ?></text>
                            </p>
                        </span>

                        <!--title of post-->
                        <h3><b><?php echo $row["asgmtpost_title"]?></b></h3>

                        <!--content of post-->
                        <p style="font-size: 19px; margin-right: 30px; line-height: 1.5; text-align: justify; white-space: pre-line">
                            <?php echo $row["asgmtpost_desc"] ?> <br>
                            <b><?php 
                                echo "Start Date and Time : ";
                            echo $row["asgmt_startdate"] ?></b> 
                            <b><?php 
                                echo "End Date and Time : ";
                            echo $row["asgmt_enddate"] ?></b>
                        
                        </p>

                        <!--file of post, if any-->
                        <?php

                            if($row["asgmtfile_name"]){
                                echo "
                                    <br>
                                    <div class='download-box'>
                                        <a href='courseasgmt_download.php?asgmtpost_id=".$row['asgmtpost_id']."&asgmtfile_name=".$row['asgmtfile_name']."'' courseasgmt_download=''>
                                            <b>".substr($row['asgmtfile_name'], 6)."</b><br>
                                            <text style='text-transform: uppercase; color: darkgray; font-size: 14px'>".$row['asgmtfile_type']."</text>
                                        </a>
                                    </div>";
                            }
                        ?>


                    </div>
                    <!--end of post-->


                    <!--display all comments for this post-->
                    <?php
                       $query = "SELECT * FROM asgmt_post, asgmt_comment, users WHERE asgmt_post.asgmtpost_id='".$row['asgmtpost_id']."' AND asgmt_comment.user_id = users.user_id AND asgmt_post.asgmtpost_id = asgmt_comment.asgmtpost_id ORDER BY asgmtcomment_date ASC";

                        if($result = mysqli_query($db_con, $query)){   //if have result returned
                            while($row = mysqli_fetch_assoc($result)){
                                                                    
                                echo'<div class=post-box>';

                                /*Delete icon*/
                                if($_SESSION['UserName'] == $row["user_name"]){
                                    echo'
                                        <div class="icons" style="float:right; margin-top: 20px;">
                                            <a onclick="showAlertBox(\'asgmt_comment\',\''.$row['asgmtpost_id'].'\',\'0\',\''.$row['asgmtcomment_id'].'\')" title="Delete comment" style="margin-right: 10px;">
                                                <img alt="delete" src="img/delete.png" onmouseover="this.src=\'img/delete_dark.png\'" onmouseout="this.src=\'img/delete.png\'"width="20" height="20">
                                            </a>
                                        </div>';                             
                                }

                                /*comment*/
                                echo'   
                                        <br>
                                        <img style="float:left;" alt="" src="img/user.png" width="40" height="40">
                                        <p style="color: inherit; font-size:18px">
                                            <b>&nbsp&nbsp'.$row["user_name"].'</b><br>
                                            <text style="color: darkgray; font-size: 14px;">&nbsp&nbsp'.$row["asgmtcomment_date"].'</text>
                                        </p>
                                        <br>
                                        <p style="font-size: 20px; margin-right: 30px; line-height: 1.5; text-align: justify; white-space: pre-line"">'.$row["asgmtcomment_msg"].'<br></p>
                                    </div>';
                            }
                        }
                    ?>
                    <!--end of comments-->

                    <!--create comment box-->
                    <div class="create-box" id="create-comment">

                        <form method="post" action="#">
                            <label for="name" style="text-align: right;font-size:18px;color:blue;">Comment<span>*</span></label>
                            <div class="item">
                                <textarea style="height:180px; font-size:16px; resize:none" id="comment" type="textarea" placeholder="Write a comment..." name="asgmt_comment" required></textarea>
                            </div>

                            <div class="btn-block">
                                <button type="reset">Cancel</button>
                                <button style="margin-left: 10px" type="submit" name="submit-asgmt_comment">SUBMIT</button>
                            </div>
                        </form>
                    </div>
                </body>


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
        function blink(id){
            var target = document.getElementById(id);
            target.classList.add("blink");
            setTimeout(function(){
                target.classList.remove("blink");
            }, 1000);
        }

        function showAlertBox(item, asgmtpost_id, courseID, asgmtcomment_id){
            var ans = window.confirm("Are you sure you want to delete this "+item+"?");
            if(ans){
                switch(item){
                    case "asgmt_post":
                        location.href="courseasgmt_delete.php?asgmtpost_id="+asgmtpost_id+"&courseID="+courseID;
                        break;

                    case "asgmt_comment":
                        location.href="courseasgmt_delete.php?asgmtcomment_id="+asgmtcomment_id+"&asgmtpost_id="+asgmtpost_id;
                        break;
                }   
            }
        }

        function showPopUp(asgmtpost_title, asgmtpost_desc,asgmt_startdate,asgmt_enddate ){
            document.getElementById("modify-post").style.display = "block";
            document.getElementById("name").value = asgmtpost_title;
            document.getElementById("description").value = asgmtpost_desc;
            document.getElementById("startdate").value = asgmt_startdate;
            document.getElementById("enddate").value = asgmt_enddate;

        }

        function closePopUp(){
            document.getElementById("modify-post").style.display="none";
        }
        </script>
</body>
</html>