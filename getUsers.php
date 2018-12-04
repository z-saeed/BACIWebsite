<?php 

require_once "db_connect.php";

$stmt = $con->prepare('SELECT * FROM user_tbl');
$stmt->execute(array());


$stmtCountry = $con->prepare('SELECT * FROM country_tbl');

$string = <<<EOT
<table  id="userList" class="display table" cellspacing="0" width="100%">
<thead>
<tr>
<th>Name</th>
<th>Gender</th>
<th>Age</th>
<th>State</th>
<th>Country</th>
<th>Identity</th>
<th>Education Level</th>
<th>Registered</th>
<th></th>
</tr>
</thead>
<tfoot>
<tr>
<th>Name</th>
<th>Gender</th>
<th>Age</th>
<th>State</th>
<th>Country</th>
<th>Identity</th>
<th>Education Level</th>
<th>Registered</th>
<th></th>
</tr>
</tfoot>
EOT;


while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	$gender = "";
	$identity = "";
	$userStatus = "";

	if ($row["gender"] == 0)
		$gender = "Male";
	else
		$gender = "Female";

	if ($row["identityID"] == 0){
		$identity = "Student";
	}else{
		$identity = "Working Professional";
		$idID = $row["identityID"];
		$stmtID = $con->prepare('SELECT * FROM identity_tbl WHERE ID = :id');
		$stmtID->execute(array('id' => $idID));
		$rowID = $stmtID->fetch(PDO::FETCH_ASSOC);
	}
	$addressID = $row["addressID"];
	$stmtAddress = $con->prepare('SELECT * FROM address_tbl WHERE ID = :id');
	$stmtAddress->execute(array('id' => $addressID));
	$rowAddress = $stmtAddress->fetch(PDO::FETCH_ASSOC);
	$stateID = $rowAddress["stateID"];
	
	$stmtState = $con->prepare('SELECT * FROM state_tbl WHERE ID = :id');
	$stmtState->execute(array('id' => $stateID));
	$rowState = $stmtState->fetch(PDO::FETCH_ASSOC);
	$state = $rowState["name"];
	$countryID = $rowState["countryID"];
	
	
	$stmtCountry = $con->prepare('SELECT * FROM country_tbl WHERE ID = :id');
	$stmtCountry->execute(array('id' => $countryID));
	$rowCountry = $stmtCountry->fetch(PDO::FETCH_ASSOC);
	$country = $rowCountry["name"];
	
	$stmtEdu = $con->prepare('SELECT * FROM education_tbl WHERE userID = :id');
	$stmtEdu->execute(array('id' => $row["ID"]));
	$rowEdu = $stmtEdu->fetch(PDO::FETCH_ASSOC);
	$degreeType = $rowEdu["degreeType"];
	
	$stmtEdu2 = $con->prepare('SELECT * FROM degree_tbl WHERE ID = :id');
	$stmtEdu2->execute(array('id' => $degreeType));
	$rowEdu2 = $stmtEdu2->fetch(PDO::FETCH_ASSOC);
	$degree = $rowEdu2["type"];
	if($degree == "")
		$degree = "n/a";
	
	$string = $string."<tr><td>".$row["firstName"]." ".$row["lastName"]."</td><td>".$gender."</td><td>".$row["birthYear"]."</td><td>".$state."</td><td>".$country."</td>";
	$string = $string."<td>".$identity."</td><td>".$degree."</td><td>".$row["registerDate"]."</td><td><a href='userProfile.php?userID=".$row["ID"]."' class='btn btn-outline-info'>User Profile</a></td></tr>";
}
print($string);