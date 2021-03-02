<?php
    session_start();
    require_once "db_con.php";
    date_default_timezone_set('Asia/Kuala_Lumpur');

    //if not logged in
    if (!$_SESSION['UserName']){
        header("Location: index.html");
    }else if(!$_GET['post_id']){
        header("Location: whiteboard.php");
    }

    //get current post_id
    $_SESSION['post_id'] = $_GET['post_id'];

    //get all details of current post (author, whiteboard_id, etc.)
    $query = "SELECT * FROM post, users, course, whiteboard 
                WHERE post.whiteboard_id=whiteboard.whiteboard_id AND whiteboard.course_id=course.course_id 
                    AND post.user_id=users.user_id AND post_id='".$_SESSION['post_id']."'";

    if($result=mysqli_query($db_con, $query)){ 
        $rowcount = mysqli_num_rows($result);

        if($rowcount > 0)  //if post exists
            $row = mysqli_fetch_assoc($result);
        else
            header("Location: whiteboard.php");
    } else{
        //echo '<script>alert("ERROR: Unable to execute SQL query. ")</script>';
    }

    if(isset($_POST["submit-comment"])){   //if submit button is pressed
        $comment = addslashes($_POST['comment']);
        $date = date("Y-m-d H:i:s", time());
        $post_id = $row['post_id'];
        $whiteboard_id = $row['whiteboard_id'];

        $query = "INSERT INTO comment (comment_msg, comment_date, user_id, post_id, whiteboard_id) VALUES('$comment', '$date', '".$_SESSION['UserId']."', '$post_id', '$whiteboard_id')";
        if(!mysqli_query($db_con, $query)){ 
           // echo '<script>alert("ERROR: Unable to execute SQL query. ")</script>';
        }
    }

    if(isset($_POST["submit-modified-post"])){
        $title = addslashes($_POST['title']);
        $description = addslashes($_POST['description']);

        $query = "UPDATE post SET post_title='$title', post_content='$description' WHERE post_id='".$_SESSION['post_id']."'";
        if(mysqli_query($db_con, $query)){ 
            header("Refresh:0");
        }else{
           //echo '<script>alert("ERROR: Unable to execute SQL query. ")</script>';
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
                    <li class="active">
                        <a href="<?php echo "course_whiteboard.php?courseID=" .$_SESSION['courseID']; ?>">
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
                            <li><i class="icon_book"></i>Course Whiteboard</li>
                            <li><i class="icon_document_alt"></i>Whiteboard Post</a></li>
                        </ol>
                    </div>
                </div>
                <!-- page start-->


                <body>
                    <!-- pop up box-->
                        
                    <div class="overlay" id="modify-post">
                        <div class="popup-box" >
                            <form method="post" action="#">
                                <label for="name" style="text-align: right;font-size:18px;color:blue;">Modify Post<span>*</span></label>
                                <div class="item">

                                    <input style = "font-size:16px" id="name" type="text" placeholder="Title" name="title" required/>
                                </div>
                                <div class="item">
                                    <textarea style="height:180px; font-size:16px; resize:none" id="description" type="textarea" placeholder="Type your content here" name="description" required></textarea>
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

                    <button style="margin-left: 20px; width:100px" onclick="location.href='course_whiteboard.php?courseID=<?php echo $_SESSION['courseID']; ?>'">
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
                            $post_title = addslashes($row['post_title']);      //content may contain ' or " etc. that may cause error
                            $post_content = addslashes($row['post_content']);

                            if($_SESSION['UserName'] == $row["user_name"]){
                                echo'
                                    <div class="icons" style="float:right; margin-top: 20px;">
                                        <a title="Delete post" onclick="showAlertBox(\'post\',\''.$row['post_id'].'\',\''.$_SESSION['courseID'].'\', \'0\')">
                                            <img alt="delete" src="img/delete.png" onmouseover="this.src=\'img/delete_dark.png\'" onmouseout="this.src=\'img/delete.png\'"width="20" height="20">
                                        </a>

                                        <a title="Modify post" onclick="showPopUp(\''.$post_title.'\',`'.$post_content.'`)" style="margin-left: 10px; margin-right: 10px;">
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
                                <text style="color: darkgray; font-size: 14px;"><?php echo "&nbsp&nbsp".$row["post_date"]; ?></text>
                            </p>
                        </span>

                        <!--title of post-->
                        <h3><b><?php echo $row["post_title"]?></b></h3>

                        <!--content of post-->
                        <p style="font-size: 20px; margin-right: 30px; line-height: 1.5; text-align: justify; white-space: pre-line">
                            <?php echo $row["post_content"] ?>
                        </p> 

                        <!--file of post, if any-->
                        <?php

                            if($row["file_name"]){
                                echo "
                                    <br>
                                    <div class='download-box'>
                                        <a href='download.php?post_id=".$row['post_id']."&file_name=".$row['file_name']."'' download=''>
                                            <b>".substr($row['file_name'], 6)."</b><br>
                                            <text style='text-transform: uppercase; color: darkgray; font-size: 14px'>".$row['file_type']."</text>
                                        </a>
                                    </div>";
                            }
                        ?>


                    </div>
                    <!--end of post-->


                    <!--display all comments for this post-->
                    <?php
                        $query = "SELECT * FROM post, comment, users WHERE post.post_id='".$row['post_id']."' AND comment.user_id = users.user_id AND post.post_id = comment.post_id ORDER BY comment_date ASC";

                        if($result = mysqli_query($db_con, $query)){   //if have result returned
                            while($row = mysqli_fetch_assoc($result)){
                                                                    
                                echo'<div class=post-box>';

                                /*Delete icon*/
                                if($_SESSION['UserName'] == $row["user_name"]){
                                    echo'
                                        <div class="icons" style="float:right; margin-top: 20px;">
                                            <a onclick="showAlertBox(\'comment\',\''.$row['post_id'].'\',\'0\',\''.$row['comment_id'].'\')" title="Delete comment" style="margin-right: 10px;">
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
                                            <text style="color: darkgray; font-size: 14px;">&nbsp&nbsp'.$row["comment_date"].'</text>
                                        </p>
                                        <br>
                                        <p style="font-size: 20px; margin-right: 30px; line-height: 1.5; text-align: justify; white-space: pre-line"">'.$row["comment_msg"].'<br></p>
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
                                <textarea style="height:180px; font-size:16px; resize:none" id="comment" type="textarea" placeholder="Write a comment..." name="comment" required></textarea>
                            </div>

                            <div class="btn-block">
                                <button type="reset">Cancel</button>
                                <button style="margin-left: 10px" type="submit" name="submit-comment">SUBMIT</button>
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
    <script>
        function blink(id){
    var target = document.getElementById(id);
    target.classList.add("blink");
    setTimeout(function(){
        target.classList.remove("blink");
    }, 1000);
}

 function showAlertBox(item, post_id, courseID, comment_id){
    var ans = window.confirm("Are you sure you want to delete this "+item+"?");
    if(ans){
        switch(item){
            case "post":
                location.href="delete.php?post_id="+post_id+"&courseID="+courseID;
                break;

            case "comment":
                location.href="delete.php?comment_id="+comment_id+"&post_id="+post_id;
                break;
        }   
    }
}

function showPopUp(post_title, post_content){
    document.getElementById("modify-post").style.display = "block";
    document.getElementById("name").value = post_title;
    document.getElementById("description").value = post_content;
}

function closePopUp(){
    document.getElementById("modify-post").style.display="none";
}
        </script>
    
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!--custome script for all page-->
    <script src="js/scripts.js"></script>


</body>

</html>