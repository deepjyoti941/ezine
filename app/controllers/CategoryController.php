<?php

class CategoryController extends BaseController {

	protected $layout = "layouts.main";

	public function __construct() {

		$this->beforeFilter('auth', array('only'=>array('addNewCategory','showCategory')));
	}

	public function showCategory() {

		$magazineCategory = MagazineCategoryTable::all();
		
		$this->layout->content = View::make('categories/index' , compact('magazineCategory'));

	}

	function addNewCategory() {
		
		$this->layout->content = View::make('categories/add_new_category');
	}

	function addCategory() {

		$category = Input::get('category');

		$rec = new MagazineCategoryTable;
		$rec->category_name = $category;
		$rec->category_slug = MagazineTable::slugify($category);
		$rec->save();

		$res = ['category' => $category , 'category_id' => $rec->id, 'status' => 'success'];

		return json_encode($res);
	
	}

	function editCategory() {


	}


}