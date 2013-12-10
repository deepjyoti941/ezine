<?php

use Imagine\Image\Box;
use Imagine\Image\Point;

class MagazineUploadsController extends BaseController {

	public function __construct() {

		$this->beforeFilter('auth', array('only'=>array('uploadImage','uploadPdfFile')));
	}

	public function uploadImage() {

	    $input = Input::get();
	    $magazine_id = $input['magazine_id'];
	    $files = Input::file('image_select');
	    print_r($files);
	    $files = [$files];
	    $new_image_src_data = array();
	    foreach ($files[0] as $file) {
	    	
	      $absolute_path='/uploads/magazine/img/'.$magazine_id.'/';
	      $dest = public_path().$absolute_path;

	      $new_image_src = $magazine_id."_".$file->getClientOriginalName();
	      array_push($new_image_src_data, $new_image_src)	;
	      //save the image to disk
	      $file->move($dest,$new_image_src);
	     
	      //create thumbnail of the image
	      $main_image_url = $absolute_path.$new_image_src;
	      $thumb_image_url=preg_replace('/\.jpg/', "_m.jpg", $main_image_url);
		  $imagine = new Imagine\Imagick\Imagine();
		  $image = $imagine->open(public_path().$main_image_url);
		  $image->resize(new Box(93,127))
		  		->save(public_path().$thumb_image_url);
		  echo "<br>".public_path().$thumb_image_url;

	      // Make an entry in media_option_images_tables
	      $image = new MagazineImageTable;
	      $image->magazine_id = $magazine_id;
	      $image->img_path = $absolute_path.$new_image_src;
	      $image->img_thumb_path = $thumb_image_url;
	      $image->save();
	    
	      //save the thumbnail image to database
     
    	}

    //return json_encode(['status' => 'success','src'=>$new_image_src_data]);
	}

	public function uploadPdfFile() {

		$input = Input::get();
	    $magazine_id = $input['magazine_id'];
	    print_r($input);

	    $files = Input::file('file_select');
	    print_r($files);
	    $files = [$files]; // multi file upload consistency :| (file_select[] name i.e.)
	    
	    foreach ($files as $file) {

	      $absolute_path='/uploads/magazine/file/'.$magazine_id.'/';
	      $dest = public_path().$absolute_path;
	      $new_file_src = $magazine_id."_".$file->getClientOriginalName();
	      //save the file to diskfreespace()
	      $file->move($dest, $new_file_src);
	      
	      $file = new MagazinePdfTable;
	      $file->magazine_id = $magazine_id;
	      $file->pdf_path = $absolute_path.$new_file_src;
	      $file->save(); 
	    }

	    //return json_encode(['status' => 'success','src'=>$new_file_src]);
	}

}