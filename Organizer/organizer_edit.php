<?php
    require_once("dbLogin.php");
    require_once("support.php"); //May need to change to a different script...

    $body = "";

    if (isset($_POST["submit"])) {
        $db_connection = new mysqli($host, "root", null, $database);
        if ($db_connection->connect_error) {
            $body .= "<h3>Connection to the database error<h3><br />";
            die($db_connection->connect_error);
        } else {
            $new_event_title = trim($_POST["event_title"]);
            $new_organization = trim($_POST["organization"]);
            $new_location = trim($_POST["location"]);
            $new_time = $_POST["time"];
            $new_website = trim($_POST["website"]);
            $query = "update events set title = \"$new_event_title\", location = $new_location, time = '$new_time', website = \"$new_website\" where organization = \"$new_organization\"";
            $result = $db_connection->query($query);
            if (!result) {
                $body .= "Edit Fail<br />";
                die("Edit Failed: ".$db_connection->error);
            } else {
                $body .=<<< EOBODY

EOBODY;
/* Form with new data here... */
            }
        }
        $db_connection->close();
    } else {
        // retrieve user information from the database
        $db_connection = new mysqli($host, "root", null, $database);
        if ($db_connection->connect_error) {
            $body .= "<h3>Connection to the database error<h3><br />";
            die($db_connection->connect_error);
        } else {
            $query = "select * from events where organization = \"$email\"";
            $result = $db_connection->query($query);
            if (!$result) {
                $body .= "query failed<br />";
                die("Selection Failed: ".$db_connection->error);
            } else {
                $result->data_seek(0);
                $row = $result->fetch_array(MYSQLI_ASSOC);
                $event_title = $row["event_title"];
                $organization = $row["organization"];
                $location = $row["location"];
                $time = $row["time"];
                $new_website = $row["website"];
                $participation = $row["participation"];
            }
        }
        $db_connection->close();
/* Form with old data here... */

    }
$page = generatePage($body, "Organizer Edit");
echo $page;
?>