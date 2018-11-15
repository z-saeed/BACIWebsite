<?php 

include 'header.php';
require_once 'db_connect.php';

$msg = "";
$subject = "";
$body = "";

$mentor = ($_GET["mentor"]);
$mentee = ($_GET["mentee"]);
$change = ($_GET["change"]);

$date = date("Y-m-d");

$stmtMentor = $con->prepare("SELECT * FROM user_tbl WHERE ID=:mentor");
$stmtMentor -> execute(array('mentor' => $mentor));
$mentorRow = $stmtMentor->fetch(PDO::FETCH_OBJ);

$stmtMentee = $con->prepare("SELECT * FROM user_tbl WHERE ID=:mentee");
$stmtMentee -> execute(array('mentee' => $mentee));
$menteeRow = $stmtMentee->fetch(PDO::FETCH_OBJ);

if($change == "0"){
	$stmt = $con->prepare("UPDATE mmRelationship_tbl SET rejectDate=:date WHERE mentorID = :mentor AND menteeID = :mentee");
	$stmt -> execute(array('date' => $date, 'mentor' => $mentor, 'mentee' => $mentee));
	$msg = "Pairing denied.";
	$subject = "Pairing Denied";
	$body = "A pairing has been denied by a coordinator. ".$mentorRow->firstName." ".$mentorRow->lastName." and ".$menteeRow->firstName." ".$menteeRow->lastName."'s pairing has been denied.";
} else if ($change == "1"){
	$stmt = $con->prepare("UPDATE mmRelationship_tbl SET startDate=:date WHERE mentorID = :mentor AND menteeID = :mentee");
	$stmt -> execute(array('date' => $date, 'mentor' => $mentor, 'mentee' => $mentee));
	$msg = "Pairing accepted.";
	$subject = "Pairing Accepted";
	$body = "A pairing has been started by a coordinator. ".$mentorRow->firstName." ".$mentorRow->lastName." and ".$menteeRow->firstName." ".$menteeRow->lastName."'s pairing has been activated.";
} else {
	$msg = "Error, change not recognized.";
}

$mailer = new Mail();
if(($mailer->sendMail($mentorRow->email, "User", $subject, $body))){
	$msg = "Message 1 sent";
}
if(($mailer->sendMail($menteeRow->email, "User", $subject, $body))){
	$msg = "Emails have been sent to both parties";
}
?>

<section id="loginPage">
	
	<div id="login">
		<div id="loginForm">
			<h3><?php echo $msg; ?></h3>
			<form action="listPending.php" method="post">
				<div class="form-row">
					<div class="form-group col-md-4 col-sm-8 offset-md-4 offset-sm-2">
						<button type="submit" class="btn btn-light btn-sm" name="resend">Return to Pending<i class="fas fa-lock"></i></button>
					</div>
				</div>
			</form>
		</div>
	</div>

</section>