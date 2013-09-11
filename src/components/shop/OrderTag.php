<?php namespace Devhook\Shop;

use \Model;
// use DB;
// use URL;

class OrderTag extends Model
{

	//--------------------------------------------------------------------------

	protected $table = 'order_tags';
	protected $viewsList = array(
		0 => 'Иконка + текст',
		1 => 'Иконка',
		2 => 'Текст',
		3 => 'Цветная иконка',
	);

	//--------------------------------------------------------------------------

	protected function initFields()
	{
		return array(
			'id' => array('db' => 'increments'),

			'title' => array(
				'label' => 'Название',
				'rules' => 'required',
				'field' => 'text',
			),

			'view' => array(
				'label' => 'Отображать как',
				'options' => $this->viewsList,
				'rules' => 'required',
				'field' => 'select',
			),

			'color' => array(
				'label' => 'Цвет статуса',
				'field' => 'color',
			),

			'icon' => array(
				'label' => 'Иконка',
				'field' => 'icon',
			),
		);
	}

	//--------------------------------------------------------------------------

	protected function modelActions()
	{
		$link = 'shop/settings/order-tags';
		return array(
			'list' => array(
				'title' => 'Просмотр',
				'link'  => $link,
			),
			'add' => array(
				'title' => 'Добавить',
				'link'  => $link . '/add',
			),
		);
	}

	//--------------------------------------------------------------------------

	public function rowActions()
	{
		$link = 'shop/settings/order-tags';

		return array(
			'edit' => array(
				'title' => 'Редактировать',
				'link'  => $link . '/edit/' . $this->id,
			),
			'remove' => array(
				'title' => 'Удалить',
				'link'  => $link . '/remove/' . $this->id,
			),
			// 'status' => array(
			// 	'title' => $this->status ? 'Отключить' : 'Включить',
			// 	'link'  => $link . '/status/' . ((int) !$this->status),
			// ),
		);
	}

	/***************************************************************************
		STATIC API:
	***************************************************************************/





	/***************************************************************************
		OBJECT API:
	***************************************************************************/

	public function getLabelAttribute() {
		$label = \iElem::make('span')->className('label')->attr('style', 'background:' . $this->color);
		$bg    = " style='background:{$this->color}'";
		$icon  = "<i class='icon-{$this->icon} icon-large'></i>";
		switch ($this->view) {
			case 0: return "<span class='label label-default'{$bg}>{$icon} {$this->title}</span>";
			case 1: return "<span class='label label-default'{$bg} title='{$this->title}'>{$icon}</span>";
			case 2: return "<span class='label label-default'{$bg}>{$this->title}</span>";
			case 3: return "<i class='icon-{$this->icon} icon-large' style='color:{$this->color}' title='{$this->title}'></i>";
		}
	}

	//--------------------------------------------------------------------------
}
