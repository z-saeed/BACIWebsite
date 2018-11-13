<?php 
include 'header.php';
require_once 'db_connect.php';

if($_SESSION['loggedin'] == false) {
	header('Location: login.php'); 
}

$user = $_SESSION['user'];
$pairID = $user->getID();

$user = new User();
$address = new Address();

$boolUser = false;

if (isset($_REQUEST["userID"])) {
	$boolUser = true;
	$userID = $_REQUEST["userID"];
	$profileStmt = $con->prepare('SELECT * FROM user_tbl WHERE ID = :ID');
	$profileStmt->execute(array('ID'=>$userID));
	$row = $profileStmt->fetch(PDO::FETCH_OBJ);

	if($profileStmt->rowCount() != 1) {
		$msg = "Profile Not Found";
	} else {
		$user->setID($row->ID);
		$user->setUserName($row->username);
		$user->setPassword($row->password);
		$user->setEmail($row->email);
		$user->setFirstName($row->firstName);
		$user->setLastName($row->lastName);
		$user->setPhoneNumber($row->phone);
		$user->setGender($row->gender);
		$user->setUserStatus($row->userStatus);
		$user->setAddressID($row->addressID);
		$user->setUserPrivilege($row->privilege);
		$user->setIdentityID($row->identityID);
		$user->setFbLink($row->fbLink);
		$user->setTwLink($row->twLink);
		$user->setLkLink($row->lkdLink);

		$imageSTMT = $con->prepare('SELECT * FROM picture_tbl WHERE ID = :ID');
		$imageSTMT->execute(array('ID'=>$row->pictureID));
		$imageRow = $imageSTMT->fetch(PDO::FETCH_OBJ);

		$user->setImagePath($imageRow->location);

		$resumeSTMT = $con->prepare('SELECT * FROM resume_tbl WHERE ID = :ID');
		$resumeSTMT->execute(array('ID'=>$row->resumeID));
		$resumeRow = $resumeSTMT->fetch(PDO::FETCH_OBJ);

		$user->setResumePath($resumeRow->location);

		$addressSTMT = $con->prepare('SELECT * FROM address_tbl WHERE ID = :ID');
		$addressSTMT->execute(array('ID'=>$user->getAddressID()));
		$addressRow = $addressSTMT->fetch(PDO::FETCH_OBJ);

		$stateSTMT = $con->prepare('SELECT * FROM state_tbl WHERE ID = :ID');
		$stateSTMT->execute(array('ID'=>$addressRow->stateID));
		$stateRow = $stateSTMT->fetch(PDO::FETCH_OBJ);

		$countrySTMT = $con->prepare('SELECT * FROM country_tbl WHERE ID = :ID');
		$countrySTMT->execute(array('ID'=>$stateRow->countryID));
		$countryRow = $countrySTMT->fetch(PDO::FETCH_OBJ);

		$address->setID($addressRow->ID);
		$address->setStreet1($addressRow->street1);
		$address->setStreet2($addressRow->street2);
		$address->setCity($addressRow->city);
		$address->setState($stateRow->name);
		$address->setStateID($addressRow->stateID);
		$address->setZipCode($addressRow->zipCode);
		$address->setCountry($countryRow->name);
		$address->setCountryID($stateRow->countryID);
		
		//set PairClass
		$mmPair = new Pair();
		
	}
} else {
	$user = $_SESSION['user'];
	$address = $_SESSION['address'];
}

$mmSelect = "";
if(isset($_REQUEST["mmSelect"])) {
	if ($_REQUEST["mmSelect"] == 0){
		$mmPair->setMenteeID($userID);
		$mmPair->setMentorID($pairID);
		$mmPair->setRequester(1);
		$_SESSION['mmPair'] = $mmPair;
		$mmSelect = "Mentee";
	}else if($_REQUEST["mmSelect"] == 1){
		$mmPair->setMenteeID($pairID);
		$mmPair->setMentorID($userID);
		$mmPair->setRequester(0);
		$_SESSION['mmPair'] = $mmPair;
		$mmSelect = "Mentor";
	}
}

$firstName = $user->getFirstName();
$userPriv = $user->getUserPrivilege();

