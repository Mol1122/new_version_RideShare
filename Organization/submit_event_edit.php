<?php
session_start();
if (!isset($_SESSION['username']) || empty($_SESSION['username'])){
    header("Location: ../index.php");
    exit();
}

require_once("support.php");
require_once("dbLogin.php");

$transitionName = "";
$body = "";

if (isset($_POST["submit"])){
	$db_connection = new mysqli($host, $user, $password, $database);
    if ($db_connection->connect_error) {
        $transitionName .= "Sorry, our servers Down :(";
        $body .= "Connection to the database error<br />";
        die($db_connection->connect_error);
    } 
    else{
    	$transitionName = "Edit";
        $eid = $_POST['eid'];
        $query = "SELECT * FROM events WHERE id=\"$eid\" LIMIT 1;";
        $result = $db_connection->query($query, MYSQLI_STORE_RESULT);
        if (!$result || $result->num_rows === 0){
            $transitionName="Oops!";
            $body .= "<h3>Sorry, an error occured. Try again later! </h3>";
        }
        else{
            $row = mysqli_fetch_array($result);
            $old_event_title = $row[1];
            $old_location = $row[3];
            $old_time = $row[4];
            $old_time = str_replace(" ", "T", $old_time);
            $old_website = $row[5];
            $old_pw = $row[7];
            $event_title = trim($_POST["event_title"]);
	        $organization = $_SESSION['organization'];
	        $location = trim($_POST["dep"]);
	        $time = trim($_POST["time"]);
	        $website = trim($_POST["website"]);
            $fields = $_POST["fields"];
	        $query = "UPDATE events SET title=\"$event_title\", location=\"$location\", time=\"$time\", website=\"$website\" WHERE id=$eid;";
	        $result = $db_connection->query($query);
            $query2 = "DELETE FROM eventLocations WHERE eid=$eid;";
            $result2 = $db_connection->query($query2);
            $good = "Yes";
            foreach($fields as $a => $b){
                $fields[$a] = trim($fields[$a]);
                $query = "SELECT * FROM eventLocations WHERE eid=$eid AND location=\"$fields[$a]\";";
                $result4 = $db_connection->query($query);
                if (!$result4){$good = "No"; break;}
                if ($result4->num_rows === 0){
                    $query = "SELECT * FROM joinedEvents WHERE eid=$eid AND location=\"$fields[$a]\";";
                    $result5 = $db_connection->query($query);
                    if (!$result5){$good = "No";break;}
                    $lp = $result5->num_rows;
                    $query = "INSERT into eventLocations values($eid, \"$fields[$a]\", $lp);";
                    $result3 = $db_connection->query($query);
                    if (!$result3){$good = "No";}
                }
            }
            $query6 = "SELECT * FROM joinedEvents WHERE eid=$eid;";
            $result6 = $db_connection->query($query6);
            while ($row6 = mysqli_fetch_array($result6)){
                $query7 = "SELECT * FROM eventLocations WHERE eid=$eid AND location=\"trim($row6[2])\";";
                $result7 = $db_connection->query($query7);
                if ($result7 && $result7->num_rows===0){
                    $result7 = $db_connection->query("DELETE FROM joinedEvents WHERE eid=$eid AND user_name=\"$row6[0]\";");
                    $result7=$db_connection->query("UPDATE events SET participation = participation-1 WHERE id=$eid AND participation > 0;");
                }
                if (!$result7){$good="No";}
            }
            if ($_POST['priv'] == 'priv'){
                if ($old_pw == null){
                    $new_pw = md5(uniqid($eid, true));
                    $query = "UPDATE events SET password=\"$new_pw\" WHERE id=$eid;";
                    $result3 = $db_connection->query($query);
                }
            }
            else{
                if ($old_pw != null){
                    $query = "UPDATE events SET password=null WHERE id=$eid;";
                    $result3 = $db_connection->query($query);
                }
            }
	        if (!$result || !$result2 || !$result3 || $good == "No") {
	            $transitionName .= "Edit Event Fail";
	            die("Edit failed: " . $db_connection->error);
	        } 
	        else {
	            $transitionName = "Update Success";
	            $body="<h3>The event has been updated!</h3><br><br>";
        	}
        }
    }
}

$page=generatePage($body, "Edit Event", $transitionName);
echo $page;
?>