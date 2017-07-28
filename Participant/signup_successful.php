<?php
require_once("reg_support.php");
require_once("dbLogin.php");

$body = <<<EOT
		<h3> You are all set, enjoy Event!</h3><br>
		
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

$page = generatePage($body, "User Registration Avatar", "", "Sign Up Completed");
echo $page;

?>