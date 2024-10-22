   <?php

$conn = mysqli_connect("localhost","root","","user") or die("connection failed");
$limit_per_page = 5;
$page="";
if(isset($_POST['page_no'])){
	$page= $_POST['page_no'];
}else{
	$page = 1;
}

$offset = ($page-1)*$limit_per_page;

$sql = "SELECT * FROM student ORDER BY id DESC LIMIT {$offset},{$limit_per_page}";
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
				
				$output .= '<div id="pagination" style="padding-left:250px; margin-top:10px">';

				$sql_total = "SELECT * FROM student";
				$records = mysqli_query($conn,$sql_total) or die("Pagination query failed");
				$total_records = mysqli_num_rows($records);
				$total_pages = ceil($total_records/$limit_per_page);
				for($i=1; $i<=$total_pages;$i++){
				$output .= "<a id='{$i}' class='active' href='' style=' margin:2px; padding-right:10px;padding-left:10px;  background-color:blue;  text-decoration:none; color:white; border-radius:50px;'>{$i}</a>";
			 }
			 $output .= '</div>';
				mysqli_close($conn);
				echo $output;

}else{
      echo "Record not found";
}
?>