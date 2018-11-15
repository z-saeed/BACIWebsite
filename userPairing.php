<?php 
include 'header.php';
require_once 'db_connect.php';

if($_SESSION['loggedin'] == false) {
	header('Location: login.php'); 
}

$user = $_SESSION['user'];
$address = $_SESSION['address'];

$pairStatus = $con->prepare('SELECT * FROM mmRelationship_tbl WHERE mentorID = :ID OR menteeID = :ID');
$pairStatus->execute(array('ID'=>$user->getID()));

$mentee = false;
$mentor = false;

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
						<?php if ($pairStatus->rowCount() == 0) { ?>
							<p class="lead">No User Pairings Found</p>
						<?php } else { ?>

							<p class="lead">Pairings Found</p>
						<?php } ?>
					</div>
				</div>
				<?php while($row = $pairStatus->fetch(PDO::FETCH_ASSOC)) { 
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

					$status = "";
					if (is_null($row['rejectDate']) != true) {
						$status = 'Rejected';
					} else if (is_null($row['startDate'])) {
						$status = 'Pending';
					} else if (is_null($row['startDate']) != true && is_null($row['endDate'])) {
						$status = 'Current';
					} else if (is_null($row['endDate']) != true) {
						$status = 'Ended';
					}
					?>
				<div class="row">
					<div class="col-md-12 col-sm-12">
						<table class="table">
							<thead class="thead-light">
								<tr>
									<th scope="col">Mentor Name</th>
									<th scope="col">Mentee Name</th>
									<th scope="col">Requester</th>
									<th scope="col">Status</th>
									<?php if ($status == 'Current') { ?>
									<th scope="col">Start Date</th>
									<?php } else if ($status == 'Pending') { ?>
									<th scope="col">Request Date</th>
									<?php } else if ($status == 'Rejected') {?>
									<th scope="col">Reject Date</th>
									<?php } else if ($status == 'Ended') {?>
									<th scope="col">End Date</th>
									<?php } ?>
									<th scope="col">Actions</th>
								</tr>
							</thead>
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
									<?php 
									
									?>
									<th scope="row"><?php echo $status;?></th>
									<?php if ($status == 'Current') { ?>
									<th scope="row"><?php echo $row["startDate"]; ?></th>
									<th scope="row"><a href="pairing.php?mentor=<?php echo $row["mentorID"] ?>&mentee=<?php echo $row["menteeID"] ?>&change=3" class="btn btn-outline-danger">End</a></th>
									<?php } else if ($status == 'Pending') { ?>
									<th scope="row"><?php echo $row["requestDate"]; ?></th>
									<th scope="row"><a href="pairing.php?mentor=<?php echo $row["mentorID"] ?>&mentee=<?php echo $row["menteeID"] ?>.'&change=5" class="btn btn-block btn-outline-success">Approve</a></th>
									<th scope="row"><a href="pairing.php?mentor=<?php echo $row["mentorID"] ?>&mentee=<?php echo $row["menteeID"] ?>.'&change=4" class="btn btn-outline-danger">Reject</a></th>
									<?php } else if ($status == 'Rejected') {?>
									<th scope="row"><?php echo $row["rejectDate"]; ?></th>
									<?php } else if ($status == 'Ended') {?>
									<th scope="row"><?php echo $row["endDate"]; ?></th>
									<?php } ?>
								</tr>
							</tbody>
						</table>

					</div>
				</div>
			<?php } ?>
			</div>
		</div>
	</div>
</section>

<?php include 'footer.php'; ?>