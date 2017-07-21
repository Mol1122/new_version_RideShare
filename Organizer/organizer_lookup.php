<?php
require_once("dbLogin.php");
require_once("supportNew.php");

$body = "";
$db_connection = new mysqli($host, $user, $password, $database);
if ($db_connection->connect_error) {
    $body .= "Connection to the database error<br />";
    die($db_connection->connect_error);
} else {
    $event_title = trim($_POST["event_title"]);
    $time = $_POST["time"];
    $query = "select name, email, address from participant where event_title=\"$event_title\"";
    $result = $db_connection->query($query);
    if (!$result) {
        $body .= "query failed<br />";
        die("Select Failed: ".$db_connection->error);
    } else {
        $num_rows = $result->num_rows;
        if ($num_rows === 0) {
            $body.= "<h3>No ride information!<h3><br>";
        } else {
            for ($row_index = 0; $row_index < $num_rows; $row_index++) {
                $result->data_seek($row_index);
                $row = $result->fetch_array(MYSQLI_ASSOC);
                $color = "rgba(55,204,176, .2)";

                if($row_index % 2 === 0){
                    $color = "rgba(55,204,176, .7)";
                }

                $body .= <<<EOBODY
					
					<div class="row control-group btn-outline" style="padding: 20px;text-align: left;color:black;border-radius: 10px; border:1px; border-color:black; background-color:{$color};">

						<h4><strong>Name</strong>: {$row['name']}</h4>
                        <h4><strong>Email</strong>: {$row['email']}</h4><br>
						<p><strong>Address</strong> {$row["address"]}</p>
						</div><br>
EOBODY;

            }
        }
    }
}
$page=generatePage($body,"Participants Information", "Participants Information");
echo $page;
?>