<!--
	forgotPassword.php - Allows user/admin to send an email with user's password
-->

<?php

include "header.php";
require_once 'db_connect.php';

//initialize variables to be used

$un = ""; //username

$code = randomCodeGenerator(50);
	
$msg = "Enter your username to recieve an email to reset your password"; //message to user

if (isset($_POST['reset'])){
	
	$un = trim($_POST['username']);
	$un = strtolower($un);

	$stmtCode = $con->prepare("UPDATE user_tbl SET activationURL = '$code' WHERE username = :un");
	$stmtCode->execute(array('un' => $un));
	
	$stmtEmail = $con->prepare("SELECT email FROM user_tbl WHERE username = :un");
	$stmtEmail -> execute(array('un' => $un));
	$row = $stmtEmail->fetch(PDO::FETCH_OBJ);
	$body = "Please follow this link to reset your BACI password: http://corsair.cs.iupui.edu:23191/courseProject/BaciProjectAlt-master/resetPassword.php?code=".$code;
	
	$mailer = new Mail();
	if(($mailer->sendMail($row->email, "User", "BACI email reset", $body))){
			$msg = "An email has been sent to the corresponding email. Please follow the link to reset your password.";
	}

}

?>
			<!-- Main -->
			<article id="main">
				<header>
					<h2>Forgot Password</h2>
				</header>
				<section class="wrapper style5">
					<div class="inner">
						<form method="post">
						
							<?php
								print $msg;
							?></br>
							
							<div class="row gtr-uniform">
								<div class="col-6 col-12-xsmall">
									Username:
										<input type="text" maxlength = "50" value="" name="username" id="username"   />  <br />	
								</div>
							</div>
							
							<input name="reset" class="btn" type="submit" value="Reset" />
			  
						</form>
					</div>
				</section>
			</article>
<?php include "footer.php"; ?>