<?php
	
	$student_uid = $_POST['uid'];
	$student_ufname = $_POST['ufname'];
	$student_ulname = $_POST['ulname'];

	$conn = mysqli_connect("localhost","root","","user") or die("connection failed");
	$sql = "UPDATE student SET first_name = '{$student_ufname}', last_name = '{$student_ulname}' WHERE id = {$student_uid}   ";
	if(mysqli_query($conn,$sql)){
		echo 1;
	}else{
		echo 0;
	}
?>