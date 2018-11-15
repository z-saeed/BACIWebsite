<?php 
include 'header.php';
include 'db_connect.php';

if($_SESSION['loggedin'] == false) {
	header('Location: login.php'); 
}

$user = $_SESSION['user'];
$address = $_SESSION['address'];

$addressID = $address->getID();
$street1 = "";
$street2 = "";
$city = "";
$state = "";
$zipCode = "";
$country = "";


$success = "";

if (isset($_POST['update'])) {

	$street1 = trim($_POST['street1']);
	$street2 = trim($_POST['street2']);
	$city = trim($_POST['city']);
	$zipCode = trim($_POST['zipCode']);
	
	$updateAddressInfo = $con->prepare("UPDATE address_tbl SET street1 = '$street1', street2 = '$street2', city = '$city', stateID = '$s', zipCode = '$zipCode' WHERE ID = '$addressID'");
	$updateAddressInfo->execute(array());
	$address->setStreet1($addressRow->street1);
	$address->setStreet2($addressRow->street2);
	$address->setCity($addressRow->city);
	$address->setState($stateRow->name);
	$address->setZipCode($addressRow->zipCode);
	$address->setCountry($countryRow->name);

	$success = "Update Successful";

}
?>

<section id="editAddressInfo">
	<div id="userAddressCell">
		<div class="container">
			<div class="row mt-4">
				<div class="col-md-4 col-sm-8">
					<h4>Edit Address Information</h4>
				</div>
				<div class="col-md-8 col-sm-12">
					<p class="lead">Click the information you wish to edit</p>
				</div>
			</div>
			<form action="editAddressInformation.php" method="post">
				<div class="form-row">
					<div class="col-md-4 col-sm-8">
						<p class="lead">Street 1:</p>
					</div>
					<div class="form-group col-md-8 col-sm-12">
						<input type="text" class="form-control editUser" id="street1" name="street1" value="<?php echo($address->getStreet1()); ?>">
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-4 col-sm-8">
						<p class="lead">Street 2:</p>
					</div>
					<div class="form-group col-md-8 col-sm-12">
						<input type="text" class="form-control editUser" id="street2" name="street2" value="<?php echo($address->getStreet2()); ?>">
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-4 col-sm-8">
						<p class="lead">City:</p>
					</div>
					<div class="form-group col-md-8 col-sm-12">
						<input type="text" class="form-control editUser" id="city" name="city" value="<?php echo($address->getCity()); ?>">
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-4 col-sm-8">
						<p class="lead">Zip Code:</p>
					</div>
					<div class="form-group col-md-8 col-sm-12">
						<input type="text" class="form-control editUser" id="zipCode" name="zipCode" value="<?php echo($address->getZipCode()); ?>">
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-4 col-sm-8">
						<p class="lead">State:</p>
					</div>
					<div class="form-group col-md-8 col-sm-12">
						<select id="state" class="form-control" name="state">
							<?php 
							$result = $con->query("select * from state_tbl ORDER BY name ASC");
							echo '<select id="state" class="form-control" name="state">';
							while($row = $result->fetch(PDO::FETCH_ASSOC)) {
								echo "<option value='" . $row['ID'] ."'>" . $row['name'] ."</option>";
							}
							echo "</select>";
							?>
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-4 col-sm-8">
						<p class="lead">Country:</p>
					</div>
					<div class="form-group col-md-8 col-sm-12">
						<select id="country" class="form-control" name="country">
							<?php 
							$result = $con->query("select * from country_tbl ORDER BY name ASC");
							echo '<select id="country" class="form-control" name="country">';
							while($row = $result->fetch(PDO::FETCH_ASSOC)) {
								echo "<option value='" . $row['ID'] ."'>" . $row['name'] ."</option>";
							}
							echo "</select>";
							?>
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-4 col-sm-8">
						<a href="userProfile.php" class="btn btn-secondary btn-sm">Back to User Profile <i class="fas fa-undo-alt"></i></a>
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