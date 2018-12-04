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
			<h4>Address Table</h4>
        </div>
        <div class="col-sm-12 col-md-6">
            <p class="lead"><a href="saveTables.php?tag=2" class="btn btn-outline-primary btn-sm">Download Address Table</a></p>
        </div>
        <div class="col-sm-12 col-md-6">
			<h4>Country Table</h4>
        </div>
        <div class="col-sm-12 col-md-6">
            <p class="lead"><a href="saveTables.php?tag=3" class="btn btn-outline-primary btn-sm">Download Country Table</a></p>
        </div>
        <div class="col-sm-12 col-md-6">
			<h4>State Table</h4>
        </div>
        <div class="col-sm-12 col-md-6">
            <p class="lead"><a href="saveTables.php?tag=4" class="btn btn-outline-primary btn-sm">Download State Table</a></p>
        </div>
        <div class="col-sm-12 col-md-6">
			<h4>Degree Table</h4>
        </div>
        <div class="col-sm-12 col-md-6">
            <p class="lead"><a href="saveTables.php?tag=5" class="btn btn-outline-primary btn-sm">Download Degree Table</a></p>
        </div>
        <div class="col-sm-12 col-md-6">
			<h4>Education Table</h4>
        </div>
        <div class="col-sm-12 col-md-6">
            <p class="lead"><a href="saveTables.php?tag=6" class="btn btn-outline-primary btn-sm">Download Education Table</a></p>
        </div>
        <div class="col-sm-12 col-md-6">
			<h4>Identity Table</h4>
        </div>
        <div class="col-sm-12 col-md-6">
            <p class="lead"><a href="saveTables.php?tag=7" class="btn btn-outline-primary btn-sm">Download Identity Table</a></p>
        </div>
        <div class="col-sm-12 col-md-6">
			<h4>Relationship Table</h4>
        </div>
        <div class="col-sm-12 col-md-6">
            <p class="lead"><a href="saveTables.php?tag=8" class="btn btn-outline-primary btn-sm">Download Relationship Table</a></p>
        </div>
        <div class="col-sm-12 col-md-6">
			<h4>Picture Table</h4>
        </div>
        <div class="col-sm-12 col-md-6">
            <p class="lead"><a href="saveTables.php?tag=9" class="btn btn-outline-primary btn-sm">Download Picture Table</a></p>
        </div>
        <div class="col-sm-12 col-md-6">
			<h4>Resume Table</h4>
        </div>
        <div class="col-sm-12 col-md-6">
            <p class="lead"><a href="saveTables.php?tag=10" class="btn btn-outline-primary btn-sm">Download Resume Table</a></p>
        </div>
    </div>

</section>

<?php include 'footer.php'; ?>