<?php 
include 'header.php';

if($_SESSION['loggedin'] == false) {
	header('Location: login.php'); 
}

include 'db_connect.php';

$user = $_SESSION['user'];
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
			<form action="editUserInformation.php">
				<div class="form-row">
					<div class="col-md-4 col-sm-8">
						<p class="lead">UserName:</p>
					</div>
					<div class="form-group col-md-8 col-sm-12">
						<input type="text" class="form-control editUser" id="userName" name="userName" value="<?php echo($user->getUserName()); ?>">
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-4 col-sm-8">
						<p class="lead">Email:</p>
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
			</form>
		</div>
	</div>
</section>
<?php 
include 'footer.php';
?>