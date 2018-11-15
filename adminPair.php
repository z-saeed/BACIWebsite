<?php include 'header.php'; 
if($_SESSION['loggedin'] == false) {
	header('Location: login.php'); 
}?>

/* use 1st table to save userID, and refresh to show 2nd table w/ userID tag in header. 2nd table saves 2nd userID
and refeshes w/ both tags in header. Make if statement for userID tags, if mentor&mentee=null show mentor table | 
if mentor!=null &mentee=null show mentee table| if mentor&mentee!=null pair and show they have been paired successfully |
else show error w/ button to dashboard?
*/

<section id="adminPair">
	<div class="container mt-2">
		<a href="dashboard.php" class="btn btn-secondary btn-sm">Back to Dashboard <i class="fas fa-undo-alt"></i></a>
	</div>
	<div class="container mt-3">
		<div id="tableMentee" class="table-responsive"></div>
	</div>
    
    <div class="container mt-3">
		<div id="tableMentor" class="table-responsive"></div>
	</div>
</section>

<?php include 'footer.php'; ?>