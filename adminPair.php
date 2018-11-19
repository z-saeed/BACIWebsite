<?php include 'header.php'; 
if($_SESSION['loggedin'] == false) {
	header('Location: login.php'); 
}?>

<!--use 1st table to save userID, and refresh to show 2nd table w/ userID tag in header. 2nd table saves 2nd userID
and refeshes w/ both tags in header. Make if statement for userID tags, if mentor&mentee=null show mentor table | 
if mentor!=null &mentee=null show mentee table| if mentor&mentee!=null pair and show they have been paired successfully |
else show error w/ button to dashboard?
-->

<html>
	<head>
		<script>
			function showMentors(str)
			{
				var xmlhttp;
				if (str.length==0) { 
					document.getElementById("mentors").innerHTML="";
					return;}
				  
				if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp=new XMLHttpRequest();}
				  
				else{// code for IE6, IE5
					xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
				  
				xmlhttp.onreadystatechange=function(){
					if (xmlhttp.readyState==4 && xmlhttp.status==200){
					document.getElementById("mentors").innerHTML=xmlhttp.responseText;
					}
				 }
				xmlhttp.open("GET","mentorProcess.php?q="+str,true);
				xmlhttp.send();
			}
		</script>
	</head>
	<body>
		<br/><br/>
		<h3>Search Mentors by Last Name</h3>
		<form action="adminPair.php" method="post"> 
			Enter Mentor's Last Name: 

			<input type="text" list="mentors" name="drop" value="" onkeyup="showMentors(this.value)" />
			<datalist id="mentors" >
			  
			</datalist>
			<br/><br/>
		</form>
	</body>
</html>

<?php include 'footer.php'; ?>