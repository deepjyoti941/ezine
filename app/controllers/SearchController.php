<?php

class SearchController extends BaseController {

	function categorySearch() {

		$category_id = Input::get('category_id');
		
		$sql_get_magazines_by_category ="SELECT magazine.id, magazine.issue, magazine.magazine_name, magazine.magazine_slug,magazine.issue_date, magazine_category.category_name, magazine_images.img_thumb_path, magazine_pdf.pdf_path 
			FROM magazine
			INNER JOIN magazine_category ON magazine.category_id = magazine_category.id
			AND magazine.category_id =?
			INNER JOIN magazine_images ON magazine.id = magazine_images.magazine_id
			INNER JOIN magazine_pdf ON magazine.id = magazine_pdf.magazine_id";
		$get_magazines_by_category = DB::select($sql_get_magazines_by_category, [$category_id]);
		
		return json_encode($get_magazines_by_category);
		
	}

	function magazineSearch() {


	// 		"SELECT magazine.id, magazine.issue, magazine.magazine_name, magazine.magazine_slug, magazine.issue_date, magazine_category.category_name, magazine_images.img_path, magazine_pdf.pdf_path
	// FROM magazine
	// INNER JOIN magazine_category ON magazine.category_id = magazine_category.id
	// INNER JOIN magazine_images ON magazine.id = magazine_images.magazine_id
	// INNER JOIN magazine_pdf ON magazine.id = magazine_pdf.magazine_id
	// WHERE magazine.magazine_name LIKE  '%Polymer%' ";
		$sql = "";

	}

}