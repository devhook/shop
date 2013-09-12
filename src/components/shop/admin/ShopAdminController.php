<?php namespace Devhook\Shop;

use \Redirect;
use \Input;
use \Request;
use \Admin;
use \AdminUI;
use \View;

class ShopAdminController extends \AdminController {


	//--------------------------------------------------------------------------

	protected $comName = 'shop';

	//--------------------------------------------------------------------------

	protected function init()
	{
		AdminUI::menu('navbar')->active('shop');

		AdminUI::menu('subnav')->add('shop', 'Главная')->largeIcon('home');
		AdminUI::menu('subnav')->add('shop/orders', 'Заказы')->largeIcon('inbox')->badge( Order::countNew() );
		AdminUI::menu('subnav')->add('shop/catalogue', 'Каталог')->largeIcon('folder-open');
		AdminUI::menu('subnav')->add('shop/stat', 'Статистика')->largeIcon('bar-chart');
		AdminUI::menu('subnav')->add('shop/settings', 'Настройки')->largeIcon('cog');
	}

	//--------------------------------------------------------------------------

	public function viewPath()
	{
		return __DIR__ . '/views/';
	}

	//--------------------------------------------------------------------------

	public function getIndex()
	{
		return 'shop index';
	}

	//--------------------------------------------------------------------------

	public function route($action)
	{
		return '<div class="alert alert-info text-center"> <i class="icon-gears icon-5x"></i><br>Under construction</div>';
	}

	/***************************************************************************
		Общие методы
	***************************************************************************/

	public function action($action, $id = null)
	{
		$action       = ucfirst($action);
		$actionMethod = strtolower($_SERVER['REQUEST_METHOD']) . $action;
		if (method_exists($this, $actionMethod)) {
			return $this->$actionMethod($id);
		}
	}

	//--------------------------------------------------------------------------

	public function getAdd()
	{
		$form = \iForm::model($this->model);

		return View::make('admin.form')
			->with('form', $form);
	}

	//--------------------------------------------------------------------------

	public function postAdd()
	{
		if ($this->model->save()) {
			return \Admin::redirect($this->link);
		}

		return Redirect::back()
			->withErrors($this->model->validator())
			->withInput(Input::input());
	}

	//--------------------------------------------------------------------------

	public function getEdit($id)
	{
		$data = $this->model->find($id);

		$form = \iForm::model($data);

		return View::make('admin.form')
			->with('form', $form);
	}

	//--------------------------------------------------------------------------

	public function postEdit($id)
	{
		$data = $this->model->find($id);
		// $data->setData();

		if ($data->save()) {
			return \Admin::redirect($this->link);
		}

		return Redirect::back()
			->withErrors($data->validator())
			->withInput(Input::input());
	}

	//--------------------------------------------------------------------------

	public function getRemove($id)
	{
		$this->model->find($id)->forceDelete();
		return Redirect::back();
	}

	//--------------------------------------------------------------------------

	protected function setModelActions($model)
	{
		$actions = (array) $model::modelActions();
		foreach ($actions as $key => $act) {
			AdminUI::menu('actions')->add($act['link'], $act['title']);
		}
	}

}