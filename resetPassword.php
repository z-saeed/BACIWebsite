<?php

require_once 'header.php';
require_once 'db_connect.php';

//initializing variables

$code = ($_GET["code"]); //code from URL
	
$msg = "Enter new password:"; //message to user

$password = ""; //hold password for storing

if (isset($_POST['submit'])){
	
	$password = ($_POST['password']);
	
	$stmtChange = $con->prepare("UPDATE user_tbl SET password = :password WHERE activationURL = :code");
	$stmtChange -> execute(array('password' => $password, 'code' => $code));
}


?>

<article id="main">
	<header>
		<h2>Reset Password</h2>
	</header>
	<section class="wrapper style5">
		<div class="inner">
			<form method="post">
			
				<?php
					print $msg;
				?></br>
				
				<div class="row gtr-uniform">
					<div class="col-6 col-12-xsmall">
					New Password: 
						<input type="text" maxlength = "50" value="" name="password" id="password"   />  <br />	
					</div>
				</div>
				
				<input name="submit" class="btn" type="submit" value="Reset" />
  
			</form>
		</div>
	</section>
</article>

<?php include "footer.php"; ?>