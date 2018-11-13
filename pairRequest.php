<?php 
require_once 'header.php';
require_once 'db_connect.php';

if($_SESSION['loggedin'] == false) {
	header('Location: login.php'); 
}

$mmPair = $_SESSION['mmPair'];
$requestDate = date("Y/m/d");

$mmRelationship = $con->prepare("INSERT INTO mmRelationship_tbl (`ID`, `mentorID`, `menteeID`, `requester`, `requestDate`, `rejectDate`, `startDate`, `endDate`) VALUES (NULL, :mentorID, :menteeID, :requester, :requestDate, '', '', '')");
$mmRelationship->execute(array('mentorID'=>$mmPair->getMentorID(), 'menteeID'=>$mmPair->getMenteeID(), 'requester'=>$mmPair->getRequester(), 'requestDate'=>$requestDate));

?>

<div class="container" id="mmRelationship">
	<section id="mmRelationship">
		<h2>Mentor/Mentee Pairing Requested!</h2>
	</section>
	MentorID: <?php echo $mmPair->getMentorID();?>
	</br></br>
	MenteeID: <?php echo $mmPair->getMenteeID();?>
	</br></br>
	Requester: 
	<?php 
	if($mmPair->getRequester()==0)
		echo "Mentee";
	if($mmPair->getRequester()==1)
		echo "Mentor";
	?>
	</br></br>
	Today's Date: <?php echo $requestDate?>
	
</div>

<?php include 'footer.php'; ?>