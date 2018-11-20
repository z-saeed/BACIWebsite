<?php include 'header.php'; 
if($_SESSION['loggedin'] == false) {
	header('Location: login.php'); 
}

if (isset($_POST['pair'])){
		
	$mentor = trim($_POST['mentor']);
	$mentee = trim($_POST['mentee']);
	
	echo $menteeLast;
	
	if ($name !== ""){
		
		session_start();
		$_SESSION['lname'] = $name;
		
		//echo $name;
		
		header('Location: pairing.php?mentor='.$mentor.'&mentee='.$mentee.'&change=1');
	}
}
?>

<!--use 1st table to save userID, and refresh to show 2nd table w/ userID tag in header. 2nd table saves 2nd userID
and refeshes w/ both tags in header. Make if statement for userID tags, if mentor&mentee=null show mentor table | 
if mentor!=null &mentee=null show mentee table| if mentor&mentee!=null pair and show they have been paired successfully |
else show error w/ button to dashboard?
-->

<html>
	<head>
		<script>

			var menteeID, mentorID;

			function showMentors(str)
			{
				var xmlhttp;
				if (str.length==0) { 
					document.getElementById("mentor").innerHTML="";
					return;}
				  
				if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp=new XMLHttpRequest();}
				  
				else{// code for IE6, IE5
					xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
				  
				xmlhttp.onreadystatechange=function(){
					if (xmlhttp.readyState==4 && xmlhttp.status==200){
					document.getElementById("mentor").innerHTML=xmlhttp.responseText;
					}
				 }
				xmlhttp.open("GET","mentorProcess.php?q="+str,true);
				xmlhttp.send();
			}

			function showMentees(str)
			{
				var xmlhttp;
				if (str.length==0) { 
					document.getElementById("mentee").innerHTML="";
					return;}
				  
				if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp=new XMLHttpRequest();}
				  
				else{// code for IE6, IE5
					xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
				  
				xmlhttp.onreadystatechange=function(){
					if (xmlhttp.readyState==4 && xmlhttp.status==200){
					document.getElementById("mentee").innerHTML=xmlhttp.responseText;
					}
				 }
				xmlhttp.open("GET","menteeProcess.php?q="+str,true);
				xmlhttp.send();
			}

			function setMenteeID(id)
			{
				menteeID = id;
			}

			function setMentorID(id)
			{
				mentorID = id;
			}

			function getMenteeID()
			{
				return menteeID;
			}

			function getMentorID()
			{
				return mentorID;
			}

		</script>
	</head>
	<section id="adminPair">
	<div class="row mt-4">
		<div class="col-md-4 col-sm-4">
			<a href="dashboard.php" class="btn btn-primary btn-sm">Back to Dashboard <i class="fas fa-undo-alt"></i></a>
		</div>
		<h3>Create new Pair</h3>
	</div>
		<form action="adminPair.php" method="post"> 
			<div class="row mt-4">
			
				<div class="col-md-4 col-sm-4">
					<div class="mentor">
						
							Enter Mentor's Last Name: 
							<input type="text" list="mentor" name="mentor" value="" onkeyup="showMentors(this.value)" />
							<datalist id="mentor" >
							
							</datalist>
						
					</div>
				</div>
				<div class="col-md-4 col-sm-4"">
					<div class="mentee">
							Enter Mentee's Last Name: 
							<input type="text" list="mentee" name="mentee" value="" onkeyup="showMentees(this.value)" />
							<datalist id="mentee" >
							
							</datalist>
					</div>
				</div>
				<input name="pair" class="btn" type="submit" value="Pair" />
			
			</div>
		</form>
	</section>
</html>

<?php include 'footer.php'; ?>