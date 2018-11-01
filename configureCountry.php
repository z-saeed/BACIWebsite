<?php 
require_once 'header.php';
require_once "db_connect.php";
			
//initialize variable
$country = "";

//add to database
if(isset($_POST['add'])) {
	$newCountry = trim($_POST['country']);
	$stmt = $con->prepare('INSERT INTO country_tbl (ID, name) VALUES (Null, :country)');
	$stmt->execute(array('country' => $newCountry));
}

//edit from database
if(isset($_POST['edit'])){
		$countryNum = trim($_POST['countryNum']);
		$country = trim($_POST['country']);
		$stmt = $con->prepare('UPDATE country_tbl SET name = :name WHERE ID = :num');
		$stmt->execute(array('name' => $country, 'num' => $countryNum));
	}	

//delete from database
if(isset($_POST['delete'])){
		$stmt = $con->prepare('DELETE FROM country_tbl WHERE ID = :countryID');
		$stmt->execute(array('countryID' => $_POST['countryNum']));
	}		
	
$result = $con->query("select * from country_tbl ORDER BY name ASC");	
?>

<div class="container" id="configureCountry">
	<section id="blankHeader">
		<h2>Configure Countries</h2>
		<!-- PRINT ALL COUNTRIES-->
		List of countries in current database are:</br>
		<?php
		while($row = $result->fetch(PDO::FETCH_ASSOC)) {
			echo $row["name"] . "<br>";
		}
		?>
		<br><br>
		
		<!--ADD COUNTRY FORM -->
		<form action="configureCountry.php" method="post">
			<div class="form-row">
				Add Country: </br>
				<input type="text" maxlength = "75" name = "country" id = "country" />
			</div> <br>
			<button type="submit" class="btn btn-primary" name="add">Add Country</button>
		</form>
		<br><br>
		
		<!--EDIT COUNTRY FORM -->
		<form action="configureCountry.php" method="post">
			<div class="form-row">
				Select from list which country to edit:
				<select  name = "countryNum">
					<?php
					$result1 = $con->query("select * from country_tbl ORDER BY name ASC");
					while($row1 = $result1->fetch(PDO::FETCH_ASSOC)) {
						echo "<option value = '".$row1['ID']."'>".$row1['name']."</option>";
					}
					?>
				</select></br>
			</div>
			<div class="form-row">
			Edit Country Level (Max 75 characters):
				<input type="text" maxlength = "75" name = "country" id = "country" />
			</div><br>
			<button type="submit" class="btn btn-primary" name="edit">Edit Country</button>
		</form>
		<br><br>
		
		<!--DELETE COUNTRY -->
		<form action="configureCountry.php" method="post">
			Select from list which country to remove:
			<select  name = "countryNum">
				<?php
				$result2 = $con->query("select * from country_tbl ORDER BY name ASC");
				while($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {
					echo "<option value = '".$row2['ID']."'>".$row2['name']."</option>";
				}
				?>
			</select></br>
			<br>
			<button type="submit" class="btn btn-primary" name="delete">Delete Country</button>
		</form>
	</section>
	
</div>

<?php include 'footer.php'; ?>