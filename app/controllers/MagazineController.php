<?php

class MagazineController extends BaseController {

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
	protected $layout = "layouts.main";

	public function __construct() {

   		$this->beforeFilter('auth', array('only'=>array('uploadImagePdf' , 'listMagazines')));
	}

	function listMagazines() {

		$sql = "SELECT magazine.id, magazine.issue, magazine.magazine_name, magazine.issue_date, magazine.created_at, magazine_category.category_name
						FROM magazine INNER JOIN magazine_category ON magazine.category_id = magazine_category.id";
						
      	$magazines = DB::select($sql);

		// grab all magazines from database and passit to view
		//$magazines = MagazineTable::all();

		$this->layout->content = View::make('magazine/list_magazine', compact('magazines'));

	}

	public function addMagazine() {

		$input = file_get_contents('php://input');
		$input = json_decode($input, true);

		$magazine = new MagazineTable;
		$magazine->category_id = $input['category'];
		$magazine->issue = $input['issue'];
		$magazine->magazine_name = $input['magagine_title'];
		$magazine->magazine_slug = MagazineTable::slugify($input['magagine_title']);
		$magazine->issue_date = $input['date'];
		$magazine->save();

		$res = ['magazine' => $input['magagine_title'] ,'magazine_id' => $magazine->id, 'status' => 'success'];
		
		return json_encode($res);

	}

	function editMagazine() {


	}

	function uploadImagePdf() {

		$categories =  MagazineCategoryTable::all();

		$this->layout->content = View::make('magazine/uploadPdfImage',compact('categories'));

	}

}