<?php 
    session_start();
    require_once "db_con.php";

     //if not logged in
     if (!$_SESSION['UserName']){
        header("Location: index.html");
    }


    if(isset($_POST['submit'])){
        $userid = $_SESSION["UserId"];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];

        $query = "INSERT INTO contact (name, email, subject, message, user_id) VALUES('$name','$email','$subject','$message','$userid')";
        if(mysqli_query($db_con,$query)){
            echo '<script>alert("Your feedback has been sent to us successfully. Thank you very much for your feedback")</script>';
        };
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Contact Us</title>
    <link rel="icon" href="img/octagon.png" type="image/icon type">

    <!-- bootstrap theme -->
    <link href="css/bootstrap-theme.css" rel="stylesheet">

    <!-- font icon -->
    <link href="css/elegant-icons-style.css" rel="stylesheet" />

    <!-- Custom styles -->
    <link href="css/style.css" rel="stylesheet">

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

        <li class="active">
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
                        <h3 class="page-header"><i class="icon_phone"></i> Contact Us</h3>
                        <ol class="breadcrumb">
                            <li><i class="icon_house"></i><a href="dashboard.php">Home</a></li>
                            <li><i class="icon_contacts_alt"></i>Contact</li>
                        </ol>
                    </div>
                </div>
                <!-- page start-->
                <div class="row">
                    <div class="col-lg-6">
                        <div class="recent">
                            <h3>Send us a message&nbsp;&nbsp;<i class="icon_chat"></i></h3>
                        </div>
                        <div id="sendmessage">Your message has been sent. Thank you!</div>
                        <div id="errormessage"></div>
                        <form action="contact.php" method="post" role="form" class="contactForm">
                            <h4 style="color: darkgray; margin-top: 20px;"><?php echo "Logged in as: "?>
                                <text style="color: orange;"><?php echo $_SESSION["UserName"]." (ID: ".$_SESSION["UserId"].")"  ?></text>
                            </h4>
                            <div class="form-group">
                                <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" data-rule="minlen:4" data-msg="Please enter at least 4 chars" required/>
                                <div class="validation"></div>
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" data-rule="email" data-msg="Please enter a valid email" required/>
                                <div class="validation"></div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" data-rule="minlen:4" data-msg="Please enter at least 8 chars of subject" required/>
                                <div class="validation"></div>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" style="resize:none" name="message" rows="5" data-rule="required" data-msg="Please write something for us" placeholder="Message" required></textarea>
                                <div class="validation"></div>
                            </div>

                            <div class="text-center">
                                <button type="submit" value=Send name="submit" class="btn-create">Send Message</button>
                            </div>
                        </form>
                    </div>

                    <div class="col-lg-6">
                        <div class="recent">
                            <h3>We'd love to hear from you!</h3>
                        </div>
                        <div>
                            <p>
                                Feel free to send us message. <br>
                                We will review on your feedback for further improvement of our system. <br>
                                Thank you very much.
                            </p>

                            <br><h4>Address:</h4>
                                Multimedia University, <br>
                                Jalan Ayer Keroh Lama,<br>
                                75450 Melaka,<br>
                                Malacca.<br><br>
                            <h4>Telephone:</h4>012-3456789<br><br>
                            <h4>Fax:</h4>06-3456789
                        </div>
                    </div>
                </div>
                <!-- page end-->
            </section>
        </section>
        <!--main content end-->

    </section>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <script>
        //knob
        $(".knob").knob();
    </script>


</body>

</html>