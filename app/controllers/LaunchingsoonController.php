<?php

class LaunchingsoonController extends BaseController {

	function launchingSoon() {
		//load view home/show_flipbook
		//return View::make('home/show_flipbook');
		return View::make('home/launching_soon');
		//return View::make('home/flipbook/flipbook_select_text');
		//return View::make('home/flipbook/flipbook_select_textV2');
	}

}