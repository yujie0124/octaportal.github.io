<?php
	session_start();
    require_once "db_con.php";

    //if not logged in
    if (!$_SESSION['UserName']){
        header("Location: index.html");
    }
    //if post_id or file_name not set
    else if(!$_GET['post_id'] || !$_GET['file_name']){
        header("Location: whiteboard.php");
    }

    $post_id = $_GET['post_id'];
	$file_name = $_GET['file_name'];

    // fetch file to download from database
    $query = "SELECT * FROM post WHERE file_name='".$file_name."'";
    if($result=mysqli_query($db_con, $query)){ 
        $rowcount = mysqli_num_rows($result);

        if($rowcount > 0)  //if file exists
            $row = mysqli_fetch_assoc($result);
        else
            header("Location: whiteboard.php");
    } else{
        echo '<script>alert("ERROR: Unable to execute SQL query. ")</script>';
    }

    $filepath = 'uploads/' . $row['file_name'];
    $display_name = substr($row['file_name'], 6);

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' .$display_name);
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('uploads/' . $row['file_name']));
        readfile('uploads/' . $row['file_name']);
        exit;
    }else{
    	echo '<script>alert("File does not exist")</script>';
    }
?>  