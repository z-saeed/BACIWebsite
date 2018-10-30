<?php 
require_once 'header.php';
require_once 'db_connect.php';


$msg = "";

$userName = "";
$userNameReq = "*";

$firstName = "";
$firstNameReq = "*";

$lastName = "";
$lastNameReq = "*";

$email = "";
$emailReq = "*";
$confirmEmail = "";
$confirmEmailReq = "*";

$password = "";
$passwordReq = "*";
$confirmPassword = "";
$confirmPasswordReq = "*";

$phoneNumber = "";
$gender = "";
$userStatus = "";

$address1 = "";
$address2 = "";
$city = "";
$state = "";
$zip = "";
$country = "";

if (isset($_POST['enter'])) {
	$userName = trim($_POST['userName']);
	$userName = strtolower($userName);
	$checkUserName = $con->prepare('SELECT userName FROM user_tbl WHERE userName = :userName');
	$checkUserName->execute(array('userName'=>$userName));
	if ($checkUserName->rowCount() > 0) {
		$userNameReq = '<span style="color:red">User Name Taken</span>';
	} else {
		$firstName = trim($_POST['firstName']);
		$lastName = trim($_POST['lastName']);

		if(!filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL))
			$emailReq = '<span style="color:red">*</span>';
		else 
			$email = trim($_POST['email']);

		$confirmEmail = trim($_POST['confirmEmail']);
		if(strcmp($email,$confirmEmail) != 0){
			$confirmEmailReq = '<span style="color:red">Does Not Match</span>';
			$confirmEmail = "";
		}

		$password = trim($_POST['password']);
		$confirmPassword = trim($_POST['confirmPassword']);
		if(strcmp($password,$confirmPassword) != 0){
			$confirmPasswordReq = '<span style="color:red">Does Not Match</span>';
			$confirmPassword = "";
		}

		$phoneNumber = trim($_POST['phoneNumber']);
		$gender = trim($_POST['gender']);
		$userStatus = trim($_POST['userStatus']);

		$address1 = trim($_POST['address1']);
		$address2 = trim($_POST['address2']);
		$city = trim($_POST['city']);
		$state = trim($_POST['state']);
		$zip = trim($_POST['zip']);
		$country = trim($_POST['country']);

		$degree = array();
		$major = array();
		$school = array();
		$yearCompleted = array();
		$eduNum = 1;
		while (isset($_POST["degree".$eduNum]) || isset($_POST["degree".$eduNum + 1]) ) {
			array_push($degree, trim($_POST["degree".$eduNum]));
			array_push($major, trim($_POST["major".$eduNum]));
			array_push($school, trim($_POST["school".$eduNum]));
			array_push($yearCompleted, trim($_POST["yearCompleted".$eduNum]));
			$eduNum++;
		}

		$registrationDate = date("Y/m/d");

		if ($confirmEmailReq != "*"|| $confirmPasswordReq != "*" || $userNameReq != "*") {
			$msg = "Please enter valid data";
		} else {
			$stmtAddress = $con->prepare("INSERT INTO address_tbl (ID, street1, street2, city, stateID, zipCode, countryID) VALUES (NULL, :street1, :street2, :city, :stateID, :zipCode, :countryID)");
			$stmtAddress->execute(array('street1'=>$address1, 'street2'=>$address2, 'city'=>$city, 'stateID'=>$state, 'zipCode'=>$zip, 'countryID'=>$country));
			$address_id = $con->lastInsertID();

			$stmtUser = $con->prepare("INSERT INTO user_tbl (userName, password, email, firstName, lastName, phoneNumber, gender, registerDate, userStatus, addressID, userPrivilege, active) VALUES (:userName, :password, :email, :firstName, :lastName, :phoneNumber, :gender, :registerDate, :userStatus, :addressID, :userPrivilege, :active)");
			$stmtUser->execute(array('userName'=>$userName, 'password'=>$password, 'email'=>$email, 'firstName'=>$firstName, 'lastName'=>$lastName, 'phoneNumber'=>$phoneNumber, 'gender'=>$gender, 'registerDate'=>$registrationDate, 'userStatus'=>$userStatus, 'addressID'=>$address_id, 'userPrivilege'=>0, 'active'=>0));
			$user_id = $con->lastInsertID();

			$stmtEdu = $con->prepare("INSERT INTO education_tbl (degree, major, school, yearCompleted, userID) VALUES (:degree, :major, :school, :yearCompleted, :userID)");
			while(!empty($degree)) {
				$stmtEdu->execute(array('degree'=>array_pop($degree), 'major'=>array_pop($major), 'school'=>array_pop($school),  'yearCompleted'=>array_pop($yearCompleted), 'userID'=>$user_id));
			}

			$code = randomCodeGenerator(50); //get random code generated
	        $subject = "Registration Activation"; //set email subject
	        $body = 'Please click the url to activate your account. http://corsair.cs.iupui.edu:23151/BaciProjectAlt/activate.php?code='.$code.'&userID='.$user_id; //set email body
	        $mailer = new Mail();
	        if(($mailer->sendMail($email, $firstName, $subject, $body))){ //send email
	        	$msg = "Email Sent";
	        	Header ("Location:userConfirmation.php?email=".$email);
	        }
		}
	}
}

