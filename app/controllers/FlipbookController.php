<?php

class FlipbookController extends BaseController {

	function showFlipbook() {

		//load view home/show_flipbook
		return View::make('home/show_flipbook');
	}

}