let _ID = "";

//Add
$("#btnAdd").click(function() {
	_ID = "";
	formReset();
	toggleModal("block");
	$("#lblAction").text("Add");
	$("#formCloseBtn").text("CLOSE");
	$("#formSubmitBtn").text("SUBMIT");
	$("#divThumbnail").prop("hidden", true);
	$("#filename").attr("required", "true");
});

$(".btn-close").click(function() {
	_ID = "";
	toggleModal("none");
});




//Display
function selectAllData() {
	$.ajax({
		url : "routes/web.php",
		type: "post",
		data: {"action" : "selectAll"},
		dataType: 'json',
		success: function(response) {
			var output = "";
			var table  = $("#myTable tbody");
			if(response.length > 0) {
				$.each(response, function(index, value) {
					output += `
						<tr data-id=`+index+` class='text-center'>
							<td>`+value.title+`</td>
							<td><img class='img-thumbnail' src='public/uploads/`+value.filename+`' onclick=expandImage(`+index+`)></td>
							<td>`+value.filename+`</td>
							<td>`+formatDate(value.date)+`</td>
							<td>
								<button class='btn-update' onclick=updateData(`+index+`,`+value.id+`)>Update</button>
								<button class='btn-delete' onclick=deleteData(`+index+`,`+value.id+`)>Delete</button>
							</td>
						</tr>
					`;
				})
				$("#note").prop("hidden", false);
			} else {
				output += `
					<tr>
						<td colspan="5" class="text-center"> No available data </td>
					</tr>
				`;
				$("#note").prop("hidden", true);
			}
			table.empty().append(output);
		},
		complete: function() {
			$('#myTable').createTablePagination({
			    rowPerPage: 5,
			});
		},
		error: function(a, b, c) {
			alert("An error occured");
		}
	})
}

function formatDate(date) {
	var d = new Date(date);
	var options = { year: 'numeric', month: 'short', day: 'numeric' };
	return d.toLocaleDateString('en-US', options);
}

selectAllData();




//Create || Update
$("#myForm").on('submit', function(e) {
	e.preventDefault();
	saveData();
});

function saveData() {
	var formData = new FormData($("#myForm")[0]);
	var action = (_ID == "") ? "insert" : "update";
	formData.append("action", action);
	formData.append("id", _ID);
	$.ajax({
		url : "routes/web.php",
		type: "post",
		data: formData,
		processData: false,
	    contentType: false,
	    dataType: "json",
		beforeSend: function() {

		},
		success: function(response) {
			if(response.success == true) {
				selectAllData();
				toggleModal("none");
				formReset();
			} else if(response.success == "exists") {
				$(".alert-exists").css("display", "block");
			} else {
				alert("An error occured");
			}
		},
		error: function(a, b, c) {
			alert("An error occured");
		}
	})
}

function updateData(index, id) {
	var row = $('tr[data-id="' + index + '"]');
	var td  = row.find("td");
	_ID = id;
	$("#title").val(td.eq(0).text());
	$("#imgThumbnail").attr('src', 'public/uploads/'+td.eq(2).text());
	$("#lblAction").text("Update");
	$("#formCloseBtn").text("CANCEL");
	$("#formSubmitBtn").text("UPDATE");
	$("#divThumbnail").prop("hidden", false);
	$("#filename").removeAttr('required');
	toggleModal("block");
}





//Delete
function deleteData(index, id) {
	var row = $('tr[data-id="' + index + '"]');
	var td  = row.find("td");
	var title = td.eq(0).text()
	_ID = id;
	$("#delTitle").text(title);
	$("#delImgThumbnail").attr('src', 'public/uploads/'+td.eq(2).text());
	$("#delModal").css("display", "block");
}

$("#btnDeleteYes").click(function() {
	$.ajax({
		url : "routes/web.php",
		type: "post",
		data: {
			"action" : "delete",
			"id" : _ID
 		},
 		dataType:"json",
 		beforeSend: function() {

 		},
 		success: function(response) {
 			if(response.success == true) {
 				selectAllData();
 				$("#delModal").css("display", "none");
 			} else {
 				alert("An error occured!");
 			}
 		},
 		error: function() {
 			alert("An error occured!");
 		} 
	})
});

$("#btnDeleteNo").click(function() {
	$("#delModal").css("display", "none");
});





//Utils
function formReset() {
	$("#myForm")[0].reset();
}

function toggleModal(display) {
	$(".alert-exists").css("display", "none");
	$("#myModal").css("display", display);
}

function expandImage(index) {
	var row   = $('tr[data-id="' + index + '"]');
	var td    = row.find("td");
	var title = td.eq(0).text();
	var file  = td.eq(2).text();
	var src   = "public/uploads/"+file;
	$("#itemImage").attr('src', src);
	$("#itemTitle").text(title);
	$("#itemImageOverlay").css('width', '100%');
}

function closeImage() {
	$("#itemImageOverlay").css('width', '0%');
}
