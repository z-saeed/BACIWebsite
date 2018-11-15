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
$tosre = "*";

$fbLink = "";
$twLink = "";
$lkdLink = "";


if (isset($_POST['enter'])) {
	$userName = trim($_POST['userName']);
	$userName = strtolower($userName);
	$checkUserName = $con->prepare('SELECT username FROM user_tbl WHERE username = :username');
	$checkUserName->execute(array('username'=>$userName));
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
		while (isset($_POST["degree".$eduNum])) {
			array_push($degree, trim($_POST["degree".$eduNum]));
			array_push($major, trim($_POST["major".$eduNum]));
			array_push($school, trim($_POST["school".$eduNum]));
			array_push($yearCompleted, trim($_POST["yearCompleted".$eduNum]));
			$eduNum++;
		}

		$employment = trim($_POST['employment']);
		$field = trim($_POST['field']);
		$employer = trim($_POST['employer']);

		$fbLink = trim($_POST['fbLink']);
		$twLink = trim($_POST['twLink']);
		$lkdLink = trim($_POST['lkdLink']);

		$registrationDate = date("Y/m/d");
		
		if(!isset($_POST['tos']))
			$tosre = '<span style="color:red">*</span>';

		if ($confirmEmailReq != "*"|| $confirmPasswordReq != "*" || $userNameReq != "*" || $tosre != "*") {
			$msg = "Please enter valid data";
		} else {
			$code = randomCodeGenerator(50); //get random code generated

			$stmtAddress = $con->prepare("INSERT INTO address_tbl (ID, street1, street2, city, stateID, zipCode) VALUES (NULL, :street1, :street2, :city, :stateID, :zipCode)");
			$stmtAddress->execute(array('street1'=>$address1, 'street2'=>$address2, 'city'=>$city, 'stateID'=>$state, 'zipCode'=>$zip));
			$address_id = $con->lastInsertID();

			$stmtID = $con->prepare("INSERT INTO identity_tbl (employment, field, employer) VALUES (:employment, :field, :employer)");
        	$stmtID->execute(array('employment'=>$employment, 'field'=>$field, 'employer'=>$employer));
        	$identity_id = $con->lastInsertId();

			/* Header ("Location:blankPage.php?username=".$username."?email=".$email."?password=".$password."?firstName=".$firstName."?lastName=".$lastName."?gender=".$gender."?addressID=".$address_id."?phone=".$phoneNumber."?identityID=".$identity_id."?registerDate=".$registrationDate."?activationURL=".$code."?active=0"."?privilege=0"."?userStatus=".$userStatus); */
			$stmtUser = $con->prepare("INSERT INTO user_tbl (`ID`, `username`, `email`, `password`, `firstName`, `lastName`, `gender`, `addressID`, `phone`, `identityID`, `fbLink`, `twLink`, `lkdLink`, `resumeID`, `pictureID`, `registerDate`, `activationURL`, `active`, `privilege`, `userStatus`) VALUES (NULL, :username, :email, :password, :firstName, :lastName, :gender, :addressID, :phone, :identityID, :fbLink, :twLink, :lkdLink, 1, 1, :registerDate, :activationURL, :active, :privilege, :userStatus)");
			$stmtUser->execute(array('username'=>$userName, 'email'=>$email, 'password'=>$password, 'firstName'=>$firstName, 'lastName'=>$lastName, 'gender'=>$gender, 'addressID'=>$address_id, 'phone'=>$phoneNumber, 'identityID'=>$identity_id, 'fbLink'=>$fbLink, 'twLink'=>$twLink, 'lkdLink'=>$lkdLink, 'registerDate'=>$registrationDate, 'activationURL'=>$code, 'active'=>0, 'privilege'=>0, 'userStatus'=>$userStatus));
			$user_id = $con->lastInsertID();

			$stmtEdu = $con->prepare("INSERT INTO education_tbl (degreeType, major, schoolName, completionYear, userID) VALUES (:degree, :major, :school, :yearCompleted, :userID)");
			while(!empty($degree)) {
				$stmtEdu->execute(array('degree'=>array_pop($degree), 'major'=>array_pop($major), 'school'=>array_pop($school),  'yearCompleted'=>array_pop($yearCompleted), 'userID'=>$user_id));
			}

	        $subject = "Registration Activation"; //set email subject
	        $body = 'Please click the url to activate your account. http://corsair.cs.iupui.edu:23041/CourseProject/BaciProjectAlt/activate.php?code='.$code.'&userID='.$user_id; //set email body
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
		<h2>Registration</h2>
	</section>
	
	<?php echo $msg; ?>
	<form action="registration.php" method="post">
		<div class="form-row">
			<div class="form-group col-md-6 col-sm-12">
				<label for="userName">User Name <?php echo $userNameReq; ?></label>
				<input type="text" class="form-control" id="userName" value="<?php print $userName; ?>" name="userName" required>
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col-md-6 col-sm-12">
				<label for="firstName">First Name <?php echo $firstNameReq; ?></label>
				<input type="text" class="form-control" id="firstName" value="<?php print $firstName; ?>" required name="firstName">
			</div>
			<div class="form-group col-md-6 col-sm-12">
				<label for="lastName">Last Name <?php echo $lastNameReq; ?></label>
				<input type="text" class="form-control" id="lastName" value="<?php print $lastName; ?>" required name="lastName">
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col-md-6 col-sm-12">
				<label for="email">Email <?php echo $emailReq; ?></label>
				<input type="email" class="form-control" id="email" value="<?php print $email; ?>" required name="email">
			</div>
			<div class="form-group col-md-6 col-sm-12">
				<label for="confirmEmail">Confirm Email <?php echo $confirmEmailReq; ?></label>
				<input type="email" class="form-control" id="confirmEmail" value="<?php print $confirmEmail; ?>" required name="confirmEmail">
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
			<div class="form-group col-md-3 col-sm-6">
				<label for="phoneNumber">Phone Number</label>
				<input type="number" class="form-control" id="phoneNumber" value="<?php print $phoneNumber; ?>" name="phoneNumber">
			</div>
			<div class="form-group col-md-3 col-sm-6">
				<label for="gender">Gender</label>
				<select id="gender" class="form-control" name="gender">
					<option value="0" selected>Male</option>
					<option value="1">Female</option>				
				</select>
			</div>
			<div class="form-group col-md-3 col-sm-6">
				<label for="birthYear">Birth Year</label>
				<select name="birthYear" id="birthYear" class="form-control"></select>
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
				<input type="text" class="form-control" id="address1" value="<?php print $address1; ?>" name="address1">
			</div>
			<div class="form-group col-md-6 col-sm-12">
				<label for="address2">Address 2</label>
				<input type="text" class="form-control" id="address2" value="<?php print $address2; ?>" name="address2">
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col-md-4 col-sm-8">
			<label for="city">City</label>
			<input type="text" class="form-control" id="city" value="<?php print $city; ?>" name="city">
			</div>
			<div class="form-group col-md-3 col-sm-6">
				<label for="state">State</label>
				<?php 
				$resultState = $con->query("select * from state_tbl WHERE active = 1 ORDER BY name ASC");
				echo '<select id="state" class="form-control" name="state">';
				while($rowState = $resultState->fetch(PDO::FETCH_ASSOC)) {
					echo "<option value='" . $rowState['ID'] ."'>" . $rowState['name'] ."</option>";
				}
				echo "</select>";
				?>
			</div>
			<div class="form-group col-md-2 col-sm-4">
				<label for="zip">Zip Code</label>
				<input type="text" class="form-control" id="zip" value="<?php print $zip; ?>" name="zip">
			</div>
			<div class="form-group col-md-3 col-sm-6">
				<label for="country">Country</label>
				<?php 
				$resultCountry = $con->query("select * from country_tbl where active = 1 ORDER BY name ASC");
				echo '<select id="country" class="form-control" name="country">';
				while($rowCountry = $resultCountry->fetch(PDO::FETCH_ASSOC)) {
					echo "<option value='" . $rowCountry['ID'] ."'>" . $rowCountry['name'] ."</option>";
				}
				echo "</select>";
				?>
			</div>
		</div>
		<hr>
		<div class="form-row">
			<div class="form-group col-md-3 col-sm-6">
				<button type="button" class="btn btn-success" id="addEducation">Add Education</button>
			</div>
			<div class="form-group col-md-3 col-sm-6">
				<button type="button" class="btn btn-danger" id="removeEducation">Remove Education</button>
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
				<input type="text" class="form-control" id="field" name="field">
			</div>
			<div class="form-group col-md-4 col-sm-8 workingProfessional">
				<label for="employer">Employer</label>
				<input type="text" class="form-control" id="employer" name="employer">
			</div>
		</div>
		<hr>
		<div class="form-row">
			<div class="form-group col-sm-6 col-md-4 ">
				<label for="fbLink">Facebook Link</label>
				<input type="text" class="form-control" id="fbLink" value="<?php print $fbLink; ?>"  name="fbLink">
			</div>
			<div class="form-group col-sm-6 col-md-4 ">
				<label for="twLink">Twitter Link</label>
				<input type="text" class="form-control" id="twLink" value="<?php print $twLink; ?>" name="twLink">
			</div>
			<div class="form-group col-sm-6 col-md-4 ">
				<label for="lkdLink">LinkedIn Link</label>
				<input type="text" class="form-control" id="lkdLink" value="<?php print $lkdLink; ?>" name="lkdLink">
			</div>
		</div>
		<div>
			<input type="checkbox" name="tos"> <?php print $tosre; ?> By clicking Register, you agree to our Terms, Data Policy and Cookies Policy.</br></br>
		</div>
		<button type="submit" class="btn btn-primary" name="enter">Register</button>
	</form>
</div>

<?php include 'footer.php'; ?>