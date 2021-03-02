<?php
	session_start();
    require_once "db_con.php";
    
    //if not logged in
    if (!$_SESSION['UserName']){
        header("Location: index.html");
    }
    //if post_id not set
    else if(!$_GET['post_id']){
        header("Location: whiteboard.php");
    }

    /*Delete Post and redirect to course_whiteboard*/
    if(isset($_GET['post_id']) && isset($_GET['courseID'])){  //'isset() check if variable is set
    	$post_id = $_GET['post_id'];
    	$courseID = $_GET['courseID'];

    	$delete_query = "DELETE FROM post WHERE post_id ='$post_id'";
    	$query = "SELECT * FROM post WHERE post_id ='$post_id'";

    	if($result = mysqli_query($db_con, $query)){
    		if(mysqli_query($db_con, $delete_query)){
    			$row = mysqli_fetch_assoc($result);
                
	    		$filepath = 'uploads/'.$row['file_name'];
	    		unlink($filepath);
    		}
    		header("Location: course_whiteboard.php?courseID=$courseID");
    	}else
            echo '<script>alert("ERROR: Unable to execute SQL query. ")</script>';

    /*Delete Comment and redirect back to same post*/
    } else if(isset($_GET['comment_id']) && isset($_GET['post_id'])){
    	$comment_id = $_GET['comment_id'];
    	$post_id = $_GET['post_id'];

    	$query = "DELETE FROM comment WHERE comment_id ='$comment_id'";
    	if(mysqli_query($db_con, $query)){ 
    		header("Location: course_post.php?post_id=$post_id");
    	} else{
            echo '<script>alert("ERROR: Unable to execute SQL query. ")</script>';
    	}
    }
    
?>
