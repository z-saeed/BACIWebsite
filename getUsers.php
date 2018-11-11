<?php 

require_once "db_connect.php";

$stmt = $con->prepare("SELECT * FROM user_tbl");
$stmt->execute(array());

$string = <<<EOT
<table  id="userList" class="display table" cellspacing="0" width="100%">
<thead>
<tr>
<th>First Name</th>
<th>Last Name</th>
<th>Email</th>
<th>Gender</th>
<th>Phone</th>
<th>Identity</th>
<th>User Status</th>
<th></th>
</tr>
</thead>
<tfoot>
<tr>
<th>First Name</th>
<th>Last Name</th>
<th>Email</th>
<th>Gender</th>
<th>Phone</th>
<th>Identity</th>
<th>User Status</th>
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

	if ($row["identityID"] == 0)
		$identity = "Student";
	else
		$identity = "Working Professional";

	if ($row["userStatus"] == 0)
		$userStatus = "Mentee";
	else if ($row["userStatus"] == 1)
		$userStatus = "Mentor";
	else
		$userStatus = "Neither";

	$string = $string."<tr><td>".$row["firstName"]."</td><td>".$row["lastName"]."</td><td>".$row["email"]."</td><td>".$gender."</td><td>".$row["phone"]."</td><td>".$identity."</td><td>".$userStatus."</td><td><a href='userProfile.php?userID=".$row["ID"]."' class='btn btn-outline-info'>User Profile</a></td></tr>";
}

print($string);