<?php 
require_once 'header.php';
require_once 'db_connect.php';

if($_SESSION['loggedin'] == false) {
	header('Location: login.php'); 
}

$mmPair = $_SESSION['mmPair'];

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
</div>

<?php include 'footer.php'; ?>