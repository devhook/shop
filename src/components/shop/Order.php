<?php namespace Devhook\Shop;

use \Model;
// use DB;
// use URL;

class Order extends Model
{

	//--------------------------------------------------------------------------

	protected $table = 'orders';

	//--------------------------------------------------------------------------

	protected function initFields()
	{
		return array(
			'id'      => array('db' => 'increments'),
			'user_id' => array(),

			'status' => array(
				'label'   => 'Status',
				'field'   => 'select',
				'default' => 1,
				'options' => static::statusList(),
				'db'      => 'integer:4',
			),

			// CUSTOMER:
			'firstname' => array(
				'label'      => 'Имя',
				'field'      => 'text',
			),
			'lastname' => array(
				'label'      => 'Фамилия',
				'field'      => 'text',
			),
			'email' => array(
				'label'      => 'E-mail',
				'field'      => 'text',
			),
			'phone' => array(
				'label' => 'Телефон',
				'field' => 'text',
			),
			'comments' => array(
				'label'      => 'Комментарии к заказу',
				'field'      => 'textarea',
			),
			'user_ip' => array(
				'default' => $_SERVER['REMOTE_ADDR'],
			),

			// ADDRESS:
			'country' => array(
				'label'      => 'Страна',
				'field'      => 'text',
			),
			'region' => array(
				'label'      => 'Регион',
				'field'      => 'text',
			),
			'city' => array(
				'label'      => 'Город',
				'field'      => 'text',
			),
			'metro' => array(
				'label'      => 'Метро',
				'field'      => 'text',
			),
			// 'country_id' => array(),
			// 'city_id' => array(),
			// 'region_id' => array(),
			'adress' => array(
				'label'      => 'Адрес',
				'field'      => 'text',
			),
			'street' => array(
				'label'      => 'Улица',
				'field'      => 'text',
			),
			'street_number' => array(
				'label'      => 'Дом',
				'field'      => 'text',
			),
			'building' => array(
				'label'      => 'Корпус',
				'field'      => 'text',
			),
			'block' => array(
				'label'      => 'Строение',
				'field'      => 'text',
			),
			'apartment' => array(
				'label'      => 'Квартира',
				'field'      => 'text',
			),
			'postcode' => array(
				'label'      => 'Почтовый индекс',
				'field'      => 'text',
			),

			// ORDER:
			'note' => array(
				'label' => 'Примечание',
				'field' => 'textarea',
			),
			'shipping_id' => array(
				'label' => 'Способ доставки',
				'field' => 'text',
			),
			'shipping_at' => array(
				'label' => 'Дата доставки',
				'field' => 'text',
			),
			'payment_id' => array(
				'label' => 'Способ оплаты',
				'field' => 'text',
			),
			'total' => array(
				'label' => 'Итого',
				'field' => 'text',
			),

			// TIMESTAMPS:
			'created_at' => array(),
			'updated_at' => array(),
		);
	}

	/***************************************************************************
		RELATIONS:
	***************************************************************************/

	public function user()
	{
		return $this->belongsTo('User');
	}

	//--------------------------------------------------------------------------

	public function orderProducts()
	{
		return $this->hasMany('OrderProduct');
	}

	//--------------------------------------------------------------------------

	public function orderStatus()
	{
		return $this->belongsTo('OrderStatus', 'status');
	}

	//--------------------------------------------------------------------------

	public function orderTags()
	{
		return $this->belongsToMany('OrderTag', 'order_tags_relations', 'order_id', 'tag_id');
	}

	/***************************************************************************
		STATIC API:
	***************************************************************************/

	protected static function statusList()
	{
		static $statuses;

		if (is_null($statuses)) {
			$result = OrderStatus::orderBy('type')->orderBy('id')->get();
			foreach ($result as $row) {
				$statuses[$row->id] = $row;
			}
		}

		return $statuses;
	}

	//--------------------------------------------------------------------------

	protected static function tagList()
	{
		static $tags;

		if (is_null($tags)) {
			$result = OrderTag::all();
			foreach ($result as $row) {
				$tags[$row->id] = $row;
			}
		}

		return $tags;
	}

	//--------------------------------------------------------------------------

	protected static function countNew()
	{
		return static::where('status', 1)->count();
	}



	/***************************************************************************
		OBJECT API:
	***************************************************************************/


	/***************************************************************************
		ACCESSOR & MUTATOR:
	***************************************************************************/

	public function getAdressAttribute()
	{
		$adress = $this->street;
		if ($this->street_number)  $adress .= " " . $this->street_number;
		if ($this->building)  $adress .= ", корп. " . $this->building;
		if ($this->block)     $adress .= ", стр. " . $this->block;
		if ($this->apartment) $adress .= ", кв. " . $this->apartment;

		return $adress;
	}

	//--------------------------------------------------------------------------

	// public function getStatusLabelAttribute()
	// {
	// 	$statuses = $this->statusList();
	// 	return $statuses[$this->status]->title;
	// }

	// //--------------------------------------------------------------------------

	// public function getStatusColorAttribute()
	// {
	// 	$statuses = $this->statusList();
	// 	return $statuses[$this->status]->color;
	// }

	// //--------------------------------------------------------------------------

	// public function getStatusIconAttribute()
	// {
	// 	$statuses = $this->statusList();
	// 	return $statuses[$this->status]->icon;
	// }

	//--------------------------------------------------------------------------

	// public function getCreatedAttribute()
	// {
	// 	return $this->created_at;
	// }

	// //--------------------------------------------------------------------------

	// public function getUpdatedAttribute()
	// {
	// 	return $this->updated_at;
	// }
}
