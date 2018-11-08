<?php 
require_once 'header.php';
require_once "db_connect.php";

//verify logged in as a admin
$user = $_SESSION['user'];
if($_SESSION['loggedin'] == false) {
	header('Location: login.php'); 
}
$userPriv = $user->getUserPrivilege();
if($userPriv < 2 || $userPriv > 3){
	header('Location: dashboard.php');
}	
			
//initialize variable
$state = "";
$msgState = "";
$country="";

//show states for selected country to database
if(isset($_POST['show'])) {
	$msgState = "";
	$countryID = trim($_POST['countryIDShow']);
	$countryName = $con->query("select * from country_tbl");
	while($rowCountryName = $countryName->fetch(PDO::FETCH_ASSOC)) {
		if($rowCountryName['ID'] == $countryID)
			$country = $rowCountryName['name'];
	}
	$msgState = "The states currently in ".$country." are : "."</br>";
	$resultShow = $con->query("select * from state_tbl ORDER BY name ASC");
	while($rowShow = $resultShow->fetch(PDO::FETCH_ASSOC)) {
		if($rowShow['countryID'] == $countryID)
			$msgState = $msgState.$rowShow['name']."</br>";
	}
}

//add to database
if(isset($_POST['add'])) {
	$newState = trim($_POST['addState']);
	$countryID = trim($_POST['countryID']);
	$stmt = $con->prepare('INSERT INTO state_tbl (ID, name, countryID) VALUES (Null, :state, :countryID)');
	$stmt->execute(array('state' => $newState, 'countryID' => $countryID));
}

//edit from database
if(isset($_POST['edit'])){
		$stateNum = trim($_POST['stateNameEdit']);
		$state = trim($_POST['editState']);
		$stmt = $con->prepare('UPDATE state_tbl SET name = :name WHERE ID = :num');
		$stmt->execute(array('name' => $state, 'num' => $stateNum));
	}	

//delete from database
if(isset($_POST['delete'])){
		$stmt = $con->prepare('DELETE FROM state_tbl WHERE ID = :stateID');
		$stmt->execute(array('stateID' => $_POST['stateNameRemove']));
	}		
	
$result = $con->query("select * from state_tbl ORDER BY name ASC");
$resultCountry = $con->query("select name from country_tbl ORDER BY name ASC");
?>

<div class="container" id="configureState">
	<section id="blankHeader">
		<div class="row mt-4">
			<div class="col-sm-12">
				<a href="dashboard.php" class="btn btn-secondary btn-sm">Back to Dashboard <i class="fas fa-undo-alt"></i></a>
			</div>
		</div>
		<div class="row mt-3">
			<div class="col-sm-6 col-md-4" style="padding-right:20px; border-right: 1px solid #ccc;">
				<!-- PRINT ALL STATES-->
				<h4>List of states in current database are:</h4>
				
				<!-- editing -->
				<form action="configureState.php" method="post">
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<label class="input-group-text" for="countryIDShow">Country: </label>
						</div>
						<select class="custom-select" name="countryIDShow">
							<?php
							$result1 = $con->query("select * from country_tbl ORDER BY name ASC");
							while($row1 = $result1->fetch(PDO::FETCH_ASSOC)) {
								echo "<option value = '".$row1['ID']."'>".$row1['name']."</option>";
							}
							?>
						</select>
						<div class="input-group-append">
							<button type="submit" class="btn btn-outline-danger" name="show">Show States</button>
						</div>
					</div>
					<?php echo $msgState?>
				</form>

				
			</div>
			<div class="col-sm-6 col-md-8">
				<div class="row">
					<div class="col-sm-12">
					<!-- ADD STATES-->
						<h4>Add State</h4>
						<form action="configureState.php" method="post">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<label class="input-group-text" for="stateNameEdit">State</label>
								</div>
								<input type="text" class="form-control" name="addState">
								<div class="input-group-prepend">
									<label class="input-group-text" for="countryID">Country</label>
								</div>
								<select class="custom-select" name="countryID">
									<?php
									$result1 = $con->query("select * from country_tbl ORDER BY name ASC");
									while($row1 = $result1->fetch(PDO::FETCH_ASSOC)) {
										echo "<option value = '".$row1['ID']."'>".$row1['name']."</option>";
									}
									?>
								</select>
								<div class="input-group-append">
									<button type="submit" class="btn btn-outline-primary" name="add">Add State</button>
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class="row mt-2">
					<div class="col-sm-12">
					<!-- EDIT STATES-->
						<h4>Edit State</h4>
						<form action="configureState.php" method="post">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<label class="input-group-text" for="stateNameEdit">States</label>
								</div>
								<select class="custom-select" name="stateNameEdit">
									<?php
									$result1 = $con->query("select * from state_tbl ORDER BY name ASC");
									while($row1 = $result1->fetch(PDO::FETCH_ASSOC)) {
										echo "<option value = '".$row1['ID']."'>".$row1['name'].", ".$row1['countryID']."</option>";
									}
									?>
								</select>
								<input type="text" class="form-control" name="editState">
								<div class="input-group-append">
									<button type="submit" class="btn btn-outline-primary" name="edit">Edit State</button>
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class="row mt-2">
					<div class="col-sm-12">
					<!-- REMOVE STATES-->
						<h4>Remove State</h4>
						<form action="configureState.php" method="post">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<label class="input-group-text" for="stateNameRemove">States</label>
								</div>
								<select class="custom-select" name="stateNameRemove">
									<?php
									$result1 = $con->query("select * from state_tbl ORDER BY name ASC");
									while($row1 = $result1->fetch(PDO::FETCH_ASSOC)) {
										echo "<option value = '".$row1['ID']."'>".$row1['name'].", ".$row1['countryID']."</option>";
									}
									?>
								</select>
								<div class="input-group-append">
									<button type="submit" class="btn btn-outline-danger" name="delete">Remove State</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		
	</section>
	
</div>
