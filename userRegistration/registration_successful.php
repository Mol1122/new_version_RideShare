<?php
	require_once("reg_support.php");
	require_once("../db/dbLogin.php");
	
	$nameValue = rawurldecode($_GET['name']);
	$body = <<<EOT
		<h3> You are all set {$nameValue}, enjoy Rideshare!</h3><br>
		
		<form action="../index.html#portfolio">
			<div class="row control-group">
                <div class="form-group col-xs-12">
                      <input type="submit" name="submit" value= "Start new Ride" class="btn btn-success btn-lg">
		    </div>
            </div>
		</form>
		<form action="{$_SERVER['PHP_SELF']}" method="post">
			<div class="row control-group">
                                            <div class="form-group col-xs-12">
                                                <input type="submit" name="submit" value= "Back to Main Page" class="btn btn-success btn-lg">
                                            </div>
            </div>
		</form>
EOT;

	if (isset($_POST['submit'])) {
		header('Location: ../index.html');
	}

	$page = generatePage($body, "User Registration Avatar", "", "Profile Completed");
	echo $page;

?>	