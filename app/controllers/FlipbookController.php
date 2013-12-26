<?php

class FlipbookController extends BaseController {

	function showFlipbook() {
		//load view home/show_flipbook
		//return View::make('home/show_flipbook');
		return View::make('home/flipbook/show_flipbook_version2');
		//return View::make('home/flipbook/flipbook_select_text');
		//return View::make('home/flipbook/flipbook_select_textV2');
	}

}