<?php namespace Devhook\Shop;

use \Model;
// use DB;
// use URL;

class OrderStatus extends Model
{

	//--------------------------------------------------------------------------

	protected $table = 'order_statuses';

	protected $typeList = array(
		'0' => '',
		1 => 'Новый заказ (списывает товар со склада)',
		2 => 'Заказ в процессе',
		3 => 'Заказ завершен',
		4 => 'Заказ отменен (возвращает товар на склад)',
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

			'system' => array(
				'label' => '<i class="icon-lock"></i>'
			),
			'type' => $this->system ? '' : array(
				'label'   => 'Тип статуса',
				'options' => $this->typeList,
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
		$link = 'shop/settings/order-statuses';
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
		$link = 'shop/settings/order-statuses';

		$actions = array(
			'edit' => array(
				'title' => 'Редактировать',
				'link'  => $link . '/edit/' . $this->id,
			),
			'remove' => array(
				'title' => '',
				'icon' => 'remove',
				'class' => 'danger' . ($this->system ? ' disabled' : ''),
				'link'  => $this->system ? false : $link . '/remove/' . $this->id,
			)
			// 'status' => array(
			// 	'title' => $this->status ? 'Отключить' : 'Включить',
			// 	'link'  => $link . '/status/' . ((int) !$this->status),
			// ),
		);

		return $actions;
	}

	/***************************************************************************
		STATIC API:
	***************************************************************************/





	/***************************************************************************
		OBJECT API:
	***************************************************************************/

	public function getTypeLabelAttribute()
	{
		return $this->typeList[$this->type];
	}

	//--------------------------------------------------------------------------
}
