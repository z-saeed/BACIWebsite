<?php include 'header.php'; 
if($_SESSION['loggedin'] == false) {
	header('Location: login.php'); 
}?>

<section id="listUsers">
	<div class="container mt-2">
		<a href="dashboard.php" class="btn btn-secondary btn-sm">Back to Dashboard <i class="fas fa-undo-alt"></i></a>
	</div>

    <h3>Save Database Information</h3>

    <div class="row mt-4">
        <div class="col-sm-12 col-md-6">
			<h4>User Table</h4>
        </div>
        <div class="col-sm-12 col-md-6">
            <p class="lead"><a href="saveTables.php?tag=1" class="btn btn-outline-primary btn-sm">Download User Table</a></p>
        </div>
        <div class="col-sm-12 col-md-6">
			<h4>Country Table</h4>
        </div>
        <div class="col-sm-12 col-md-6">
            <p class="lead"><a href="saveTables.php?tag=2" class="btn btn-outline-primary btn-sm">Download Country Table</a></p>
        </div>
    </div>

</section>

<?php include 'footer.php'; ?>