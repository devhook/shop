<?php namespace Devhook\Shop;

use Session;

class Cart
{

	//--------------------------------------------------------------------------

	protected static $data = array();

	//--------------------------------------------------------------------------

	public static function boot()
	{
		static $booted;

		if ( ! $booted) {
			$booted = true;
			self::$data = (array) Session::get('cart');
		}
	}

	/***************************************************************************
		STATIC API:
	***************************************************************************/

	// Cart::add(['id'=>1, 'qty'=>1, 'price'=>99.9, 'name'=>'Product 1']);
	public static function add($product)
	{
		if (is_numeric($product)) {
			$product = Product::find($product);
		}
		$id    = $product->id;
		$price = $product->price;
		$qty   = 1;

		if (isset(self::$data[$id])) {
			// self::$data[$id]['qty']++;
		} else {
			self::$data[$id] = compact('price', 'qty');
		}

		Session::set('cart', self::$data);
	}

	//--------------------------------------------------------------------------

	public static function update($id, $count)
	{
		if ( ! $count) {
			return self::remove($id);
		}

		if (isset(self::$data[$id])) {
			self::$data[$id]['qty'] = $count;
			Session::set('cart', self::$data);
		}
	}

	//--------------------------------------------------------------------------

	public static function remove($id)
	{
		if (isset(self::$data[$id])) {
			unset(self::$data[$id]);
			Session::set('cart', self::$data);
		}
	}

	//--------------------------------------------------------------------------

	public static function get($id)
	{

	}

	//--------------------------------------------------------------------------

	public static function content()
	{
		$ids = array_keys(self::$data);

		if ( ! $ids) {
			return array();
		}

		$products = Product::whereIn('id', $ids)->get();

		foreach ($products as &$row) {
			$row->qty = self::$data[$row->id]['qty'];
		}

		return $products;
	}

	//--------------------------------------------------------------------------

	public static function clear()
	{
		Session::forget('cart');
		self::$data = array();
	}

	//--------------------------------------------------------------------------

	public static function total()
	{
		$result = 0;
		foreach (self::$data as $row) {
			$result += $row['price'] * $row['qty'];
		}

		return $result;
	}

	//--------------------------------------------------------------------------

	public static function count($totalRows = false)
	{
		$result = 0;
		foreach (self::$data as $row) {
			$result += $totalRows ? $row['qty'] : 1;
		}

		return $result;
	}

	//--------------------------------------------------------------------------
}