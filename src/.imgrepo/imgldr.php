<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'commonfiles/config.php';

// Create connection
if(isset($_POST["image_name"]) && isset($_POST["image_data"])){

 $DefaultId = 0;
 
 $ImageData = $_POST['image_data'];
 
 $ImageName = $_POST['image_name'];


$sql ="SELECT id FROM mobileimg ORDER BY id ASC";
 
$stmt = checkUserStmt($conn, $sql); 
while($row = mysqli_fetch_array($stmt)){
 
 $DefaultId = $row['id'];
 }

freeUserData($stmt, $sql);

$ImagePath = ".imgrepo/images/$ImageName.png";

$ServerURL = "roofadvizorz.com/$ImagePath";

$Imgpth = "/var/www/ROOFZ/.imgrepo/images/$ImageName.png";
 
$sql = "insert into mobileimg (image_path,image_name) values ('$ServerURL','$ImageName')";

if(checkUserStmt($conn, $sql)){

file_put_contents($Imgpth,base64_decode($ImageData));

 echo "Your Image Has Been Uploaded.";
 }
 freeUserData($stmt, $sql);
}else{
 echo "Not Uploaded";
 }

?>
