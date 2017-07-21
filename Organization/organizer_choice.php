<?php
require_once("dbLogin.php");
require_once("supportNew.php");

$body="";
$bottom = "";
$transionName = "Organizer Choice: ";

if (isset($_POST["submit"])) {
    $signup_or_login = $_POST["signup_or_login"];

    if ($signup_or_login == "Sign Up") {
       header("location: organizerSignup.php");
    } else if ($signup_or_login == "Log In") {
        header("location: organizerLogin.php");
    } else {
        $bottom .= "Fail";
    }
}
$body = $bottom;
$page=generatePage($body,"Login", $transionName);
echo $page;
?>