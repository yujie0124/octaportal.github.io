<?php 
    session_start();
    require_once "db_con.php";

     //if not logged in
 if (!$_SESSION['UserName']){
    header("Location: index.html");
}

    $userid = $_SESSION['UserId'];

    function function_alert($message) { 
        // Display the alert box  
        echo "<script>alert('$message');</script>"; 
    } 
      
    if (isset($_POST['save'])) {
        $name = $_POST['username'];
        $bio = $_POST['bio'];
        $country = $_POST['country'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $website = $_POST['website'];

        $query = "UPDATE users SET user_name = '$name', user_bio = '$bio', user_country = '$country', user_email = '$email', user_phone = '$phone', user_website = '$website' WHERE user_id='$userid' ";
        mysqli_query($db_con,$query);
        function_alert("Profile Updated Successfully !");
    }

    $query = "SELECT * FROM users WHERE user_id='$userid'"; 
    $result = mysqli_query($db_con, $query);

    $row = mysqli_fetch_array($result); 


    if(isset($_POST["CHANGEP"]))
{

                $currentPassword = mysqli_real_escape_string($db_con, $_REQUEST['currentPassword']);
                $newPassword = mysqli_real_escape_string($db_con, $_REQUEST['newPassword']);
                $confirmPassword = mysqli_real_escape_string($db_con, $_REQUEST['confirmPassword']);

                if(!($currentPassword == $row['user_password'])){
                     echo '<script>alert("Current Password is not correct. Please try again.")</script>';
                }
                elseif(!($newPassword==$confirmPassword)){
                    echo '<script>alert("New Password is not matched with your re-enter password. Please try again.")</script>';
                }
                else{

                     $sql = "UPDATE users SET user_password = '$confirmPassword' WHERE user_id='$userid' ";
                    $result = mysqli_query($db_con, $sql);
                
                     if(mysqli_affected_rows ($db_con) == 0) {
                         echo '<script>alert("We are sorry, internal error occur. Your password is not updated.")</script>';
                     }
                    elseif($result){
                            print('<script>alert("Your password is updated successfully.")</script>');
                       
                     } 
                    else{
                        echo "ERROR: Unable to execute $sql " . mysqli_error($db_con);
                    }

                }
               

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <link rel="shortcut icon" href="img/favicon.png">
    <title>Profile</title>
    <link rel="icon" href="img/octagon.png" type="image/icon type">

    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet"> 
    <!-- bootstrap theme -->
    <link href="css/bootstrap-theme.css" rel="stylesheet">
    <!--external css-->
    <!-- font icon -->
    <link href="css/elegant-icons-style.css" rel="stylesheet" />
    <link href="css/font-awesome.min.css" rel="stylesheet" />
    <!-- Custom styles -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />

    <script type="text/javascript">
        function changepass() {
            document.getElementById("change").style.display = "block";
        }

        function closeDForm() {
            document.getElementById("change").style.display = "none";
        }
    </script>


    <style>
        * {
            box-sizing: border-box;
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
    <section id="container" class="">
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
<div id="sidebar" class="nav-collapse ">
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
        <li>
            <a href="whiteboard.php">
                <i class="icon_comment"></i>
                <span>Whiteboard</span>
            </a>

        </li>

        <li class="active">
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
                        <h3 class="page-header"><i class="icon_profile"></i> Profile</h3>
                        <ol class="breadcrumb">
                            <li><i class="icon_house"></i><a href="dashboard.php">Home</a></li>
                            <li><i class="icon_documents_alt"></i>Profile</li>

                        </ol>
                    </div>
                </div>
                <div class="row">
                    <!-- profile-widget -->
                    <div class="col-lg-12">
                        <div class="profile-widget profile-widget-info">
                            <div class="panel-body">
                                <div class="col-lg-2 col-sm-2">
                                    <div class="follow-ava">
                                        <img src="img/default-profile.jpg" alt="">
                                    </div>
                                    <h5><?php echo $row['user_name'];?></h5>
                                </div>
                                <div class="col-lg-4 col-sm-4 follow-info">                         
                                    <p><span><i class="icon_cloud_alt"></i>&nbsp;&nbsp<?php echo  $row['user_website'];?></span></p>  
                                    <p><span><i class="icon_id"></i>&nbsp;&nbspLecturer</span></p>  
                                    <p><span><i class="icon_house_alt"></i>&nbsp;&nbsp<?php echo $row['user_country'];?></span></p>  
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- page start-->
                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading tab-bg-info">
                                <ul class="nav nav-tabs">
                                    <li>
                                        <a data-toggle="tab" href="#profile">
                                            <i class="icon_folder"></i> Profile
                                        </a>
                                    </li>
                                    <li class="">
                                        <a data-toggle="tab" href="#edit-profile">
                                            <i class="icon_pencil-edit"></i> Edit Profile
                                        </a>
                                    </li>
                                </ul>
                            </header>
                            <div class="panel-body">
                                <div class="tab-content">
                                    <!-- profile -->

                                    <div id="profile" class="tab-pane active">
                                        <section class="panel">
                                            <div class="bio-graph-heading">
                                            <?php echo $row['user_bio'];?>
                                            </div>
                                            <div class="panel-body bio-graph-info">
                                                <h1>Bio Graph &nbsp;&nbsp;<i class="icon_folder-open"></i></h1>
                                                <div class="row">
                                                    <div class="bio-row">
                                                        <p><i class="icon_profile">&nbsp;&nbsp;</i>Name  &nbsp;    : <?php echo $row['user_name'];?> </p>
                                                    </div>
                                                    <div class="bio-row">
                                                        <p><i class="icon_house">&nbsp;&nbsp;</i>Country &nbsp;  : <?php echo $row['user_country'];?></p>
                                                    </div>
                                                    <div class="bio-row">
                                                        <p><i class="icon_mail">&nbsp;&nbsp;</i>Email   &nbsp;   : <?php echo $row['user_email'];?></p>
                                                    </div>
                                                    <div class="bio-row">
                                                        <p><i class="icon_phone">&nbsp;&nbsp;</i>Contact  &nbsp;  : <?php echo $row['user_phone'];?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                        <section>
                                            <div class="row">
                                            </div>
                                        </section>
                                    </div>
                                    <!-- edit-profile -->

                                     <div class="addPopup2">
                    <div class="formPopup" id="change">
                        <form action="profile.php" method="POST" class="formContainer">
                            <h2 style="font-weight: 600;">Change Your Password</h2>
                            <label for="currentPassword">
                                <strong>Current Password</strong>
                              </label>
                            <input type="password" name="currentPassword" id="currentPassword"  required>

                            <label for="newPassword">
                              <strong>New Password</strong>
                            </label>
                            <input type="password" name="newPassword" id="newPassword" required>

                            <label for="confirmPassword">
                              <strong>Confirm Password</strong>
                            </label>
                            <input type="password" name="confirmPassword" id="confirmPassword" required>

                            <input type="submit" class="btn" value="Change" name="CHANGEP"></input>
                            <button type="button" class="btn cancel" onclick="closeDForm()">Cancel</button>
                        </form>
                    </div>
                </div>

                                    <div id="edit-profile" class="tab-pane">
                                        <section class="panel">

                                            <div class="panel-body bio-graph-info">
                                                <h1> Profile Info</h1>
                                                <form class="form-horizontal" role="form" action="profile.php" method="POST">
                                                    <div class="form-group">
                                                        <label class="col-lg-2 control-label">Name</label>
                                                        <div class="col-lg-10">
                                                            <input type="text" class="form-control" id="f-name" value="<?php echo $row['user_name'];?>" name="username">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-2 control-label">About Me</label>
                                                        <div class="col-lg-10">
                                                            <!--<textarea name="bio" id="" class="form-control" cols="30" rows="5" value="<?php echo $row['user_bio'];?>" ></textarea>-->
                                                            <input type="text" class="form-control" id="bio" value="<?php echo $row['user_bio'];?>" name="bio">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-2 control-label">Country</label>
                                                        <div class="col-lg-10">
                                                            <input type="text" class="form-control" id="c-name" value="<?php echo $row['user_country'];?>" name="country">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-2 control-label">Email</label>
                                                        <div class="col-lg-10">
                                                            <input type="text" class="form-control" id="email" value="<?php echo $row['user_email'];?>" name="email">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-2 control-label">Phone</label>
                                                        <div class="col-lg-10">
                                                            <input type="text" class="form-control" id="phone" value="<?php echo $row['user_phone'];?>" name="phone">
                                                        </div>
                                                    </div>
                                                     <div class="form-group">
                                                        <label class="col-lg-2 control-label">Password</label>
                                                        <div class="col-lg-10">
                                                             <a class="btn btn-danger" onclick="changepass()" title="Change Password">
                                                             Change Password </a>
                                                            <!--<input type="text" class="form-control" id="password" value="<?php echo $row['user_password'];?>" name="password">-->
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-2 control-label">Website URL</label>
                                                        <div class="col-lg-10">
                                                            <input type="text" class="form-control" id="url" value="<?php echo $row['user_website'];?>" name="website">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-lg-offset-2 col-lg-10">
                                                            <button name="save" value="Update Profile" type="submit" class="button btn-create">Update Profile</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>

                <!-- page end-->
            </section>
        </section>
        <!--main content end-->

    </section>
    <!-- container section end -->
    <!-- javascripts -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
    
    <!--custome script for all page-->
    <script src="js/scripts.js"></script>

    <script>
        //knob
        $(".knob").knob();
    </script>


</body>

</html>