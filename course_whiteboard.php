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

    //get whiteboard ID
    $query = "SELECT * FROM whiteboard, course WHERE whiteboard.course_id = course.course_id AND whiteboard.course_id = '".$_SESSION['courseID']."'";  
    if($result = mysqli_query($db_con, $query)){  //if query successful
        $rowcount = mysqli_num_rows($result);

        if($rowcount > 0)  //if whiteboard exists
            $row = mysqli_fetch_assoc($result);
        else
            header("Location: whiteboard.php");
    } 
    else{
        echo '<script>alert("ERROR: Unable to execute SQL query. ")</script>';
    }

    $_SESSION['whiteboard_id'] = $row['whiteboard_id'];
    $_SESSION['course_name'] = $row['course_name'];

    if(isset($_POST["submit-post"])){   //if submit button is clicked
        $date = date("Y-m-d H:i:s", time()); 
        $title = addslashes($_POST["title"]);    //store submitted value in variable
        $descr = addslashes($_POST['description']);

        //post_id format follows the whiteboard_id
        //e.g. if whiteboard_id is 'W0001', post_id starts with 'P1'
        $query = "SELECT RIGHT (post_id, 3) AS post_id FROM post WHERE whiteboard_id='".$_SESSION['whiteboard_id']."' ORDER BY post_id DESC";
        if($result=mysqli_query($db_con, $query))
            $row = mysqli_fetch_assoc($result);
        else
            echo '<script>alert("ERROR: Unable to execute SQL query. ")</script>';

        if($row['post_id'] == ""){
            $row['post_id'] = '000';
        }
        $post_id = "P".substr($_SESSION['whiteboard_id'], -1).$row['post_id'];
        $post_id++;

        //name of uploaded file
        $filename = $post_id."_".$_FILES['upload-file']['name'];

        if(!$_FILES['upload-file']['name']){
             $query = "INSERT INTO post (post_id, post_title, post_content, post_date, user_id, whiteboard_id) 
                    VALUES ('$post_id', '$title', '$descr', '$date', '".$_SESSION['UserId']."', '".$_SESSION['whiteboard_id']." ')";
            if(!mysqli_query($db_con, $query)) 
                echo "Error: ".$query."<br>".mysqli_error($db_con);
        } else{
            //save files to server (in project folder)
            $destination = 'uploads/'.$filename;

            //get file extension
            $extension = pathinfo($filename, PATHINFO_EXTENSION);

            $file = $_FILES['upload-file']['tmp_name'];
            $size = $_FILES['upload-file']['size'];

            // move the uploaded (temporary) file to the specified destination
            if (move_uploaded_file($file, $destination)) {
                $query = "INSERT INTO post (post_id, post_title, post_content, post_date, user_id, whiteboard_id, file_name, file_size, file_type) 
                    VALUES ('$post_id', '$title', '$descr', '$date', '".$_SESSION['UserId']."', '".$_SESSION['whiteboard_id']."', '$filename', '$size', '$extension')";
                if(!mysqli_query($db_con, $query)){ 
                    echo '<script>alert("ERROR: Unable to execute SQL query. ")</script>';
                }
            } else {
                echo '<script>alert("Failed to upload file.")</script>';
            }  
        }     
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Course Whiteboard</title>
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
                    <li class="active">
                        <a href="#">
                            <i class="icon_comment"></i>
                            <span>Whiteboard</span>
                        </a>

                    </li>

                    <li>
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
                            <li><i class="icon_book"></i>Course Whiteboard</a></li>
                        </ol>
                    </div>
                </div>
                 
                <!-- page start-->


                <body>
                    <!--Create Post Button-->
                    <div style="text-align: right">
                        <button class="btn-create" onclick="window.scrollTo(0, document.body.scrollHeight); blink('create-post');">
                            <img style="float:left;" alt="" src="img/create.png" width="25" height="25">
                            CREATE POST
                        </button>
                    </div>

                    <!--End of Create Post Button-->


                    <!--All post for current whiteboard-->

                    <?php
                        $query = "SELECT * FROM post, users WHERE whiteboard_id='".$_SESSION['whiteboard_id']."' AND post.user_id = users.user_id ORDER BY post_date DESC";
                        if($result = mysqli_query($db_con, $query)){  //if query successful  
                            $rowcount = mysqli_num_rows($result);

                            if($rowcount > 0){  //if there is results returned
                                while($row = mysqli_fetch_assoc($result)){
                                    echo '
                                        <div class=post-box>
                                            <a style="display:block;" href="course_post.php?post_id='.$row["post_id"].'">
                                                <h3 class="post-title"><b>'.$row["post_title"].'</b></h3><br>
                                                <p style="color: darkgray;">
                                                    Posted by <b>'.$row["user_name"].'</b> on '.$row["post_date"].'
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


                    <!-- Create Post Box-->

                    <div class="create-box" id="create-post">
                        <form method="post" action="#" enctype="multipart/form-data">  <!--enctype is needed for file upload-->
                            <label for="name" style="text-align: right; font-size:18px; color:blue;">Write Post<span>*</span></label>
                            <div class="item">
                                <input style = "font-size:16px" id="name" type="text" placeholder="Title*" name="title" required/>
                            </div>
                            <div class="item">
                                <textarea style="height:180px; font-size:16px; resize:none" id="description" type="textarea" placeholder="Type your content here*" name="description" required></textarea>
                            </div>
                            <div class="item">
                                <label for="upload-file" style="font-size: 16px; font-weight: 400;">Select a file:</label>
                                <input type="file" id="upload-file" name="upload-file"><br>
                            </div>
                            <div class="btn-block">
                                <button type="reset">CANCEL</button>
                                <button style="margin-left: 10px" type="submit" name="submit-post">SUBMIT</button>
                            </div>
                        </form>
                    </div>

                    <!--End of New Post Box-->


                </body>

                <!-- page end-->
            </section>
        </section>
        <!--main content end-->
    </section>
    <!-- container section end -->
    <!-- javascripts -->
    
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <!--custome script for all page-->
    <script src="js/scripts.js"></script>


</body>

</html>