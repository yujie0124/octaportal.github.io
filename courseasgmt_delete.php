<?php
	session_start();
    require_once "db_con.php";
    
    //if not logged in
    if (!$_SESSION['UserName']){
        header("Location: index.html");
    }
    //if post_id not set
    else if(!$_GET['asgmtpost_id']){
        header("Location: dashboard.php");
    }

    /*Delete Post and redirect to course_assignment*/
    if(isset($_GET['asgmtpost_id']) && isset($_GET['courseID'])){  //'isset() check if variable is set
    	$asgmtpost_id = $_GET['asgmtpost_id'];
    	$courseID = $_GET['courseID'];

    	$delete_query = "DELETE FROM asgmt_post WHERE asgmtpost_id ='$asgmtpost_id'";
    	$query = "SELECT * FROM asgmt_post WHERE asgmtpost_id ='$asgmtpost_id'";

    	if($result = mysqli_query($db_con, $query)){
    		if(mysqli_query($db_con, $delete_query)){
    			$row = mysqli_fetch_assoc($result);
                
	    		$filepath = 'uploads/'.$row['asgmtfile_name'];
	    		unlink($filepath);
    		}
    		header("Location: course_assignment.php?courseID=$courseID");
    	}else
             echo "<script>alert('Unable to execute SQL query');</script>";

    /*Delete Comment and redirect back to same post*/
    } else if(isset($_GET['asgmtcomment_id']) && isset($_GET['asgmtpost_id'])){
    	$asgmtcomment_id = $_GET['asgmtcomment_id'];
    	$asgmtpost_id = $_GET['asgmtpost_id'];

    	$query = "DELETE FROM asgmt_comment WHERE asgmtcomment_id ='$asgmtcomment_id'";
    	if(mysqli_query($db_con, $query)){ 
    		header("Location: courseasgmt_post.php?asgmtpost_id=$asgmtpost_id");
    	} else{
             echo "<script>alert('Unable to execute SQL query');</script>";
    	}
    }else{}
    
?>
