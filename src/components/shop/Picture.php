<?php namespace Devhook\Shop;

use \Model;

class Picture extends Model
{
	protected $table = 'product_pictures';



	/***************************************************************************
		ACCESSORS & MUTATORS:
	***************************************************************************/

	public function small()
	{
		return "<img src='{$this->small}' alt='' />";
	}

	//--------------------------------------------------------------------------

	protected function getSmallAttribute()
	{
		return $this->img_medium;
	}

	//--------------------------------------------------------------------------

	public function mini()
	{
		return "<img src='{$this->mini}' alt='' />";
	}

	//--------------------------------------------------------------------------

	protected function getMiniAttribute()
	{
		return $this->img_small;
	}

	//--------------------------------------------------------------------------
}