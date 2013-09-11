<?php namespace Devhook\Shop;

use \Request;
use \Route;
use \Config;
use \Admin;
use \AdminUI;

class Shop {

	//--------------------------------------------------------------------------

	public static function boot()
	{
		static $booted;
		if ($booted) {
			return;
		}
		$booted = true;

		Cart::boot();

		if (Admin::enable()) {
			AdminUI::menu('navbar')->add('shop', 'Магазин')->icon('shopping-cart');
		}

		if (Admin::currentMode() == 'admin') {
			static::bootBackend();
		} else {
			// static::bootFrontend();
		}
	}

	//--------------------------------------------------------------------------

	public static function bootBackend()
	{
		Admin::route('shop', function(){
			Route::controller('orders',    'Devhook\Shop\OrdersAdminController');
			Route::controller('catalogue', 'Devhook\Shop\CatalogueAdminController');
			Route::controller('settings',  'Devhook\Shop\SettingsAdminController');
			Route::controller('',          'Devhook\Shop\ShopAdminController');
		});
	}

}