<?php 
include 'header.php';
include 'db_connect.php';

if($_SESSION['loggedin'] == false) {
	header('Location: login.php'); 
}

$user = $_SESSION['user'];

$userID = $user->getID();
$userName = "";
$email = "";
$firstName = "";
$lastName = "";
$phoneNumber = "";
$gender = "";
$userStatus = "";

$userNameReq = "";
$emailReq = "";

$success = "";

if (isset($_POST['update'])) {
	if(!filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL))
		$emailReq = '<span style="color:red">Please Enter a Valid Email</span>';
	else 
		$email = trim($_POST['email']);

	$firstName = trim($_POST['firstName']);
	$lastName = trim($_POST['lastName']);
	$phoneNumber = trim($_POST['phoneNumber']);
	$gender = trim($_POST['gender']);
	$userStatus = trim($_POST['userStatus']);
	if($userNameReq == "") {
		$updateUserInfo = $con->prepare("UPDATE user_tbl SET email = '$email', firstName = '$firstName', lastName = '$lastName', gender = '$gender', userStatus = '$userStatus' WHERE ID = '$userID'");
		$updateUserInfo->execute(array());
		$user->setFirstName($firstName);
		$user->setLastName($lastName);
		$user->setEmail($email);
		$user->setGender($gender);
		$user->setPhoneNumber($phoneNumber);
		$user->setUserStatus($userStatus);

		$success = "Update Successful";
	}

}
?>

<section id="editUserInfo">
	<div id="userInfoCell">
		<div class="container">
			<div class="row">
				<div class="col-md-4 col-sm-8">
					<h4>Edit User Information</h4>
				</div>
				<div class="col-md-8 col-sm-12">
					<p class="lead">Click the information you wish to edit</p>
				</div>
			</div>
			<form action="editUserInformation.php" method="post">
				<div class="form-row">
					<div class="col-md-4 col-sm-8">
						<p class="lead">Email: <?php echo $emailReq; ?></p>
					</div>
					<div class="col-md-8 col-sm-12">
						<input type="text" class="form-control editUser" id="email" name="email" value="<?php echo($user->getEmail()); ?>">
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-4 col-sm-8">
						<p class="lead">First Name:</p>
					</div>
					<div class="form-group col-md-8 col-sm-12">
						<input type="text" class="form-control editUser" id="firstName" name="firstName" value="<?php echo($user->getFirstName()); ?>">
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-4 col-sm-8">
						<p class="lead">Last Name:</p>
					</div>
					<div class="form-group col-md-8 col-sm-12">
						<input type="text" class="form-control editUser" id="lastName" name="lastName" value="<?php echo($user->getLastName()); ?>">
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-4 col-sm-8">
						<p class="lead">Phone Number:</p>
					</div>
					<div class="form-group col-md-8 col-sm-12">
						<input type="text" class="form-control editUser" id="phoneNumber" name="phoneNumber" value="<?php echo($user->getPhoneNumber()); ?>">
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-4 col-sm-8">
						<p class="lead">Gender:</p>
					</div>
					<div class="form-group col-md-8 col-sm-12">
						<select id="gender" class="form-control" name="gender">
							<option value="0" <?php if($user->getGender() == "Male") echo "selected"  ?>>Male</option>
							<option value="1" <?php if($user->getGender() != "Male") echo "selected"  ?>>Female</option>				
						</select>
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-4 col-sm-8">
						<p class="lead">User Status:</p>
					</div>
					<div class="form-group col-md-8 col-sm-12">
						<select id="userType" class="form-control" name="userStatus">
							<option value="0" <?php if($user->getUserStatus() == "Mentee") echo "selected"  ?>>Mentee</option>
							<option value="1" <?php if($user->getUserStatus() == "Mentor") echo "selected"  ?>>Mentor</option>
							<option value="2" <?php if($user->getUserStatus() != "Mentor" && $user->getUserStatus() != "Mentee") echo "selected"  ?>>Other</option>					
						</select>
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-4 col-sm-8">
						<a href="dashboard.php" class="btn btn-secondary btn-sm">Back to Dashboard <i class="fas fa-undo-alt"></i></a>
					</div>
					<div class="form-group col-sm-12 col-md-8">
						<button type="submit" class="btn btn-dark btn-sm" name="update">Update <i class="fas fa-cloud-upload-alt"></i></button>
						<?php echo $success; ?>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>
<?php 
include 'footer.php';
?>