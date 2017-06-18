<?php

    /**
     * Created by PhpStorm.
     * User: jx
     * Date: 2017/4/23
     * Time: 17:18
     */
    require_once ("../../db/dbLogin.php");
    require_once ("support.php");
    $body = "";
    if(!isset($_COOKIE["login"]))
        header("location:../index.html#portfolio");
    if (isset($_POST["submit"])) {
        $db_connection = new mysqli($host, $user, $password, $database);
        if ($db_connection->connect_error) {
            $body .= "Connection to the database error<br />";
            die($db_connection->connect_error);
        } else {
            $user=$_COOKIE["login"];
            $dep=$_POST["dep"];
            $des=$_POST["des"];
            $start=$_POST["start"];
            $end=$_POST["end"];
            $size=$_POST["size"];
            $L1=substr($_POST["L1"],1,strlen($_POST["L1"])-2);
            $L2=substr($_POST["L2"],1,strlen($_POST["L2"])-2);
            $L1a=explode(",",$L1);
            $L2a=explode(",",$L2);
            $query="INSERT INTO drivers VALUES(NULL,\"$user\",\"$dep\",$L1a[0],$L1a[1],\"$des\",$L2a[0],$L2a[1],\"$start\",\"$end\",$size)";
            $result = $db_connection->query($query);
            if (!$result) {
                die("Insertion failed: " . $db_connection->error);
            } else {
                $body="<h3>The ride information has been added to the database</h3><br><br>";
                header("refresh:3;url=../driver_info.php");
            }
        }
    }
    $page=generatePage($body,"Submit Ride", "Submit Ride");
    echo $page;
?>