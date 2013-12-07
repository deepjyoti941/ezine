<div class="span9" style="border: 1px solid #e5e5e5; margin-top: 30px;">
	<? foreach ($magazines as $magazine) {?>
	<? $url = '/'.$magazine->magazine_slug.'/'.$magazine->issue.'/'.$magazine->id;?>
	<div class="row">
		<div class="span6" style="width: 264px;">
			<div id="Magezine_detail" class="magazineBox">
				<a id="box_img_href" href="<?= $magazine->pdf_path ?>" target="_blank">
					<img id="box_img" class="magazineBoximg" src="<?= $magazine->img_path ?>" alt="<?= $magazine->magazine_name; ?>" title="<?= $magazine->magazine_name; ?>">
				</a>
			</div>
		</div>
		<div class="span3">
			<div class="row" style="margin-left:1px;">
				<h4>Issue Description :</h4>
			</div>
			<div class="row" style="margin-left:1px;">
				<h4>Magazine Description :</h4>
			</div>
			<div class="magazine_details">
				<span class="mgzn_details1">
					<b>Magazine Name: </b><?= $magazine->magazine_name; ?> </span>
				<span class="mgzn_details1"><b>Category Name: </b>
					<a href="#"><?= $magazine->category_name ?> </a>
				</span>
				<span class="mgzn_details1"><b>Issue/Periodicity: </b>
					<a href="#"><?= $magazine->issue ?> </a>
				</span>
				<span class="mgzn_details1" style="cursor:pointer;">
					<a id="preview" href="<?= $magazine->pdf_path ?>" target="_blank">
						<img src="/css/img/preview.png">
					</a>
					<a style="margin-left:10px;" href="/" target="_blank">
						<img src="/css/img/subscribe.png">
					</a>
				</span>
			</div>	
		</div>
	</div>
	<? }?>
	<br>
	<br>
	
	<div class="row" style="margin-left: 20px;">
		<div class="span9">
			<h4 style="text-decoration:underline;">Previous Issues</h4>
		</div>
	</div>
	<br>
	<br>
	<div class="row" style="margin-left: 20px;">
		<div class="span9">
			<h4 style="text-decoration:underline;">Related magazines</h4>
			<? foreach ($related_magazines as $related_magazine) {?>
		    <? $url = '/'.$related_magazine->magazine_slug.'/'.$related_magazine->id ;?>
		      <div class="magazineContainer">
		        <h3 class="magazineMainCategoryHeight"><a href="<?= $url ?>"><?= $related_magazine->magazine_name ?></a></h3>
		        <div class="magazineImage">
		          <a href="<?= $url ?>" title="<?= $related_magazine->magazine_name ?>" target>
		            <span id="">
		              <img src="<?= $related_magazine->img_thumb_path ?>" alt="<?= $related_magazine->magazine_name ?>" title="<?= $related_magazine->magazine_name ?>">
		            </span>
		          </a>
		        </div> 
		    </div>

		    <? }?>
		</div>
	</div>

	<br>
	<br>
	<div class="row" style="margin-left: 20px;">
		<div class="span9">
			<h4 style="text-decoration:underline;">Popular Magazines</h4>
		</div>
	</div>

</div>