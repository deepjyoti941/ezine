<style>

</style>

<div class="container">
	<div class="upload_magazine row" style="background-color:#E3FFC5;">
		<div class="row" style="margin-left:2px;padding-left: 10px;">
			<h4>Magazine Details</h4>
			<hr>
		</div>

		<div class="save_magazine" style="padding-left: 10px;">
			<div class="row" >
				<div class="span12" style="margin-left:20px;">
					<label>Magazine Title*</label>
					<input type="text" class="magazine_title span12" placeholder="magazine title/name">
					<label>Magazine Description</label>
					<textarea name="textarea" id="textarea" rows="3" style="width:925px" placeholder="Enter Magazine Description"></textarea>
					<label>Select Category*</label>
					<select class="select_category span12">
						<option value="0">select category</option>
						<? foreach ($categories as $category): ?>
						<option value="<?=$category->id ?>" ><?=$category->category_name ?></option>
						<? endforeach;?>
					</select>
					<label>Select Issue*</label>
					<select class="select_issue span12">
						<option value="0">select isuue</option>
					  	<option>Weekly</option>
					  	<option>Fortnightly</option>
					  	<option>Monthly</option>
					  	<option>Quaterly</option>
					  	<option>Halfyearly</option>
					  	<option>Yearly</option>
					</select>
					<label>Issue Description</label>
					<textarea name="textarea" id="textarea" rows="3" style="width:925px" placeholder="Enter Issue Description"></textarea>
					<label>Issue Date*</label>
					<input type="text" class="datepicker" placeholder="Select Date">
					<br>
					<a href="javascript:void(0);" class="btn btn-primary">SAVE</a>

				</div>
			</div>
			<br><br>
		</div>
	</div>

	<br>
	<div class="row" style="background-color:#E3FFC5;padding-left: 10px;">
		<div class="row" style="margin-left:2px;">
			<h4>Image And PDF Uploads</h4>
			<hr>
		</div>

<!-- 		<div class="row">
			<div class="span3" style="margin-left:20px;">
				<input type="hidden" id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="3000000">
		      	<label for="image_upload">Choose Image*</label>
		      	<input type="file" id="image_select"  name="image_select" multiple>
		      	<a href="javascript:void(0);" class="btn btn-primary upload_image" disabled>Upload Image</a>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="span3" style="margin-left:20px;">
				
		      	<label for="file_upload">Choose pdf File*</label>
		      	<input type="file" id="file_select" name="file_select" multiple>
		      	<a href="javascript:void(0);" class="btn btn-primary upload_pdf" disabled> Upload PDF </a>
			</div>
		</div>
		 -->
		<div class="row">
			<form action="/upload-image" class="upload"  method="post" enctype="multipart/form-data">
				<label for="file_upload">Choose Image*</label>
		        <input type="file" name="image_select"><br>
		        <input type="hidden" class="magazine_id" name="magazine_id">
		        <input type="submit" class="btn btn-primary" value="Upload Image">
		        <div class="progress hide image_upload">
		        	<div class="bar"></div >
		        	<div class="percent">0%</div >
	    		</div>
	    	</form>
		</div>

		<div class="row">
			<form action="/upload-pdf" class="upload" method="post" enctype="multipart/form-data">
				<label for="file_upload">Choose File*</label>
		        <input type="file" name="file_select"><br>
		        <input type="hidden" class="magazine_id" name="magazine_id">
		        <input type="submit" class="btn btn-primary" value="Upload Pdf">
		        <div class="progress hide file_upload">
		        	<div class="bar"></div >
		        	<div class="percent">0%</div >
	    		</div>
	    	</form>
		</div>

		<div class="row">
	    	<div id="status"></div>
		</div>
	</div>	
</div>

<script src="/js/vendor/jquery.form.js"></script>
<script>
(function() {

	$('.upload').on('click' , 'input[type="submit"]' , function(){
		var $el = $(this);
		var parent_div = $el.next();
		var bar = parent_div.find('.bar');
		var percent = parent_div.find('.percent');
		var status = $('#status');
		//console.log($el.next());
		//console.log($(this));

		$('form').ajaxForm({
		    beforeSend: function() {
		    	parent_div.fadeIn( "slow" );
		        status.empty();
		        var percentVal = '0%';
		        bar.width(percentVal)
		        percent.html(percentVal);
		    },
		    uploadProgress: function(event, position, total, percentComplete) {
		        var percentVal = percentComplete + '%';
		        bar.width(percentVal)
		        percent.html(percentVal);
		    },
		    success: function() {
		        var percentVal = '100%';
		        bar.width(percentVal)
		        percent.html(percentVal);
		    },
			// complete: function(xhr) {
			// 	status.html(xhr.responseText);
			// }
		}); 
	});
    
// var bar = $('.bar');
// var percent = $('.percent');
// var status = $('#status');
   
// $('form').ajaxForm({
//     beforeSend: function() {
//     	$('.progress').fadeIn( "slow" );
//         status.empty();
//         var percentVal = '0%';
//         bar.width(percentVal)
//         percent.html(percentVal);
//     },
//     uploadProgress: function(event, position, total, percentComplete) {
//         var percentVal = percentComplete + '%';
//         bar.width(percentVal)
//         percent.html(percentVal);
//     },
//     success: function() {
//         var percentVal = '100%';
//         bar.width(percentVal)
//         percent.html(percentVal);
//     },
// 	// complete: function(xhr) {
// 	// 	status.html(xhr.responseText);
// 	// }
// }); 

})();       
</script>