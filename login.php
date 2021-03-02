<?php
session_start();
require_once "db_con.php";
$message = "";

if(isset($_POST["btnLogin"]))
{
    $userid=$_POST["userid"];
    $password=$_POST["password"];

	$query = "SELECT * FROM users WHERE user_id='$userid' AND user_password='$password'"; 
    $result = mysqli_query($db_con, $query);

              if(mysqli_num_rows($result) > 0){
                     while($row = mysqli_fetch_assoc($result)){
                            if($row["user_level"] == "Admin"){
                                    $_SESSION['UserLevel'] = $row["user_level"];
                                   $_SESSION['UserName'] = $row["user_name"];
                                   $_SESSION['UserId'] = $row["user_id"];
                                   header("Location: admin_dashboard.php");
                            }
                            else{
                                   $_SESSION['UserName'] = $row["user_name"];
                                   $_SESSION['UserId'] = $row["user_id"];
                                   header("Location: dashboard.php");
                            }
                     }
              }else{
                     $message="Invalid Username or Password!";
              }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Login</title>
    <link rel="icon" href="img/octagon.png" type="image/icon type">

  <!-- bootstrap theme -->
  <link href="css/bootstrap-theme.css" rel="stylesheet">
  <!--external css-->
  <!-- font icon -->
  <link href="css/elegant-icons-style.css" rel="stylesheet" />

  <!-- Custom styles -->
  <link href="css/style.css" rel="stylesheet">

</head>

<body class="login-img3-body">

    <div class="container">

        <!--header start-->
        <header class="header dark-bg" style="border-bottom: none;">

            <!--logo start-->
            <img id="octa_logo" src="img/octagon_white.png" alt="Octa Logo">
            <a href="index.html" class="logo">Octa <span class="lite">Learning Portal</span></a>
            <!--logo end-->

        </header>
        <!--header end-->

        <form class="login-form" action="login.php" method="POST">
            <div class="login-wrap">
                <p class="login-img"><i class="icon_lock_alt"></i></p>

                <div class="input-group">
                    <span class="input-group-addon"><i class="icon_profile"></i></span>
                    <input type="text" class="form-control" placeholder="User ID" name="userid" autofocus required>
                </div>

                <div class="input-group">
                    <span class="input-group-addon"><i class="icon_key_alt"></i></span>
                    <input type="password" class="form-control" placeholder="Password" name="password" required>
                </div>

                <p class="text-center" style="color:red;">
                                   <?php echo $message; ?>
                </p>
                <input type ="submit" name="btnLogin" class="btn btn-primary btn-lg btn-block" value="Login">
                            
            </div>
        </form>

    </div>


</body>

</html>