?>

<div class="container" id="registration">
	<section id="registrationHeader">
		<h2>Registeration</h2>
	</section>
	
	<?php echo $msg; ?>
	<form action="registration.php" method="post">
		<div class="form-row">
			<div class="form-group col-md-6 col-sm-12">
				<label for="userName">User Name <?php echo $userNameReq; ?></label>
				<input type="text" class="form-control" id="userName" name="userName" required>
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col-md-6 col-sm-12">
				<label for="firstName">First Name <?php echo $firstNameReq; ?></label>
				<input type="text" class="form-control" id="firstName" required name="firstName">
			</div>
			<div class="form-group col-md-6 col-sm-12">
				<label for="lastName">Last Name <?php echo $lastNameReq; ?></label>
				<input type="text" class="form-control" id="lastName" required name="lastName">
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col-md-6 col-sm-12">
				<label for="email">Email <?php echo $emailReq; ?></label>
				<input type="email" class="form-control" id="email" required name="email">
			</div>
			<div class="form-group col-md-6 col-sm-12">
				<label for="confirmEmail">Confirm Email <?php echo $confirmEmailReq; ?></label>
				<input type="email" class="form-control" id="confirmEmail" required name="confirmEmail">
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col-md-6 col-sm-12">
				<label for="password">Password <?php echo $passwordReq; ?></label>
				<input type="password" class="form-control" id="password" required name="password">
			</div>
			<div class="form-group col-md-6 col-sm-12">
				<label for="confirmPassword">Confirm Password <?php echo $confirmPasswordReq; ?></label>
				<input type="password" class="form-control" id="confirmPassword" required name="confirmPassword">
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col-md-6 col-sm-12">
				<label for="phoneNumber">Phone Number</label>
				<input type="text" class="form-control" id="phoneNumber" name="phoneNumber">
			</div>
			<div class="form-group col-md-3 col-sm-6">
				<label for="gender">Gender</label>
				<select id="gender" class="form-control" name="gender">
					<option value="0" selected>Male</option>
					<option value="1">Female</option>				
				</select>
			</div>
			<div class="form-group col-md-3 col-sm-6">
				<label for="userType">User Status</label>
				<select id="userType" class="form-control" name="userStatus">
					<option value="0" selected>Mentee</option>
					<option value="1">Mentor</option>
					<option value="2">Other</option>					
				</select>
			</div>
		</div>
		<hr>
		<div class="form-row">
			<div class="form-group col-md-6 col-sm-12">
				<label for="address1">Address</label>
				<input type="text" class="form-control" id="address1" name="address1">
			</div>
			<div class="form-group col-md-6 col-sm-12">
				<label for="address2">Address 2</label>
				<input type="text" class="form-control" id="address2" name="address2">
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col-md-4 col-sm-8">
			<label for="city">City</label>
			<input type="text" class="form-control" id="city" name="city">
			</div>
			<div class="form-group col-md-3 col-sm-6">
				<label for="state">State</label>
				<?php 
				$result = $con->query("select * from state_tbl");
				echo '<select id="state" class="form-control" name="state">';
				while($row = $result->fetch(PDO::FETCH_ASSOC)) {
					echo "<option value='" . $row['ID'] ."'>" . $row['stateName'] ."</option>";
				}
				echo "</select>";
				?>
			</div>
			<div class="form-group col-md-2 col-sm-4">
				<label for="zip">Zip Code</label>
				<input type="text" class="form-control" id="zip" name="zip">
			</div>
			<div class="form-group col-md-3 col-sm-6">
				<label for="country">Country</label>
				<?php 
				$result = $con->query("select * from country_tbl");
				echo '<select id="country" class="form-control" name="country">';
				while($row = $result->fetch(PDO::FETCH_ASSOC)) {
					echo "<option value='" . $row['ID'] ."'>" . $row['countryName'] ."</option>";
				}
				echo "</select>";
				?>
			</div>
		</div>
		<hr>
		<div class="form-row">
			<div class="form-group col-md-3 col-sm-8">
				<a href="#" class="btn btn-success" onclick="addEducation()">Add Education</a>
			</div>
		</div>
		<div id="dynamicEducation"></div>
		<hr>
		<div class="form-row">
			<div class="form-group col-md-4 col-sm-8">
				<label for="employment">Student/Working Professional</label>
				<select id="employment" class="form-control" name="employment">
					<option value="student" selected>Student</option>
					<option value="workingProfessional">Working Professional</option>				
				</select>
			</div>
			<div class="form-group col-md-4 col-sm-8 workingProfessional">
				<label for="field">Field</label>
				<input type="text" class="form-control" id="field">
			</div>
			<div class="form-group col-md-4 col-sm-8 workingProfessional">
				<label for="employer">Employer</label>
				<input type="text" class="form-control" id="employer">
			</div>
		</div>
		<hr>
		<button type="submit" class="btn btn-primary" name="enter">Register</button>
	</form>
</div>

<?php include 'footer.php'; ?>