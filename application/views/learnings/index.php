<?php $this->load->view('partials/_header'); ?>

<style type="text/css">
body{width:610px;}
#uploadForm {border-top:#F0F0F0 2px solid;background:#FAF8F8;padding:10px;}
#uploadForm label {margin:2px; font-size:1em; font-weight:bold;}
.demoInputBox{padding:5px; border:#F0F0F0 1px solid; border-radius:4px; background-color:#FFF;}
#progress-bar {background-color: #12CC1A;height:20px;color: #FFFFFF;width:0%;-webkit-transition: width .3s;-moz-transition: width .3s;transition: width .3s;}
.btnSubmit{background-color:#09f;border:0;padding:10px 40px;color:#FFF;border:#F0F0F0 1px solid; border-radius:4px;}
#progress-div {border:#0FA015 1px solid;padding: 5px 0px;margin:30px 0px;border-radius:4px;text-align:center;}
#targetLayer{width:100%;text-align:center;}
</style>
</head>
<body>
<div id="wrapper" class="active">
    <?php $this->load->view('partials/_sidebar.php'); ?>


	<div id="page-content-wrapper" >
	  <div class="container-fluid">

        <div class="row">
			<form method="post" action="<?php echo base_url()?>learnings/export_excel">
				<input type="hidden" name="">
				<button id="export_btn" class="btn btn-default custom-button">Export to Excel</button>
			</form>
			<hr/>
		</div>

		<div class="row">
			<div class="summernote">Summernote</div>
			<button id="summernoteBtn" class="btn btn-default custom-button">Save</button>
			<hr/>
		</div>

		<div class="row">
			<h5> JQUERY FILE UPLOAD PLUGIN</h5>
			<div>
				<image src="" id="fileUploadImage" width="120" height="80" style="display:none;"></image>
				<div id="progressBar" class="progress hidden">
					<div class="progress-bar progress-bar-success progress-bar-striped active"></div>
				</div>
			</div>
			<span class="btn btn-default custom-button fileinput-button">
				<span>Browse File</span>
				<input id="fileUpload" type="file" name="files" accept="image/*" >
			</span>
			<button id="btnSaveImage" class="btn btn-default custom-button">Save</button>
			<hr/>
		</div>

		<div class="row">
			<h5> JQUERY UPLOAD ( HTML5 )</h5>
			<form method="post" name ='photo' id='imageuploadform' enctype="multipart/form-data">
				<input id="fileupload" type="file" name="image" >
				<input type="text" name="sample" value="ok">
				<div id ="divleft">
					<button id="btnupload">Upload</button>
				</div>

				<div id="progressBar" class="progress" >
					<div class="progress-bar progress-bar-success progress-bar-striped active"></div>
				</div>
				</div>
			</form>
		</div>

	  </div>
    </div>

</div>
<script>

	var hasError = false;
	var imgErrorMessage;

	$(function(){

		/*
		 * Summer Note
		 */
		$('.summernote').summernote({
			height : 150,
			width : 850
		});

		$('#summernoteBtn').on('click', function(){
			var summerNoteText = $('.summernote').code();
			alert(summerNoteText);
		});


		function validateImage(htmlImgSelector) {
			var valid = true;
			var e =	htmlImgSelector;
			var validImageExt	= [ 'gif', 'jpg', 'png', 'jpeg' ];
			var fileExtention = e.val().substring(e.val().lastIndexOf('.') + 1).toLowerCase();
			if( validImageExt.indexOf( fileExtention ) < 0) {
				toastr.error(ERROR_MSG.IMAGE.INVALID_EXT);
				valid = false;
				imgErrorMessage = ERROR_MSG.IMAGE.INVALID_EXT;
			}
			if( e[0].files[0].size >= 4194304 ) {
				toastr.error(ERROR_MSG.IMAGE.FILE_EXCEED);
				valid = false;
				imgErrorMessage = ERROR_MSG.IMAGE.FILE_EXCEED;
			}
			return valid;
		}

		/*
		 * Jquery File Upload Plugin
		 */
		 $('#fileUpload').change( function(event){
		 	if( validateImage($(this))) {	// return true
				hasError = false;
		 	} else {
				hasError = true;
		 	}
		 	$('#fileUploadImage').attr("src", URL.createObjectURL(event.target.files[0]));
			$('#fileUploadImage').show();
		 });

		 $('#btnSaveImage').on('click', function(){

		 	if(hasError) {
		 		toastr.error(imgErrorMessage);
		 	} else {

				$('#fileUpload').fileupload({
					url : '<?php echo base_url(); ?>learnings/file_upload',
					dataType : 'json',
					formData : { action : 'upload' },
					beforeSend : function(event, files, index, xhr, handler, callBack) {
					},
					progressall : function(e, data) {
						var progress = parseInt(data.loaded / data.total * 100, 10);
						console.log(progress);
					},
					done : function(e, data) {
						alert('ok');
					}
				});

		 		$('#fileUpload').trigger('change');
		 	}
		 });

		/*
		 * JQUERY UPLOAD HTML 5
		 */
		$("#btnupload").click(function(e) {
			$("#fileupload").click();
			e.preventDefault();

		});

		$('#fileupload').change(function (e) {
			$("#imageuploadform").submit();
			e.preventDefault();
		});

		$('#imageuploadform').submit(function(e) {
			var formData = new FormData(this);
			$.ajax({
				type:'POST',
				url: '<?php echo base_url();?>learnings/html5_file_upload',
				data:formData,
				xhr: function() {
					var xhr = $.ajaxSettings.xhr();
					xhr.upload.addEventListener("progress", function(e){
					  if (e.lengthComputable) {
							var max = e.total;
							var currentProgress = e.loaded;
							var percentComplete = parseInt((currentProgress * 100)/max);

							console.log(parseInt(percentComplete));
							$('.progress-bar').css({ 'width' : percentComplete + '%' });

							if(percentComplete >= 100) { // process completed

							}
					  }
					}, false);
					return xhr;
				},
				cache:false,
				contentType: false,
				processData: false,
				dataType : 'json',
				success:function(data){
					console.log(data);
					if(data.error) {
						toastr.error('File name already exist');
					} else {
						toastr.success('File successfully uploaded');
					}

					//console.log(data);
				    //alert('data returned successfully');
				},
				error: function(data){
					console.log(data);
				}
			});
			e.preventDefault();
		});

		function progress(e){
			if(e.lengthComputable){
				var max = e.total;
				var current = e.loaded;

				var Percentage = (current * 100)/max;
				console.log(Percentage);

				if(Percentage >= 100)
				{
				   // process completed
				}
			}
		}





	});
</script>
<?php $this->load->view('partials/_footer'); ?>