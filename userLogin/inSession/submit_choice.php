<?php
/**
 * Created by PhpStorm.
 * User: jx
 * Date: 2017/4/25
 * Time: 15:48
 */
require_once ("../../db/dbLogin.php");
require '../../PHPMailer-master/PHPMailerAutoload.php';
require_once ("support.php");
if(!isset($_COOKIE["login"]))
    header("location: ../loginCheck.php");
$body = "";
$transitionName = "";
if (isset($_POST["submit"])) {
    $db_connection = new mysqli($host, $user, $password, $database);
    $rider=$_COOKIE["login"];
    $idx= $_POST["choice"];
    $dep=$_POST["dep"];
    $des=$_POST["des"];
    $time=$_POST["time"];
    $query="insert into riders values(NULL,\"$rider\",\"$dep\",\"$des\",\"$time\",$idx)";
    $result = $db_connection->query($query);
    if (!$result) {
        die("Insertion failed: " . $db_connection->error);
    }
    $query = "update drivers set size=size-1 where id=$idx;";
    $result = $db_connection->query($query);
    if (!$result) {
        die("Update failed: " . $db_connection->error);
    }
    $info_query="SELECT users.phone,users.name,users.username,users.carmodel FROM users,drivers WHERE drivers.id=$idx And drivers.email=users.email;";
    $driver_info = $db_connection->query($info_query);
    if (!$driver_info) {
        die("Failed: " . $db_connection->error);
    }
    $num_rows = $driver_info->num_rows;
    if ($num_rows === 0) {
        $transitionName = "Sorry, servers down :(";
        $body.= "<h3>Cannot find driver infomation<h3>";
    }
    else {
        $driver_info->data_seek(0);
        $row = $driver_info->fetch_array(MYSQLI_ASSOC);
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPSecure = "tls";
        $mail->SMTPAuth = true;
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 587;
        $mail->Username = "rideshare389@gmail.com";
        $mail->Password = "cmsc389n";
        $mail->setFrom("rideshare@gmail.com", "RideShare");
        $mail->addAddress($rider);
        $mail->Subject = "RideShare [Ride Confirmation]";
        $mail->Body = "Driver Name:{$row['name']} \nDriver Username:{$row['username']} \n Phone:{$row['phone']} \nCar Model:{$row['carmodel']}";
        if (!$mail->send())
            echo "ERROR: " . $mail->ErrorInfo;
        else {
            $transitionName = "RideShare Set Up!";
            $body = "<h3>Information submitted</h3> <h3>Check your e-mail. We sent you a confirmation.</h3><h3>You sill soon receive a text confirmation as well</h3><br><br>";
            header("refresh:5;url=../rider_info.php");
        }
    }
    $page=generatePage($body,"RideShare", $transitionName);
    echo $page;
}
?>