function passwordToDots($password) {
    $len = strlen($password);
    $hiddenPSW = "";
    for($i = 0; $i < $len; $i++) {
    	$hiddenPSW = $hiddenPSW.'&#9679;';
    }
    return $hiddenPSW;
}
?>
<section id="dashboard">
	<div class="container">
		<div class="row mt-4">
			<div class="col-md-4 col-sm-4">
				<a href="dashboard.php" class="btn btn-primary btn-sm">Back to Dashboard <i class="fas fa-undo-alt"></i></a>
			</div>
			<?php if ($mmSelect != "") { ?>
			<div class="col-md-4 col-sm-4">
				<a href="pairRequest.php" class="btn btn-success btn-sm">Select as <?php echo $mmSelect?></a> <!-- ADD THE LINK TO INSERT TO MMRELATION TABLE HERE -->
			</div>
			<?php } ?>
		</div>
		<div class="row mt-4">
			<div class="col-md-4 col-sm-4" style="padding-right:20px; border-right: 1px solid #ccc;">
				<h3>User Profile</h3>
				<div class="row">
					<img src="<?php echo($user->getResumePath());?>" alt="profile_pic" class="rounded-circle">
				</div>
			</div>
			<div class="col-md-8 col-sm-12">
				<div class="row">
					<div class="col-md-4 col-sm-8">
						<h4>User Information</h4>
					</div>
					<?php if ($boolUser == false) { ?>
					<div class="col-md-8 col-sm-12">
						<p class="lead"><a href="editUserInformation.php">Edit User Information</a></p>
					</div>
					<?php } ?>
				</div>
				<?php if($boolUser == false) {?>
				<div class="row">
					<div class="col-md-4 col-sm-8">
						<p class="lead">UserName:</p>
					</div>
					<div class="col-md-8 col-sm-12">
						<p class="lead"><?php echo($user->getUserName()); ?></p>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-4 col-sm-8">
						<p class="lead">Password:</p>
					</div>
					<div class="col-md-8 col-sm-12">
						<p class="lead"><?php echo(passwordToDots($user->getPassword())); ?> <a href="changePassword.php">Change Password</a></p>
					</div>
				</div>
				<?php } ?>
				<div class="row">
					<div class="col-md-4 col-sm-8">
						<p class="lead">Email:</p>
					</div>
					<div class="col-md-8 col-sm-12">
						<p class="lead"><?php echo($user->getEmail()); ?></p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4 col-sm-8">
						<p class="lead">First Name:</p>
					</div>
					<div class="col-md-8 col-sm-12">
						<p class="lead"><?php echo($user->getFirstName()); ?></p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4 col-sm-8">
						<p class="lead">Last Name:</p>
					</div>
					<div class="col-md-8 col-sm-12">
						<p class="lead"><?php echo($user->getLastName()); ?></p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4 col-sm-8">
						<p class="lead">Phone Number:</p>
					</div>
					<div class="col-md-8 col-sm-12">
						<p class="lead"><?php echo($user->getPhoneNumber()); ?></p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4 col-sm-8">
						<p class="lead">Gender:</p>
					</div>
					<div class="col-md-8 col-sm-12">
						<p class="lead"><?php echo($user->getGender()); ?></p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4 col-sm-8">
						<p class="lead">User Status:</p>
					</div>
					<div class="col-md-8 col-sm-12">
						<p class="lead"><?php echo($user->getUserStatus()); ?></p>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-md-4 col-sm-8">
						<h4>Address Information</h4>
					</div>
					<?php if ($boolUser == false) { ?>
					<div class="col-md-8 col-sm-12">
						<p class="lead"><a href="">Edit Address Information</a></p>
					</div>
					<?php } ?>
				</div>
				<div class="row">
					<div class="col-md-4 col-sm-8">
						<p class="lead">Street 1:</p>
					</div>
					<div class="col-md-8 col-sm-12">
						<p class="lead"><?php echo($address->getStreet1()); ?></p>
					</div>
				</div>
				<?php if($address->getStreet2() != "") {?>
					<div class="row">
						<div class="col-md-4 col-sm-8">
							<p class="lead">Street 2:</p>
						</div>
						<div class="col-md-8 col-sm-12">
							<p class="lead"><?php echo($address->getStreet2()); ?></p>
						</div>
					</div>
				<?php } ?>
				<div class="row">
					<div class="col-md-4 col-sm-8">
						<p class="lead">City:</p>
					</div>
					<div class="col-md-8 col-sm-12">
						<p class="lead"><?php echo($address->getCity()); ?></p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4 col-sm-8">
						<p class="lead">State:</p>
					</div>
					<div class="col-md-8 col-sm-12">
						<p class="lead"><?php echo($address->getState()); ?></p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4 col-sm-8">
						<p class="lead">ZipCode:</p>
					</div>
					<div class="col-md-8 col-sm-12">
						<p class="lead"><?php echo($address->getZipCode()); ?></p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4 col-sm-8">
						<p class="lead">Country:</p>
					</div>
					<div class="col-md-8 col-sm-12">
						<p class="lead"><?php echo($address->getCountry()); ?></p>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-md-4 col-sm-8">
						<h4>Additional Information</h4>
					</div>
					<?php if ($boolUser == false) { ?>
					<div class="col-md-8 col-sm-12">
						<p class="lead"><a href="">Edit Additional Information</a></p>
					</div>
					<?php } ?>
				</div>
				<div class="row">
					<div class="col-md-4 col-sm-8">
						<p class="lead">Facebook Link</p>
					</div>
					<div class="col-md-8 col-sm-12">
						<p class="lead"><a href="https://www.<?php echo($user->getFbLink()); ?>"><?php echo($user->getFbLink()); ?></a></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php include 'footer.php'; ?>