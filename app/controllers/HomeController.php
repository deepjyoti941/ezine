<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/
	protected $layout = 'layouts/front_end/main';

	public function index() {

		$magazineCategory = MagazineCategoryTable::all();

		$sql = "SELECT magazine.id, magazine.issue, magazine.magazine_name, magazine.magazine_slug, magazine.issue_date, magazine_category.category_name, magazine_images.img_thumb_path
				FROM magazine INNER JOIN magazine_category 
				ON magazine.category_id = magazine_category.id INNER JOIN magazine_images 
				ON magazine.id = magazine_images.magazine_id";

		$magazines = DB::select($sql);
		//$url = '/'.$magazines->magazine_slug.'/'.$magazines->issue.'/'.$magazines->id;
		//$magazines['url'] = $url;
		// echo "<pre>";
		// print_r($magazines);
		// echo "</pre>";
		// echo "<br>";	

		$this->layout->with( 'magazineCategory' , $magazineCategory )->nest('content', 'home', compact('magazines'));

	}

	function magazineDetails() {
		
		$magazineCategory = MagazineCategoryTable::all();
		$magazine_slug = Request::segment(1);
		$sql_details = "SELECT magazine.id, magazine.issue, magazine.magazine_name, magazine.magazine_slug, magazine.issue_date, magazine_category.category_name,magazine_images.img_path,magazine_pdf.pdf_path
				FROM magazine 
				INNER JOIN magazine_category ON magazine.category_id = magazine_category.id AND magazine.magazine_slug = ? 
				INNER JOIN magazine_images ON magazine.id = magazine_images.magazine_id
				INNER JOIN magazine_pdf ON magazine.id = magazine_pdf.magazine_id";
		$magazines = DB::select($sql_details, [$magazine_slug]);

		//grab related categories from db
		//first get category id for magazine using magazine_slug
		$sql_related_categories = "SELECT magazine.id, magazine.issue, magazine.magazine_name, magazine.magazine_slug, magazine.issue_date, magazine_category.category_name, magazine_images.img_thumb_path, magazine_pdf.pdf_path 
				FROM magazine
				INNER JOIN magazine_category ON magazine.category_id = magazine_category.id
				AND magazine.category_id
				IN (
				SELECT category_id
				FROM magazine
				WHERE magazine_slug = ?
				)
				INNER JOIN magazine_images ON magazine.id = magazine_images.magazine_id
				INNER JOIN magazine_pdf ON magazine.id = magazine_pdf.magazine_id";
		$related_magazines = DB::select($sql_related_categories, [$magazine_slug]);

		// echo "<pre>";
		// print_r($magazines);
		// echo "</pre>";
		// echo "<br>";

		// echo "<pre>";
		// print_r($related_magazines);
		// echo "</pre>";
		// echo "<br>";	

		$this->layout->with( 'magazineCategory' , $magazineCategory )->nest('content', 'home/magazine_details', compact('magazines' , 'related_magazines'));

		//$this->layout->content = View::make('home/magazine_details');


	}

	function showPdf() {
		
		$magazineCategory = MagazineCategoryTable::all();
		$this->layout->with( 'magazineCategory' , $magazineCategory )->nest('content', 'home/magazine_pdf');

	}

	function search() {
		$magazineCategory = MagazineCategoryTable::all();
		$input = Input::get();
		print_r($input);
		//$data['media_types'] = [];
		//$data['media_options'] = MediaOption::getBySearch($q);

		// $this->layout->filters = true;
		// $this->layout->q = $q;
		// $this->layout->content = View::make('search', $data);
		
		$this->layout->with( 'magazineCategory' , $magazineCategory )->nest('content', 'home', compact('magazines'));

	}

}