<?php 
include 'header.php';
include 'db_connect.php';

if($_SESSION['loggedin'] == false) {
	header('Location: login.php'); 
}

$user = $_SESSION['user'];

$userID = $user->getID();

if (isset($_POST['upload'])) {

	// $updateUserInfo = $con->prepare("UPDATE user_tbl SET email = '$email', firstName = '$firstName', lastName = '$lastName', gender = '$gender', userStatus = '$userStatus' WHERE ID = '$userID'");
	// $updateUserInfo->execute(array());

	// $success = "Update Successful";

}
?>

<section id="editUserInfo">
	<div id="userInfoCell">
		<div class="container">
			<div class="row">
				<div class="col-md-4 col-sm-8">
					<h2>Upload Files</h2>
				</div>
			</div>
			<form action="fileUpload.php" method="post">
				<div class="row mt-5">
					<div class="col-lg-6 col-sm-12">
						<span class="help-block">
							<h4>Upload Picture</h4>
						</span>
						<div class="input-group">
							<label class="input-group-btn">
								<span class="btn btn-primary sharp">
									Browse&hellip; <input type="file" style="display: none;" accept="image/*" name="picture">
								</span>
							</label>
							<input type="text" class="form-control" readonly>
						</div>
					</div>
					<div class="col-lg-6 col-sm-12">
						<span class="help-block">
							<h4>Upload Resume</h4>
						</span>
						<div class="input-group">
							<label class="input-group-btn">
								<span class="btn btn-primary sharp">
									Browse&hellip; <input type="file" style="display: none;" accept=".docx,.doc,.pdf,.odt,.txt" name="resume">
								</span>
							</label>
							<input type="text" class="form-control" readonly>
						</div>
					</div>
				</div>
				<div class="row mt-3">
					<div class="col-sm-2 offset-sm-10">
						<button type="submit" class="btn btn-success btn-block" name="uploadPicture">Upload <i class="fas fa-cloud-upload-alt"></i></button>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>

<?php 
include 'footer.php';
?>