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
		//print_r($get_magazines_by_category);
		return json_encode($get_magazines_by_category);
		
	}

	function magazineSearch() {

		$search_item = Input::get('search_item');
		//print_r($search_item);
		$search_item = '%'.$search_item.'%';
		$sql_get_magazines = "SELECT magazine.id, magazine.issue, magazine.magazine_name, magazine.magazine_slug, 
			magazine.issue_date, magazine_category.category_name, magazine_images.img_thumb_path, magazine_pdf.pdf_path
			FROM magazine
			INNER JOIN magazine_category ON magazine.category_id = magazine_category.id
			INNER JOIN magazine_images ON magazine.id = magazine_images.magazine_id
			INNER JOIN magazine_pdf ON magazine.id = magazine_pdf.magazine_id
			WHERE magazine.magazine_name LIKE  '$search_item' ";
		$get_magazines = DB::select($sql_get_magazines);
		//print_r($get_magazines);
		return json_encode($get_magazines);
	}

	function getAllMagazines() {

		$sql = "SELECT magazine.id, magazine.issue, magazine.magazine_name, magazine.magazine_slug, magazine.issue_date, magazine_category.category_name, magazine_images.img_thumb_path
			FROM magazine INNER JOIN magazine_category 
			ON magazine.category_id = magazine_category.id INNER JOIN magazine_images 
			ON magazine.id = magazine_images.magazine_id";

		$magazines = DB::select($sql);
		return json_encode($magazines);
	}

	function getMagazinePdf() {

		$magazine_id = Input::get('magazine_id');
		$sql = "SELECT pdf_path FROM magazine_pdf WHERE magazine_id=?";
		$pdf = DB::select($sql , [$magazine_id]);
		return json_encode($pdf);

	}

}