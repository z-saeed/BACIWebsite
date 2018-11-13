$(document).ready(function() {

	/*
	#############################
	###### DATA TABLE CODE ######
	#############################
	*/

	var xmlhttp;
	if (document.getElementById("table")) {
		if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		} else {// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
				$('#table').html(xmlhttp.responseText);
				$('#userList').DataTable();
			}
		}
		xmlhttp.open("GET","getUsers.php",true);
		xmlhttp.send();
	} else if (document.getElementById("tableMentor")) {
		if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		} else {// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
				$('#tableMentor').html(xmlhttp.responseText);
				$('#userList').DataTable();
			}
		}
		xmlhttp.open("GET","getMentors.php",true);
		xmlhttp.send();
	} else if(document.getElementById("tableMentee")) {
		if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		} else {// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
				$('#tableMentee').html(xmlhttp.responseText);
				$('#userList').DataTable();
			}
		}
		xmlhttp.open("GET","getMentees.php",true);
		xmlhttp.send();
	} else if(document.getElementById("tablePending")) {
		if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		} else {// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
				$('#tablePending').html(xmlhttp.responseText);
				$('#userList').DataTable();
			}
		}
		xmlhttp.open("GET","getPending.php",true);
		xmlhttp.send();
	}

	/*
	##################################
	###### ADD/REMOVE EDUCATION ######
	##################################
	*/

	var num = 0;
	$("#removeEducation").hide();

	function addEducation() {
		$("#removeEducation").show();
		num++;
		var field = document.getElementById('dynamicEducation');
		var div = document.createElement("div");
		div.setAttribute("id", "removeDiv" + num);
		div.innerHTML = `
		<div class="form-row">
			<div class="form-group col-md-3 col-sm-6">
				<label for="degree${num}">Degree</label>
				<select id="degree${num}" class="form-control" name="degree${num}" required>
					<option value="ID" selected>Degree from Database</option>
					<option value="ID">Degree from Database</option>				
				</select>
			</div>
			<div class="form-group col-md-3 col-sm-6">
				<label for="major">Major</label>
				<input type="text" class="form-control" class="major" name="major${num}" required>
			</div>
			<div class="form-group col-md-3 col-sm-6">
				<label for="school">School</label>
				<input type="text" class="form-control" class="school" name="school${num}" required>
			</div>
			<div class="form-group col-md-3 col-sm-6">
				<label for="yearCompleted${num}">Year Completed</label>
				<select id="yearCompleted${num}" class="form-control" name="yearCompleted${num}" required> 
					<option value="2018" selected>2018</option>
					<option value="2017">2017</option>				
				</select>
			</div>
		</div>
		`;
		field.appendChild(div);
	}

	function removeEducation() {
		$('#removeDiv'+num).remove();
		num--;
		if (num == 0)
			$("#removeEducation").hide();
	}

	$('#addEducation').click(addEducation);
	$('#removeEducation').click(removeEducation);

	/*
	################################
	###### IDENTITY SELECTION ######
	################################
	*/

	$(".workingProfessional").hide();
	$('#employment').change(function() {
    	var value = $(this).val();
    	if (value == "student") {
    		$(".workingProfessional").hide();
    	} else {
    		$(".workingProfessional").show();
    	}
	});

});

$(function() {

	// We can attach the `fileselect` event to all file inputs on the page
	$(document).on('change', ':file', function() {
		var input = $(this),
		numFiles = input.get(0).files ? input.get(0).files.length : 1,
		label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
		input.trigger('fileselect', [numFiles, label]);
	});

	$(document).ready( function() {
		$(':file').on('fileselect', function(event, numFiles, label) {

			var input = $(this).parents('.input-group').find(':text'),
			log = numFiles > 1 ? numFiles + ' files selected' : label;

			if( input.length ) {
				input.val(log);
			} else {
				if( log ) alert(log);
			}

		});
	});
});

$(document).ready(function() {
	$('#employment').change(function() {
    	var value = $(this).val();
    	if (value == "student") {
    		$(".workingProfessional").hide();
    	} else {
    		$(".workingProfessional").show();
    	}
	});
});



