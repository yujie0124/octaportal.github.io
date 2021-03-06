<?php
	session_start();
    require_once "db_con.php";

    //if not logged in
    if (!$_SESSION['UserName']){
        header("Location: dashboard.php");
    }
    //if post_id or file_name not set
    else if(!$_GET['asgmtpost_id'] || !$_GET['asgmtfile_name']){
        header("Location: course_main.php");
    }

    $asgmtpost_id = $_GET['asgmtpost_id'];
	$asgmtfile_name = $_GET['asgmtfile_name'];

    // fetch file to download from database
    $query = "SELECT * FROM asgmt_post WHERE asgmtfile_name='".$asgmtfile_name."'";
    if($result=mysqli_query($db_con, $query)){ 
        $rowcount = mysqli_num_rows($result);

        if($rowcount > 0)  //if file exists
            $row = mysqli_fetch_assoc($result);
        else
            header("Location: course_main.php");
    } else{
         echo "<script>alert('Unable to execute SQL query');</script>";
    }

    $filepath = 'uploads/' . $row['asgmtfile_name'];
    $display_name = substr($row['asgmtfile_name'], 6);

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' .$display_name);
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('uploads/' . $row['asgmtfile_name']));
        readfile('uploads/' . $row['asgmtfile_name']);
        exit;
    }else{
    	 echo "<script>alert('File Does Not Exist');</script>";
    }
?>  