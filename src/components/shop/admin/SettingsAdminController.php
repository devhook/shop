<?php namespace Devhook\Shop;

use \Page;
use \Request;
use \Redirect;
use \Admin;
use \AdminUI;
use \iElem;
use \View;
use \Input;

class SettingsAdminController extends ShopAdminController {

	//--------------------------------------------------------------------------

	protected function init()
	{
		parent::init();

		Page::title('Магазин: Настройки');

		AdminUI::menu('subnav')->active('shop/settings');

		AdminUI::menu('tabs')->add('shop/settings', 'Магазин');
		AdminUI::menu('tabs')->add('shop/settings/delivery', 'Доставка');
		AdminUI::menu('tabs')->add('shop/settings/payment', 'Оплата');
		AdminUI::menu('tabs')->add('shop/settings/currency', 'Валюта');
		AdminUI::menu('tabs')->add('shop/settings/order-statuses', 'Статусы');
		AdminUI::menu('tabs')->add('shop/settings/order-tags', 'Метки');
	}

	//--------------------------------------------------------------------------

	public function getIndex()
	{
		return 'Магазин';
	}

	//--------------------------------------------------------------------------

	public function getDelivery()
	{
		Page::title('Магазин: Настройки / Способы доставки');
		return 'Доставка';
	}

	//--------------------------------------------------------------------------

	public function getPayment()
	{
		Page::title('Магазин: Настройки / Способы оплаты');

		return 'Оплата';
	}

	//--------------------------------------------------------------------------

	public function getCurrency()
	{
		Page::title('Магазин: Настройки / Валюта');

		return 'Валюта';
	}

	//--------------------------------------------------------------------------

	public function anyOrderStatuses($action = null, $id = null)
	{
		Page::title('Магазин: Настройки / Статусы заказов');

		$this->setModelActions('OrderStatus');
		AdminUI::menu('tabs')->active('shop/settings/order-statuses');

		if ($action) {
			$this->link  = 'shop/settings/order-statuses';
			$this->model = new OrderStatus;
			return $this->action($action, $id);
		}

		return AdminUI::dataTable('OrderStatus', array(
			'columns'  => array(
				'id',
				'title' => function($row) {
					return iElem::make('span')->text($row->title)->icon($row->icon . ' icon-large')->attr('style', 'color:' . $row->color);
				},
				'type' => function ($row) {
					return ($row->system ? '<i class="icon-lock"></i> ' : '') . $row->typeLabel;
				}
			),
			'query' => function($query) {
				$query->orderBy('type')->orderBy('id');
			},
		));
	}

	//--------------------------------------------------------------------------

	public function anyOrderTags($action = null, $id = null)
	{
		Page::title('Магазин: Настройки / Метки заказов');

		$this->setModelActions('OrderTag');
		AdminUI::menu('tabs')->active('shop/settings/order-tags');

		if ($action) {
			$this->link  = 'shop/settings/order-tags';
			$this->model = new OrderTag;
			return $this->action($action, $id);
		}

		return AdminUI::dataTable('OrderTag', array(
			'columns'  => array(
				'id',
				'title' => function($row) {
					return $row->label;
				}
			),
			'query' => function($query) {
				$query->orderBy('id');
			},
		));
	}

	//--------------------------------------------------------------------------
}