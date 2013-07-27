<?php

class Base_Controller extends Controller {

	/**
	 * Catch-all method for requests that can't be matched.
	 *
	 * @param  string    $method
	 * @param  array     $parameters
	 * @return Response
	 */

	//set the layout property
	public $layout = 'layout.main';

	public function __call ($method, $parameters) {
		return Response::error('404');
	}

}
