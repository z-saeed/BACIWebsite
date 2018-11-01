<?php 
include 'header.php';

if($_SESSION['loggedin'] == false) {
	header('Location: login.php'); 
}

$user = $_SESSION['user'];
$address = $_SESSION['address'];

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

<?php if ($userPriv == 0) { //IF USER has privilege 0 (GENERAL USER)?>
<section id="dashboard">
	<div class="container">
		<div class="row">
			<div class="col-md-2 col-sm-4" style="padding-right:20px; border-right: 1px solid #ccc;">
				<h3>Dashboard</h3>
				<?php 
				if ($user->getUserStatus() == 'Mentee' || $user->getUserStatus() == 'Other') { ?>
				<div class="row">
					<div class="col-md-4 col-sm-8">
						<h4><a href="#">View Mentors</a></h4>
					</div>
				</div>
				<?php 
				}
				if ($user->getUserStatus() == 'Mentor' || $user->getUserStatus() == 'Other') { ?>
				<div class="row">
					<div class="col-md-4 col-sm-8">
						<h4><a href="#">View Mentees</a></h4>
					</div>
				</div>
				<?php } ?>
			</div>
			<div class="col-md-10 col-sm-12">
				<div class="row">
					<div class="col-md-4 col-sm-8">
						<h4>User Information</h4>
					</div>
					<div class="col-md-8 col-sm-12">
						<p class="lead"><a href="editUserInformation.php">Edit User Information</a></p>
					</div>
				</div>
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
					<div class="col-md-8 col-sm-12">
						<p class="lead"><a href="">Edit Address Information</a></p>
					</div>
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
			</div>
		</div>
	</div>
</section>
<?php } else if ($userPriv == 2) {?>

<section id="dashboard">
	<div class="container">
		<h3>Admin Dashboard</h3>
		<div class="row">
			<div class="col-sm-4">
				<div class="card">
					<div class="card-body">
							<h5 class="card-title">User List</h5>
							<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
							<a href="#" class="btn btn-primary">User List</a>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Configure Country list</h5>
						<p class="card-text">Add, edit or delete a country from the database</p>
						<a href="configureCountry.php" class="btn btn-primary">Configure Country list</a>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Configure State list</h5>
						<p class="card-text">Add, edit or delete a state from the database</p>
						<a href="configureState.php" class="btn btn-primary">Configure State list</a>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Configure Degree Level list</h5>
						<p class="card-text">Add, edit or delete an educational degree from the database</p>
						<a href="configureDegree.php" class="btn btn-primary">Configure Degree level list</a>
					</div>
				</div>
			</div>
		</div>	
	</div>
</section>

<?php } ?>