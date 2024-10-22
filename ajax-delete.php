<?php
$student_id = $_POST['id'];

$conn = mysqli_connect("localhost","root","","user") or die("connnection failed");
$sql = "DELETE FROM student WHERE id= {$student_id}";
//$result = mysqli_query($conn,$sql) or die("query failed");
if(mysqli_query($conn,$sql)){
	echo 1;
}else{
	echo 0;
}
 

?>