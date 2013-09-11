<?php namespace Devhook\Shop;

use FrontController;

class ShopController extends FrontController
{

	//--------------------------------------------------------------------------

	protected $comName = 'shop';

	//--------------------------------------------------------------------------

	public function viewPath()
	{
		return __DIR__ . '/../views/';
	}

	//--------------------------------------------------------------------------

}