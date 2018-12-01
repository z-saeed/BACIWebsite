<?php 
include 'header.php';
require_once 'db_connect.php';
require_once 'pairClass.php';

if($_SESSION['loggedin'] == false) {
	header('Location: login.php'); 
}

$user = $_SESSION['user'];
$address = $_SESSION['address'];
$mmPair = new Pair();

// $pairStatus = $con->prepare('SELECT * FROM mmRelationship_tbl WHERE mentorID = :ID OR menteeID = :ID');
// $pairStatus->execute(array('ID'=>$user->getID()));

//$ID = $user->getID();

$pendingStmt = $con->prepare("SELECT * FROM mmRelationship_tbl WHERE rejectDate IS NULL AND  startDate IS NULL AND  (mentorID = :ID OR menteeID = :ID)");
$pendingStmt->execute(array('ID'=>$user->getID()));

$mentee = false;
$mentor = false;


//set pairClass for database use
if(isset($_POST['approve'])){
	$mmPair->setChange(5);
	$_SESSION['mmPair'] = $mmPair;
	header('Location: pairing.php'); 
	//change = 5;
	}
	
if(isset($_POST['reject'])){
	$mmPair->setChange(4);
	$_SESSION['mmPair'] = $mmPair;
	header('Location: pairing.php'); 
	//change = 4;
	}

	if(isset($_POST['end'])){
	$mmPair->setChange(3);
	$_SESSION['mmPair'] = $mmPair;
	header('Location: pairing.php'); 
	//change = 3;
	}	
?>

