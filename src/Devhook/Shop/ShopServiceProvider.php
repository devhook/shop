<?php namespace Devhook\Shop;

use Illuminate\Support\ServiceProvider;
use App;
use Config;
use View;
use User;
use Auth;


class ShopServiceProvider extends ServiceProvider
{

	//--------------------------------------------------------------------------

	protected $aliases = array(
		'Shop'         => 'Devhook\Shop\Shop',
		'Currency'     => 'Devhook\Shop\Currency',
		'Order'        => 'Devhook\Shop\Order',
		'OrderTag'     => 'Devhook\Shop\OrderTag',
		'OrderStatus'  => 'Devhook\Shop\OrderStatus',
		'OrderProduct' => 'Devhook\Shop\OrderProduct',
		'Cart'         => 'Devhook\Shop\Cart',
		'Product'      => 'Devhook\Shop\Product',
		'Category'     => 'Devhook\Shop\Category',
		'Picture'      => 'Devhook\Shop\Picture',
	);

	protected $defer = false;

	//--------------------------------------------------------------------------

	public function register()
	{

	}

	//--------------------------------------------------------------------------

	public function boot()
	{
		if (App::runningInConsole()) {
			return;
		}

		devhook_class_aliases($this->aliases);

		\Shop::boot();
	}

	//--------------------------------------------------------------------------

	public function provides()
	{
		return array();
	}

}