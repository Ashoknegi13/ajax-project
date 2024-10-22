<?php

$studentid = $_POST["uid"];
$studentfname = $_POST["ufname"];
$studentlname = $_POST["ulname"];

$conn = mysqli_connect("localhost","root","","user") or die("connection failed");
$sql  = "UPDATE student SET first_name = '{$studentfname}' , last_name= '{$studentlname}'  WHERE id = {$studentid}";
if(mysqli_query($conn,$sql)){
    echo 1;
}else{
    echo 0;
}

?>