<?php
session_start();
if (!isset($_SESSION['organization']) || empty($_SESSION['organization'])){
    header("Location: ../index.html");
    exit();
}


require_once("support.php");
require_once("dbLogin.php");

$transitionName = "";
$body = "";

if (isset($_POST["submit"])) {
    $db_connection = new mysqli($host, $user, $password, $database);
    if ($db_connection->connect_error) {
        $transitionName .= "Sorry, our servers Down :(";
        $body .= "Connection to the database error<br />";
        die($db_connection->connect_error);
    } else {
        $event_title = trim($_POST["event_title"]);
        $organization = $_SESSION['organization'];
        $location = trim($_POST["dep"]);
        $time = trim($_POST["time"]);
        $website = trim($_POST["website"]);

        $query = "insert into events values(NULL,\"$event_title\", \"$organization\", \"$location\", \"$time\", \"$website\", 0)";
        $result = $db_connection->query($query);
        if (!$result) {
            $transitionName .= "Create New Event Fail";
            die("Insertion failed: " . $db_connection->error);
        } else {
            $transitionName = "New Event Success";
            $body="<h3>The event information has been added to the database</h3><br><br>";
            $body .=<<< EFBODY
            <script>
                $("#closeX").click(function () {
                    window.location.replace("../index.html");
                });

                $("#closeB").click(function () {
                    window.location.replace("../index.html");
                });
            </script>
EFBODY;

        }
    }
}

$page = generatePage($body, "new event", $transitionName);
echo $page;
?>