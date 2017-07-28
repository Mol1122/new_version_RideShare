<?php
require_once("dbLogin.php");
require_once("supportNew.php");

$body="";
$bottom = "";
$transionName = "Participant Choice: ";

if (isset($_POST["submit"])) {
    $signup_or_login = $_POST["signup_or_login"];

    if ($signup_or_login == "Sign Up") {
       header("location: participantSignup.php");
    } else if ($signup_or_login == "Log In") {
        header("location: participantLogin.php");
    } else {
        $bottom .= "Fail";
    }
}
$body = $bottom;
$page=generatePage($body,"Login", $transionName);
echo $page;
?>