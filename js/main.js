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

$(".workingProfessional").hide();
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

var num = 0;
function addEducation() {
	num++;
	var field = document.getElementById('dynamicEducation');
	var div = document.createElement("div");
	div.setAttribute("id", "removeDiv" + num);
	div.innerHTML = `
	<div class="form-row">
		<div class="form-group col-md-3 col-sm-6">
			<label for="degree">Degree</label>
			<select id="degree" class="form-control" name="degree${num}" required>
				<option value="ID" selected>Degree from Database</option>
				<option value="ID">Degree from Database</option>				
			</select>
		</div>
		<div class="form-group col-md-3 col-sm-6">
			<label for="major">Major</label>
			<input type="text" class="form-control" id="major" name="major${num}" required>
		</div>
		<div class="form-group col-md-3 col-sm-6">
			<label for="school">School</label>
			<input type="text" class="form-control" id="school" name="school${num}" required>
		</div>
		<div class="form-group col-md-3 col-sm-6">
			<label for="yearCompleted">Year Completed</label>
			<select id="yearCompleted" class="form-control" name="yearCompleted${num}"> required
				<option value="2018" selected>2018</option>
				<option value="2017">2017</option>				
			</select>
		</div>
	</div>
	<div class="form-row">
		<div class="form-group col-md-3 col-sm-6">
			<a href="#" class="btn btn-danger" onclick="removeEducation(`+ num +`)">Remove Education</a>
		</div>
	</div>
	`;
	field.appendChild(div);
}

function removeEducation(rid) {
	$('#removeDiv'+rid).remove();
}

