<?php
include("./models/database.php");
extract($_POST);
$sql = "INSERT INTO `feedback`(`firstname`, `lastname`, `phone`, `email`, `message`) VALUES ('".$firstname."','".$lastname."',".$phone.",'".$email."','".$message."')";
$result = pdo_execute($sql);
if(!$result){
    die("Couldn't enter data: ".$mysqli->error);
}
echo ("Cảm ơn bạn đã liên hệ với chúng tôi");

?>