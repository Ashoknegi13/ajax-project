<?php

$student_eid = $_POST['eid'];
$conn = mysqli_connect("localhost","root","","user") or die("connection failed");
$sql = "SELECT * FROM student WHERE id = {$student_eid} ";
$result = mysqli_query($conn,$sql) or die("Query failed");
$output = "";
if(mysqli_num_rows($result)>0){
     while($row = mysqli_fetch_assoc($result)){
     	$output = "<tr>
						<td>Frist Name</td>
						<td><input type='text' id='edit-fname' value='{$row['first_name']}'>
						     <input type='text' id='edit-id' hidden value='{$row['id']}'>
						</td>
					</tr>
					<tr>
						<td>Last Name</td>
						<td><input type='text' id='edit-lname'  value='{$row['last_name']}'></td>
					</tr>
					<tr>
						<td></td>
						<td><input type='submit' id='update-btn' value='Update'> </td>
					</tr>";
				}
			mysqli_close($conn);
        echo $output;
	
}else{
	echo "No record Found";
}
?>