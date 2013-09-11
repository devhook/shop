<?php namespace Devhook\Shop;

use App;
use DB;

class OrdersAdminController extends ShopAdminController
{

	//--------------------------------------------------------------------------

	protected function init()
	{
		parent::init();

		\AdminUI::menu('subnav')->active('shop/orders');
	}

	//--------------------------------------------------------------------------

	public function getIndex()
	{
		$view = $this->view('order/list');

		$data = Order::with('user', 'orderStatus', 'orderTags')->orderBy('id', 'desc')->paginate(30);

		$view->with('data', $data);

		$view->with('pagination', $data->links());
		$view->with('statusList', Order::statusList());

		return $view;
	}

	//--------------------------------------------------------------------------

	public function anyAjax($id, $action, $action_id = null, $cmd = null)
	{
		$this->layout = null;

		$order = Order::find($id);

		if (!$order) {
			return '{"status":"error"}';
		}

		switch ($action) {
			case 'tag':
				if ($cmd) {
					if ( ! DB::table('order_tags_relations')->where('order_id', $id)->where('tag_id', $action_id)->count()) {
						DB::table('order_tags_relations')->insert(array(
							'order_id' => $id,
							'tag_id'   => $action_id,
						));
					}
				} else {
					DB::table('order_tags_relations')->where('order_id', $id)->where('tag_id', $action_id)->delete();
				}
		}

		return '{"status":"success"}';
	}

	//--------------------------------------------------------------------------

	public function route($id = null)
	{
		$order = Order::with(array('user', 'orderStatus', 'orderTags', 'orderProducts.product.thumb'))->find($id);

		if (! $order) {
			App::abort(404, 'Page not found');
		}

		$view = $this->view('order/edit');

		$view->with('orderTagsAll',  Order::tagList());
		$view->with('order', $order);
		$view->with('ajaxAction', \Admin::url('shop/orders/ajax') . '/' . $order->id . '/');
		$view->with('form', \iForm::model($order));

		// $view->with('products', $order->products);
		// $view->with('products',  <? $products = OrderProduct::with('product')->where('order_id', $order->id)->get() );

		return $view;
	}

	//--------------------------------------------------------------------------

}