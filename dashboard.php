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
<section id="dashboard">
	<div class="container">

		<?php if ($userPriv == 3) {?>
		<h3>Super-Admin Dashboard</h3>
		<div class="row mt-1">
			<div class="col-sm-4">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Add Super Admin</h5>
						<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
						<a href="#" class="btn btn-danger">Add Super Admin</a>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Delete User</h5>
						<p class="card-text">Delete a User, Coordinator, or Admin from the database.</p>
						<a href="#" class="btn btn-danger">Delete User</a>
					</div>
				</div>
			</div>
		</div>	
		<hr>
	<?php } ?>
	
	<?php if ($userPriv == 2 || $userPriv == 3) {?>
		<h3>Admin Dashboard</h3>
		<div class="row mt-1">
			<div class="col-sm-4">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">User List</h5>
						<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
						<a href="#" class="btn btn-warning">User List</a>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Add User</h5>
						<p class="card-text">Add a User, Coordinator, or Admin Manually</p>
						<a href="addUser.php" class="btn btn-warning">Add User</a>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">User Search</h5>
						<p class="card-text">Search for a registered user and view thier profile</p>
						<a href="#" class="btn btn-warning">User Search</a>
					</div>
				</div>
			</div>
		</div>
		<div class="row mt-1">
			<div class="col-sm-4">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Configure Country list</h5>
						<p class="card-text">Add, edit or delete a country from the database</p>
						<a href="configureCountry.php" class="btn btn-warning">Configure Country list</a>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Configure State list</h5>
						<p class="card-text">Add, edit or delete a state from the database</p>
						<a href="configureState.php" class="btn btn-warning">Configure State list</a>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Configure Degree Level list</h5>
						<p class="card-text">Add, edit or delete an educational degree from the database</p>
						<a href="configureDegree.php" class="btn btn-warning">Configure Degree level list</a>
					</div>
				</div>
			</div>
		</div>	
		<hr>
	<?php } ?>

	<?php if ($userPriv == 1 || $userPriv == 2 || $userPriv == 3) {?>
		<h3>Coordinator Dashboard</h3>
		<div class="row mt-1">
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
						<h5 class="card-title">Mentor List</h5>
						<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
						<a href="#" class="btn btn-primary">Mentor List</a>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Mentee List</h5>
						<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
						<a href="#" class="btn btn-primary">Mentor List</a>
					</div>
				</div>
			</div>
		</div>
		<div class="row mt-1">
			<div class="col-sm-4">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Pending Pairings</h5>
						<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
						<a href="#" class="btn btn-primary">Pending Pairings</a>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Current Pairings</h5>
						<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
						<a href="#" class="btn btn-primary">Current Pairings</a>
					</div>
				</div>
			</div>
		</div>
		<hr>
	<?php } ?>

		<h3>User Dashboard</h3>
		<div class="row mt-1">
			<div class="col-sm-4">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">User Profile</h5>
						<p class="card-text">View and Edit your public profile.</p>
						<a href="userProfile.php" class="btn btn-success">User Profile</a>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Upload Files</h5>
						<p class="card-text">Upload a picture or resume to your profile</p>
						<a href="fileUpload.php" class="btn btn-success">Upload Files</a>
					</div>
				</div>
			</div>
		</div>

	</div>
</section>