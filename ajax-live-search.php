<?php

$search_value = $_POST['search'];

$conn = mysqli_connect("localhost","root","","user") or die("connection failed");
$sql = "SELECT * FROM student WHERE first_name LIKE '%{$search_value}%' OR last_name LIKE '%{$search_value}%'  ";
$result = mysqli_query($conn,$sql) or die("query failed");
$output = "";
if(mysqli_num_rows($result)>0){
		$output = '<table border="1" width="100%" cellspacing="0" cellpadding="10px;"> 
				<tr  style="background: skyblue;">
					<th width="100px">Id</th>
					<th>Name</th>
					<th width="100px">Edit</th>
					<th width="100px">Delet</th>
				</tr>';

				while($row= mysqli_fetch_assoc($result)) {
 $output .= "<tr style='background-color:cyan'> 
                              <td>{$row['id']}</td> 
                              <td>{$row['first_name']} {$row['last_name']}</td>
              <td><button class='edit-btn' data-eid='{$row['id']}' style='background-color:blue;color:white'>Edit</button>
                               </td>

              <td><button class='delete-btn' data-id='{$row['id']}' style=' background-color:orange;color:white'>Delete</button>
                               </td>
            </tr>";
				}
				$output .= "</table>";

				mysqli_close($conn);
				echo $output;

}else{
      echo "Record not found";
}
?>