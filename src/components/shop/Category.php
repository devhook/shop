<?php namespace Devhook\Shop;

use Admin;
use Model;
use DB;
use URL;

class Category extends Model
{

	//--------------------------------------------------------------------------

	protected $table = 'categories';

	//--------------------------------------------------------------------------

	protected function initFields()
	{
		return array(
			'id'          => array(),
			'category_id' => array(),
			'priority'    => array(),

			'enabled' => array(
				'label'   => 'Статус',
				'field'   => 'toggle',
				'default' => 1,
			),

			'title' => array(
				'label'      => 'Название',
				'field'      => 'text',
				'rules'      => 'required|between:2,255',
			),

			// 'url' => array(
			// 	'label'      => 'URL',
			// 	'field'      => 'text',
			// 	'rules'      => 'between:2,255',
			// ),

			'image' => array(
				'label'      => 'Изображение',
				'field'      => 'image',
			),

			'description' => array(
				'label'      => 'Описание',
				'field'      => 'html',
			),
			'description2' => array(
				'label'      => 'Дополнительное описание',
				'field'      => 'html',
			),

			'total' => array(
				'label' => 'Всего товаров',
			),

			'total_allowed' => array(
				'label' => 'Доступно товаров',
			),

			'created_at' => array(),
			'updated_at' => array(),
			'creator_id' => array(),
			'updater_id' => array(),
		);
	}

	//--------------------------------------------------------------------------

	public function editAction()
	{
		return 'shop/catalogue/category/' . $this->getKey();
	}

	/***************************************************************************
		STATIC API:
	***************************************************************************/

	protected static function getByParent($pid)
	{
		return static::sorted()
			->lightSelect()
			->where('category_id', $pid)
			->get();
	}



	/***************************************************************************
		OBJECT API:
	***************************************************************************/

	public function breadcrumbs()
	{
		$result = $this->parents();

		if ($this->getKey()) {
			$result->put(null, $this);
		}

		return $result;
	}

	//--------------------------------------------------------------------------

	public function parents()
	{
		if ($this->category_id && ($pids = $this->parentIds(true))) {
			return static::whereIn('id', $pids)->get();
		}

		return new \Illuminate\Support\Collection;
	}

	//--------------------------------------------------------------------------

	public function parentIds($deep = true, $id = null)
	{
		$result = array();

		if (is_null($id)) {
			$id = $this->id;
		}

		if ($pid = DB::table($this->table)->where('id', $id)->pluck('category_id')) {
			$result[$pid] = $pid;
			if ($deep) {
				if ($deep !== true) {
					$deep--;
				}
				$result += $this->parentIds($deep, $pid);
			}
		}

		return $result;
	}

	//--------------------------------------------------------------------------

	public function childs()
	{
		return static::where('category_id', $this->id)->get();
	}

	//--------------------------------------------------------------------------

	public function childIds($deep = false, $pid = null)
	{
		$result = array();
		$pid = (array) (is_null($pid) ? $this->id : $pid);

		if ($ids = DB::table($this->table)->whereIn('category_id', $pid)->lists('id')) {
			$result += $ids;
			if ($deep) {
				if ($deep !== true) {
					$deep--;
				}
				$result += $this->childIds($deep, $ids);
			}
		}

		return $result;
	}

	//--------------------------------------------------------------------------

	public function products($withSubs = true)
	{
		$catIds = $withSubs ? array_merge(array($this->id), $this->childIds(true)) : array($this->id);

		return Product::getByCategoryIds($catIds);
	}




	/***************************************************************************
		SCOPES:
	***************************************************************************/


	public function scopeSorted($query)
	{
		return $query->orderBy('priority')->orderBy('title');
	}

	//--------------------------------------------------------------------------

	public function scopeLightSelect($query)
	{
		return $query->select(array('id', 'category_id', 'title', 'priority'));
	}

	/***************************************************************************
		ACCESSORS & MUTATORS:
	***************************************************************************/


	public function getLinkAttribute()
	{
		return URL::to('category', $this->id);
	}

	//--------------------------------------------------------------------------

	// public function getPidAttribute()
	// {
	// 	return $this->getAttribute('category_id');
	// }

	//--------------------------------------------------------------------------

	// public function getTitleAttribute()
	// {
	// 	return $this->getAttribute('name');
	// }

	//--------------------------------------------------------------------------
}
