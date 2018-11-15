<?php 
include 'header.php';
include 'db_connect.php';

if($_SESSION['loggedin'] == false) {
	header('Location: login.php'); 
}

$eduID = $_GET['num'];

$eduSTMT = $con->prepare('SELECT * FROM education_tbl WHERE ID = :ID');
$eduSTMT->execute(array('ID'=>$eduID));
$eduRow = $eduSTMT->fetch(PDO::FETCH_OBJ);

$degree = $eduRow['degreeType'];
$major = $eduRow['major'];
$schoolName = $eduRow['schoolName'];
$completionYear = $eduRow['completionYear'];

if (isset($_POST['update'])) {
	// if(!filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL))
	// 	$emailReq = '<span style="color:red">Please Enter a Valid Email</span>';
	// else 
	// 	$email = trim($_POST['email']);

	// $firstName = trim($_POST['firstName']);
	// $lastName = trim($_POST['lastName']);
	// $phoneNumber = trim($_POST['phoneNumber']);
	// $gender = trim($_POST['gender']);
	// $userStatus = trim($_POST['userStatus']);
	
	// $updateUserInfo = $con->prepare("UPDATE user_tbl SET email = '$email', firstName = '$firstName', lastName = '$lastName', gender = '$gender', userStatus = '$userStatus' WHERE ID = '$userID'");
	// $updateUserInfo->execute(array());
	// $user->setFirstName($firstName);
	// $user->setLastName($lastName);
	// $user->setEmail($email);
	// $user->setGender($gender);
	// $user->setPhoneNumber($phoneNumber);
	// $user->setUserStatus($userStatus);

	// $success = "Update Successful";

}
?>

<section id="editUserInfo">
	<div id="userInfoCell">
		<div class="container">
			<div class="row">
				<div class="col-md-4 col-sm-8">
					<h4>Edit Education Information</h4>
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
			</form>
		</div>
	</div>
</section>
<?php 
include 'footer.php';
?>