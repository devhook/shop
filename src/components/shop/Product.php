<?php namespace Devhook\Shop;

use Model;
use DB;
use URL;

class Product extends Model
{

	//--------------------------------------------------------------------------

	protected $table   = 'products';
	protected $perPage = 28;

	// protected $adminSettings = array(
	// 	'listFields' => array('product_code', 'name', 'price', 'in_stock'),
	// );

	//--------------------------------------------------------------------------

	protected function initFields()
	{
		return array(
			'id' => array(),

			'enabled' => array(
				'label'   => 'Статус',
				'field'   => 'toggle',
				'default' => 1,
			),

			'category_id' => array(),
			'product_id'  => array(),
			'brand_id' => array(),
			'priority' => array(),

			// 'enabled' => array(),
			'status' => array(),

			'sku' => array(
			// 'product_code' => array(
				'label'      => 'SKU',
				'field'      => 'text',
				'rules'      => 'required',
			),

			'title' => array(
			// 'name' => array(
				'label'      => 'Название',
				'field'      => 'text',
				'rules'      => 'required',
			),

			'short_description' => array(
				'label'      => 'Краткое описание',
				'field'      => 'textarea',
			),

			'description' => array(
				'label'      => 'Описание',
				'field'      => 'html',
			),

			'price' => array(
				'label'      => 'Цена',
				'field'      => 'text',
				'rules'      => 'required',
				// 'db'         => 'float',
			),

			'original_price' => array(
			// 'list_price' => array(
				'label'      => 'Оригнальная цена',
				'field'      => 'text',
				'rules'      => 'required',
				// 'db'         => 'float',
			),

			'in_stock' => array(
				'label'      => 'Наличие',
				'field'      => 'text',
				// 'rules'      => 'required',
				// 'db'         => 'float',
			),

			'image' => array(
				'label' => 'Изображения',
				'field' => array(
					'type'     => 'image',
					'mode'     => 'multiple',
					'path'     => 'files/product',
					'moveFile' => function($row, $file, $image){
						$id = $row->getKey();
						$dir = floor($id / 100) * 100;
						return 'files/product/' . $dir . '/' . $id . '/' . $image->getKey() . '.' . $file->getExtension();
					},
					'sizes'    => array(
						'thumb' => array(100, 100, true),
						'small' => array(200, 200, true),
						'large' => array(800, 600, false),
					)
				),
			),

			'created_at' => array(),
			'updated_at' => array(),
			'creater_id' => array(),
			'updater_id' => array(),
		);
	}



	/***************************************************************************
		STATIC API:
	***************************************************************************/

	protected static function getByCategoryIds($ids)
	{
		return static::select('*')
			->with('thumb')
			->allowed()
			->whereIn('category_id', $ids)
			->sorted()
			->paginate();
	}



	/***************************************************************************
		OBJECT API:
	***************************************************************************/



	/***************************************************************************
		SCOPES:
	***************************************************************************/

	public function scopeAllowed($query)
	{
		return $query->where('enabled', 1)
			->where('product_code_group', '')
			->whereRaw('price > 0');
	}

	//--------------------------------------------------------------------------


	public function scopeSorted($query)
	{
		return $query->addSelect(DB::raw('IF(in_stock,1,0) in_stock, IF(default_picture,1,0) AS have_picture'))
			->orderBy('in_stock', 'desc')
			->orderBy('have_picture', 'desc')
			->orderBy('name');
	}



	/***************************************************************************
		RELATIONS:
	***************************************************************************/

	public function thumb()
	{
		return $this->hasOne('Picture', 'product_id');
		// return $this->hasOne('Picture', 'id', 'default_picture');
	}



	/***************************************************************************
		ACCESSORS & MUTATORS:
	***************************************************************************/

	public function getLinkAttribute()
	{
		return URL::to('product', $this->id);
	}

	//--------------------------------------------------------------------------

	public function getCartLinkAttribute()
	{
		return URL::to('cart/add', $this->id);
	}

	//--------------------------------------------------------------------------

	// public function getFPriceAttribute()
	// {
	// 	return number_format($this->price, 0, '', ' ');
	// }

	//--------------------------------------------------------------------------

	public function getTotalPriceAttribute()
	{
		if ( ! $this->qty) {
			$this->qty = 1;
		}

		return $this->price * $this->qty;
	}

	//--------------------------------------------------------------------------

	// public function getFTotalPriceAttribute()
	// {
	// 	return number_format($this->totalPrice, 0, '', ' ');
	// }

	//--------------------------------------------------------------------------
}