<section id="dashboard">
	<div class="container">
		<div class="row mt-4">
			<div class="col-md-4 col-sm-4">
				<a href="dashboard.php" class="btn btn-primary btn-sm">Back to Dashboard <i class="fas fa-undo-alt"></i></a>
			</div>
		</div>
		<div class="row mt-4">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-4 col-sm-6">
						<p class="lead">Pending Pairings</p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 col-sm-12">
					<form action="userPairing.php" method="post">
						<table class="table">
							<thead class="thead-light">
								<tr>
									<th scope="col">Mentor Name</th>
									<th scope="col">Mentee Name</th>
									<th scope="col">Requester</th>
									<th scope="col">Request Date</th>
									<th scope="col">Actions</th>
									<th scope="col"></th>
								</tr>
							</thead>
								<?php 
								while($row = $pendingStmt->fetch(PDO::FETCH_ASSOC)) {
									if ($row['mentorID'] == $user->getID()) {
										$mentor = true;
										$mmPair->setMentorID($user->getID());

										$menteeStmt = $con->prepare("SELECT * FROM user_tbl WHERE ID = :ID");
										$menteeStmt->execute(array('ID'=>$row["menteeID"]));
										$menteeRow = $menteeStmt->fetch(PDO::FETCH_ASSOC);
										$menteeFullName = $menteeRow["firstName"]." ".$menteeRow["lastName"];
										
										$mmPair->setMenteeID($menteeRow["ID"]);
										$mentee = false;
									} else {
										$mentee = true;
										$mmPair->setMenteeID($user->getID());
										
										$mentorStmt = $con->prepare("SELECT * FROM user_tbl WHERE ID = :ID");
										$mentorStmt->execute(array('ID'=>$row["mentorID"]));
										$mentorRow = $mentorStmt->fetch(PDO::FETCH_ASSOC);

										$mentorFullName = $mentorRow["firstName"]." ".$mentorRow["lastName"];
										
										$mmPair->setMentorID($mentorRow["ID"]);
										$mentor = false;
									}
								?>

								<tbody>
									<tr>
										<?php if ($mentor) { ?>
										<th scope="row"><?php echo ($user->getFirstName()." ".$user->getLastName() );?></th>
										<?php } else {?>
										<th scope="row"><?php echo ($mentorFullName);?></th>
										<?php } ?>
										<?php if ($mentee) { ?>
										<th scope="row"><?php echo ($user->getFirstName()." ".$user->getLastName() );?></th>
										<?php } else {?>
										<th scope="row"><?php echo ($menteeFullName);?></th>
										<?php } 
										if($row["requester"] == 0){
											$mmPair->setRequester($row["requester"]);
											$requester = "Mentee";
										}
										if($row["requester"] == 1){
											$mmPair->setRequester($row["requester"]);
											$requester = "Mentor";
										}
										if($row["requester"] == 2){
											$mmPair->setRequester($row["requester"]);
											$requester = "AdminAdded";
										}
										?>
										<th scope="row"><?php echo $requester;?></th>
										<th scope="row"><?php echo $row["requestDate"]; ?></th>
										<?php if($requester != $user->getUserStatus()){?>
										<th scope="row"><button type="submit" class="btn btn-block btn-outline-success" name="approve">Approve Pairing</button></th>
										<th scope="row"><button type="submit" class="btn btn-outline-danger" name="reject">Reject Pairing</a></th>
										<?php } else { ?>									
										<th scope="row"><button type="submit" class="btn btn-outline-danger" name="reject">Reject Pairing</a></th>
										<?php } ?>
									</tr>
								</tbody>							
								<?php 
								}
								?>
						</table>
						</form>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4 col-sm-6">
						<p class="lead">Current Pairings</p>
					</div>
				</div>
				<div class="row">
					<?php 
					$currentStmt = $con->prepare("SELECT * FROM mmRelationship_tbl WHERE endDate IS NULL AND  startDate IS NOT NULL AND  (mentorID = :ID OR menteeID = :ID)");
					$currentStmt->execute(array('ID'=>$user->getID()));
					?>
					<div class="col-md-12 col-sm-12">
					<form action="userPairing.php" method="post">
						<table class="table">
							<thead class="thead-light">
								<tr>
									<th scope="col">Mentor Name</th>
									<th scope="col">Mentee Name</th>
									<th scope="col">Requester</th>
									<th scope="col">Start Date</th>
									<th scope="col">Actions</th>
								</tr>
							</thead>
								<?php 
								while($row = $currentStmt->fetch(PDO::FETCH_ASSOC)) {
									if ($row['mentorID'] == $user->getID()) {
										$mentor = true;

										$menteeStmt = $con->prepare("SELECT * FROM user_tbl WHERE ID = :ID");
										$menteeStmt->execute(array('ID'=>$row["menteeID"]));
										$menteeRow = $menteeStmt->fetch(PDO::FETCH_ASSOC);
										$menteeFullName = $menteeRow["firstName"]." ".$menteeRow["lastName"];
										$mentee = false;
									} else {
										$mentee = true;

										$mentorStmt = $con->prepare("SELECT * FROM user_tbl WHERE ID = :ID");
										$mentorStmt->execute(array('ID'=>$row["mentorID"]));
										$mentorRow = $mentorStmt->fetch(PDO::FETCH_ASSOC);

										$mentorFullName = $mentorRow["firstName"]." ".$mentorRow["lastName"];
										$mentor = false;
									}
								?>

								<tbody>
									<tr>
										<?php if ($mentor) { ?>
										<th scope="row"><?php echo ($user->getFirstName()." ".$user->getLastName() );?></th>
										<?php } else {?>
										<th scope="row"><?php echo ($mentorFullName);?></th>
										<?php } ?>
										<?php if ($mentee) { ?>
										<th scope="row"><?php echo ($user->getFirstName()." ".$user->getLastName() );?></th>
										<?php } else {?>
										<th scope="row"><?php echo ($menteeFullName);?></th>
										<?php } 
										if($row["requester"] == 0)
											$requester = "Mentee";
										else
											$requester = "Mentor";
										?>
										<th scope="row"><?php echo $requester;?></th>
										<th scope="row"><?php echo $row["startDate"]; ?></th>
										<th scope="row"><button type="submit" class="btn btn-outline-danger" name="end">End Pairing</a></th>
									</tr>
								</tbody>									
								<?php 
								}
								?>
						</table>
						</form>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4 col-sm-6">
						<p class="lead">Ended Pairings</p>
					</div>
				</div>
				<div class="row">
					<?php 
					$currentStmt = $con->prepare("SELECT * FROM mmRelationship_tbl WHERE endDate IS NOT NULL AND  (mentorID = :ID OR menteeID = :ID)");
					$currentStmt->execute(array('ID'=>$user->getID()));
					?>
					<div class="col-md-12 col-sm-12">
						<table class="table">
							<thead class="thead-light">
								<tr>
									<th scope="col">Mentor Name</th>
									<th scope="col">Mentee Name</th>
									<th scope="col">Requester</th>
									<th scope="col">End Date</th>
								</tr>
							</thead>
								<?php 
								while($row = $currentStmt->fetch(PDO::FETCH_ASSOC)) {
									if ($row['mentorID'] == $user->getID()) {
										$mentor = true;

										$menteeStmt = $con->prepare("SELECT * FROM user_tbl WHERE ID = :ID");
										$menteeStmt->execute(array('ID'=>$row["menteeID"]));
										$menteeRow = $menteeStmt->fetch(PDO::FETCH_ASSOC);
										$menteeFullName = $menteeRow["firstName"]." ".$menteeRow["lastName"];
										$mentee = false;
									} else {
										$mentee = true;

										$mentorStmt = $con->prepare("SELECT * FROM user_tbl WHERE ID = :ID");
										$mentorStmt->execute(array('ID'=>$row["mentorID"]));
										$mentorRow = $mentorStmt->fetch(PDO::FETCH_ASSOC);

										$mentorFullName = $mentorRow["firstName"]." ".$mentorRow["lastName"];
										$mentor = false;
									}
								?>

								<tbody>
									<tr>
										<?php if ($mentor) { ?>
										<th scope="row"><?php echo ($user->getFirstName()." ".$user->getLastName() );?></th>
										<?php } else {?>
										<th scope="row"><?php echo ($mentorFullName);?></th>
										<?php } ?>
										<?php if ($mentee) { ?>
										<th scope="row"><?php echo ($user->getFirstName()." ".$user->getLastName() );?></th>
										<?php } else {?>
										<th scope="row"><?php echo ($menteeFullName);?></th>
										<?php } 
										if($row["requester"] == 0)
											$requester = "Mentee";
										else
											$requester = "Mentor";
										?>
										<th scope="row"><?php echo $requester;?></th>
										<th scope="row"><?php echo $row["endDate"]; ?></th>
									</tr>
								</tbody>									
								<?php 
								}
								?>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php include 'footer.php'; ?>