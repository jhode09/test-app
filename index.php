<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
	<link rel="shortcut icon" href="public/icon.png" />
	<link href="public/css/style.css" rel="stylesheet">
	<title>Corporate Keys - Exam</title>
</head>
<body>
	<div class="container">
		<div class="container-wrap">
			<div class="table-header">
				<div class="page-title">List of data</div>
				<button id="btnAdd">Add</button>
			</div>
			<div id="note" style="font-size: .9em; float: left;" hidden>
				<p>Click thumbnail to expand</p>
			</div>
			<table id="myTable" class="table-list">
				<thead>
					<tr>
						<th>Title</th>
						<th>Thumbnail</th>
						<th>File Name</th>
						<th>Date Added</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<td colspan="5" class="text-center"> No available data </td>
				</tbody>
			</table>
		</div>
	</div>

	<div id="myModal" class="modal">
  		<div class="modal-content">
    		<div class="modal-header">
	      		<span class="close btn-close">&times;</span>
	      		<h2 class="text-uppercase"><span id="lblAction">Add</span> Item</h2>
    		</div>

			<form id="myForm" enctype="multipart/form-data">
		    	<div class="modal-body">
		    		<div class="row" style="margin-bottom: 10px;">
			    		<div class="alert-exists">
							<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
							<strong>Failed!</strong> Title is already exists.
						</div>
					</div>
	    			<div class="row">
				      	<div class="col-25">
				        	<label>Title</label>
				      	</div>
				      	<div class="col-75">
				        	<input type="text" id="title" name="title" placeholder="Title" required maxlength="150">
				      	</div>
				    </div>
				    <div class="row">
				      	<div class="col-25">
				        	<label>Select File</label>
				      	</div>
				      	<div class="col-75">
				        	<input type="file" accept="image/png, image/jpg, image/jpeg" id="filename" name="filename" placeholder="File Name" required>
				      	</div>
				    </div>
				    <div id="divThumbnail" class="row" hidden>
				      	<div class="col-25">
				        	<label>Thumbnail</label>
				      	</div>
				      	<div class="col-75">
				        	<img class="img" id="imgThumbnail" src="">
				      	</div>
				    </div>
		    	</div>

		    	<div class="modal-footer">
		      		<button type="submit" class="btn-submit"> <span id="formSubmitBtn">SUBMIT<span> </button>
		    		<button type="button" class="btn-close"> <span id="formCloseBtn">CLOSE<span> </button>
		    	</div>
	    	</form>
  		</div>
	</div>

	<div id="delModal" class="del-modal">
  		<div class="del-modal-content">
  			<div class="del-modal-header">
  				<h4>Are you sure you want to delete this? </h4>
  			</div>
  			<div class="del-modal-body">
	        	<b><label id="delTitle"></label></b>
	        	<br><br>
	        	<img class="img" id="delImgThumbnail" src="">
			</div>
			<div class="del-modal-footer">
				<button id="btnDeleteYes" type="button" class="btn-yes"> Yes, please </button>
		  		<button id="btnDeleteNo" type="button" class="btn-no"> Cancel </button>
			</div>
  		</div>
	</div>

	<div id="itemImageOverlay" class="overlay">
	  	<a href="javascript:void(0)" class="closebtn" onclick="closeImage()">&times;</a>
	  	<div class="overlay-content">
	    	<h2 id="itemTitle" style="color:white">...</h2>
	    	<img id="itemImage" class="overlay-image" src="public/uploads/FILE_1665552233.jpg">
	  	</div>
	</div>

	<script type="text/javascript" src="public/js/jquery.min.js"></script>
	<script type="text/javascript" src="public/js/pagination.js"></script>
	<script src="public/js/main.js"></script>
</body>
</html>