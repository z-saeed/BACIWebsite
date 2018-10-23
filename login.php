<?php 
include 'header.php';
require_once 'db_connect.php';

$userName = "";
$password = "";

$msg = "Login";

$user = new User();
$address = new Address();

if (isset($_POST['login'])) {

	$userName = trim($_POST['userName']);
	$password = trim($_POST['password']);


	$loginStmt = $con->prepare('SELECT * FROM user_tbl WHERE userName = :userName AND password = :password');
	$loginStmt->execute(array('userName'=>$userName, 'password'=>$password));
	$row = $loginStmt->fetch(PDO::FETCH_OBJ);

	if($loginStmt->rowCount() != 1) {
		$msg = "Login Unsuccessful. Please Try Again.";
	} else {
		if ($row->active == 0)
			$msg = "Login Unsuccessful. Account isnt Activated.";
		else {
			$_SESSION['loggedin'] = true;
			$user->setID($row->ID);
			$user->setUserName($row->userName);
			$user->setPassword($row->password);
			$user->setEmail($row->email);
			$user->setFirstName($row->firstName);
			$user->setLastName($row->lastName);
			$user->setPhoneNumber($row->phoneNumber);
			$user->setGender($row->gender);
			$user->setUserStatus($row->userStatus);
			$user->setAddressID($row->addressID);
			$user->setUserPrivilege($row->userPrivilege);
			$_SESSION['user'] = $user;

			$addressSTMT = $con->prepare('SELECT * FROM address_tbl WHERE ID = :ID');
			$addressSTMT->execute(array('ID'=>$user->getAddressID()));
			$addressRow = $addressSTMT->fetch(PDO::FETCH_OBJ);

			$stateSTMT = $con->prepare('SELECT * FROM state_tbl WHERE ID = :ID');
			$stateSTMT->execute(array('ID'=>$addressRow->stateID));
			$stateRow = $stateSTMT->fetch(PDO::FETCH_OBJ);

			$countrySTMT = $con->prepare('SELECT * FROM country_tbl WHERE ID = :ID');
			$countrySTMT->execute(array('ID'=>$addressRow->countryID));
			$countryRow = $countrySTMT->fetch(PDO::FETCH_OBJ);

			$address->setID($addressRow->ID);
			$address->setStreet1($addressRow->street1);
			$address->setStreet2($addressRow->street2);
			$address->setCity($addressRow->city);
			$address->setState($stateRow->stateName);
			$address->setStateID($addressRow->stateID);
			$address->setZipCode($addressRow->zipCode);
			$address->setCountry($countryRow->Country);
			$address->setCountryID($addressRow->countryID);

			$_SESSION['address'] = $address;

			Header ("Location:dashboard.php");
		}
	}

}
?>

<section id="loginPage">
	
	<div id="login">
		<div id="loginForm">
			<h3><?php echo $msg; ?></h3>
			<form action="login.php" method="post">
				<div class="form-row">
					<div class="form-group col-md-4 col-sm-8 offset-md-4 offset-sm-2">
						<input type="text" class="form-control" id="userName" name="userName" placeholder="User Name" required>
					</div>
				</div>
				<div class="form-row">
					<div class="form-group col-md-4 col-sm-8 offset-md-4 offset-sm-2">
						<input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
					</div>
				</div>
				<div class="form-row">
					<div class="form-group col-md-4 col-sm-8 offset-md-4 offset-sm-2">
						<button type="submit" class="btn btn-light btn-sm" name="login">Login <i class="far fa-arrow-alt-circle-right"></i></button>
					</div>
				</div>
			</form>
		</div>
	</div>

</section>