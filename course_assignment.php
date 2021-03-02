<?php
    session_start();
    require_once "db_con.php";
    date_default_timezone_set('Asia/Kuala_Lumpur');
    
    //if not logged in
    if (!$_SESSION['UserName']){
        header("Location: index.html");
    }
    //if courseID not set
    else if(!$_GET['courseID']){
        header("Location: whiteboard.php");
    }

    $_SESSION['courseID'] = $_GET['courseID'];

    //get assignment ID
    $query = "SELECT * FROM assignment, course WHERE assignment.course_id = course.course_id AND assignment.course_id = '".$_SESSION['courseID']."'";  
    if($result = mysqli_query($db_con, $query)){  
        $rowcount = mysqli_num_rows($result);

        if($rowcount > 0)  
            $row = mysqli_fetch_assoc($result);
            
        else
            header("Location: whiteboard.php");
    } else{
         echo "<script>alert('Unable to execute SQL query');</script>";
    }

    $_SESSION['assignment_id'] = $row['assignment_id'];
    $_SESSION['course_name'] = $row['course_name'];

    if(isset($_POST["submit-post"])){   //if submit button is clicked
        $date = date("Y-m-d H:i:s", time()); 
        $title = addslashes($_POST["title"]);    //store submitted value in variable
        $desc = addslashes($_POST['description']);
        $startdate = addslashes($_POST["asgmt_startdate"]);
        $enddate = addslashes($_POST["asgmt_enddate"]);

        $query = "SELECT RIGHT (asgmtpost_id, 3) AS asgmtpost_id FROM asgmt_post WHERE assignment_id='".$_SESSION['assignment_id']."' ORDER BY asgmtpost_id DESC";
        if($result=mysqli_query($db_con, $query))
            $row = mysqli_fetch_assoc($result);
        else
             echo "<script>alert('Unable to execute SQL query');</script>";

        if($row['asgmtpost_id'] == ""){
            $row['asgmtpost_id'] = '000';
        }
        $asgmtpost_id = "A".substr($_SESSION['assignment_id'], -1).$row['asgmtpost_id'];
        $asgmtpost_id++;

        //name of uploaded file
        $filename = $asgmtpost_id."_".$_FILES['upload-file']['name'];

        if(!$_FILES['upload-file']['name']){
             $query = "INSERT INTO asgmt_post (asgmtpost_id, asgmtpost_title, asgmtpost_desc, asgmtpost_date, asgmt_startdate, asgmt_enddate, user_id, assignment_id) 
                    VALUES ('$asgmtpost_id', '$title', '$desc', '$date', '$startdate', '$enddate', '".$_SESSION['UserId']."', '".$_SESSION['assignment_id']."')";
            if(!mysqli_query($db_con, $query)) 
                 echo "<script>alert('Unable to execute SQL query');</script>";
        } else{
            //save files to server (in project folder)
            $destination = 'uploads/'.$filename;

            //get file extension
            $extension = pathinfo($filename, PATHINFO_EXTENSION);

            $file = $_FILES['upload-file']['tmp_name'];
            $size = $_FILES['upload-file']['size'];

            // move the uploaded (temporary) file to the specified destination
            if (move_uploaded_file($file, $destination)) {
                $query = "INSERT INTO asgmt_post (asgmtpost_id, asgmtpost_title, asgmtpost_desc, asgmtpost_date, asgmt_startdate, asgmt_enddate, user_id, assignment_id, asgmtfile_name, asgmtfile_size, asgmtfile_type) 
                    VALUES ('$asgmtpost_id', '$title', '$desc', '$date', '$startdate', '$enddate', '".$_SESSION['UserId']."', '".$_SESSION['assignment_id']."', '$filename', '$size', '$extension')";
                if(!mysqli_query($db_con, $query)){ 
                     echo "<script>alert('Unable to execute SQL query');</script>";
                }
            } else {
                echo "Failed to upload file.";
            }  
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
    <!--external css-->
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
                        <a href="#">
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
                            <li><i class="icon_book"></i>Course Assignment</a></li>
                        </ol>
                    </div>
                </div>
                 
                <!-- page start-->


                <body>
                    <!--Create Assignment Button-->
                    <div style="text-align: right">
                        <button class="btn-create" onclick="window.scrollTo(0, document.body.scrollHeight); blink('create-post');">
                            <img style="float:left;" alt="" src="img/create.png" width="25" height="25">
                            CREATE POST
                        </button>
                    </div>
                    <!--End of Create Assignment Button-->

                    <!--All assignments-->

                     <?php
                        $query = "SELECT * FROM asgmt_post, users WHERE assignment_id='".$_SESSION['assignment_id']."' AND asgmt_post.user_id = users.user_id ORDER BY asgmtpost_date DESC";
                        if($result = mysqli_query($db_con, $query)){  //if query successful  
                            $rowcount = mysqli_num_rows($result);

                            if($rowcount > 0){  //if there is results returned
                                while($row = mysqli_fetch_assoc($result)){
                                    echo '
                                        <div class=post-box>
                                            <a style="display:block;" href="courseasgmt_post.php?asgmtpost_id='.$row["asgmtpost_id"].'">
                                                <h3 class="asgmt-title"><b>'.$row["asgmtpost_title"].'</b></h3><br>
                                                <p style="color: darkgray;">
                                                    Posted by <b>'.$row["user_name"].'</b> on '.$row["asgmtpost_date"].'
                                                </p>
                                            </a>
                                        </div>';
                                }
                            } 

                            else{
                                echo '
                                    <div class=post-box>
                                        <br><text style="font-size: 18px">No posts in this whiteboard yet...</text><br><br>
                                    </div>';
                            }
                        } 
                            
                    ?>
            
                    <!-- End of All Post-->


                    <!-- Create Assignment Box-->
                    <div class="create-box" id="create-post">
                        <form method="post" action="#" enctype="multipart/form-data">  <!--enctype is needed for file upload-->
                            <div class="item">
                                <label for="name" style="font-size: 16px; font-weight: 400;">Title</label>
                                <input style = "font-size:16px" id="name" type="text" name="title" required/>
                            </div>
                            <div class="item">
                                <label for="description" style="font-size: 16px; font-weight: 400;">Description</label>
                                <textarea style="height:180px; font-size:16px; resize:none" id="description" type="textarea" name="description" required></textarea>
                            </div>
                            <div class="item">
                                <label for="bdate" style="font-size: 16px; font-weight: 400;">Start Date and Time [yyyy/mm/dd 00:00:00]</label>
                                <input style = "font-size:16px" id="startdate" type="text" name="asgmt_startdate" required/>
                                
                            </div>
                            <div class="item">
                                <label for="bdate" style="font-size: 16px; font-weight: 400;">End Date and Time [yyyy/mm/dd 00:00:00] </label>
                                <input style = "font-size:16px" id="enddate" type="text" name="asgmt_enddate" required/>
                                
                            </div>
                            <div class="item">
                                <label for="upload-file" style="font-size: 16px; font-weight: 400;">Attachment</label>
                                <input type="file" id="upload-file" name="upload-file"><br>
                            </div>
                            <div class="btn-block">
                                <button type="reset">CANCEL</button>
                                <button style="margin-left: 10px" type="submit" name="submit-post">SUBMIT</button>
                            </div>
                        </form>
                    </div>
                    <!--End of Create Assignment Box-->


                </body>

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