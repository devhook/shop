<?php namespace Devhook\Shop;



class CategoryController extends ShopController
{

	//--------------------------------------------------------------------------

	public function getIndex() {
		return 'index';
	}

	//--------------------------------------------------------------------------

	public function missingMethod($args)
	{
		$id       = $args[0];
		$category = Category::find($id);

		// 404
		if ( ! $category) {
			return App::abort(404, 'Page not found');
		}

		// 301
		if ($id != $category->id || isset($args[1])) {
			return Redirect::to($category->link(), 301);
		}

		$category->active = true;

		return $this->view('product/grid')
			->with('category', $category)
			->with('breadcrumbs', $category->breadcrumbs())
			->with('subcategories', $category->childs())
			->with('products', $category->products());
	}

	//--------------------------------------------------------------------------
}