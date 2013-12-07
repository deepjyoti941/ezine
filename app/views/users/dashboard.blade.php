<h1>Users Dashboard</h1>
 
<p>Welcome to your Dashboard.</p>
<div class="container">
<div class="row extended_span">new magazine</div>
<div class="row">list readers</div>
<div class="row"></div>

<!--ng-change></ng-change>
	<div class="add_category row-fluid" style="background-color:#F7F7F9">
		<div class="span3">
			<p>ADD CATEGORY</p>
		<input type="text" class="" placeholder="Add new category">
		<a href="javascript:void(0);" class="btn btn-primary add_category">Add</a>
		</div>
		<div class="span9">
			<section class="list_chooser_widget table_type_x_axis pull-right">
		        <label for="x_axis">Category List</label>

		        <div class="list_chooser master" style="overflow-y: scroll; height:150px">
		          <ul>
		          	@foreach ($categories as $category)
		          		<li><a href="javascript:void(0);">{{ $category->category_name }}</a></li>
					@endforeach
		          	
		          </ul>
		        </div>
	      </section>
		</div>
	</div>
	<br>
	<div class="upload_magazine row-fluid" style="background-color:#F7F7F9">
		<p>UPLOAD PDF</p>
		<div class="save_magazine">
		<div class="row">
			<div class="span3" style="margin-left:20px;">
				<label>Magazine Title</label>
				<input type="text" class="magazine_title" placeholder="magazine title/name">
			</div>
			<div class="span3">
				<label>Select Category</label>
				<select class="select_category">
					@foreach ($categories as $category)
					<option value="{{ $category->id }}">{{ $category->category_name }}</option>
					@endforeach
				</select>
			</div>
			<div class="span3">
				<label>Select Issue</label>
				<select class="select_issue">
				  <option>weekly</option>
				  <option>monthly</option>
				  <option>quaterly</option>
				  <option>yearly</option>
				</select>
				
			</div>
			<label>Issue Date</label>
			<input type="text" class="datepicker span2" placeholder="Select Date">
			<a href="javascript:void(0);" class="btn btn-primary">SAVE</a>
		</div>
		</div>
		<hr>
		<div class="row">
			<div class="span3" style="margin-left:20px;">

				<input type="hidden" id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="3000000">
		      	<label for="image_upload">Choose Image</label>
		      	<input type="file" id="image_select"  name="image_select" multiple>
		      	<a href="javascript:void(0);" class="btn btn-primary upload_image" disabled>Upload Image</a>
				
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="span3" style="margin-left:20px;">
				<input type="hidden" id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="3000000">
		      	<label for="file_upload">Choose pdf File</label>
		      	<input type="file" id="file_select" name="file_select" multiple>
		      	<a href="javascript:void(0);" class="btn btn-primary upload_pdf" disabled> Upload PDF </a>
				
			</div>

		</div>
		

    </div>
-->
	</div>

	

</div>