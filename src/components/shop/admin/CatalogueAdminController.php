<?php namespace Devhook\Shop;

use \DB;
use \Page;
use \Request;
use \Redirect;
use \Admin;
use \AdminUI;
use \iElem;
use \View;

class CatalogueAdminController extends ShopAdminController {

	//--------------------------------------------------------------------------

	protected function init()
	{
		parent::init();

		Page::title('Магазин: Каталог');

		AdminUI::menu('subnav')->active('shop/catalogue');

		AdminUI::menu('tabs')->add('shop/catalogue',            'Товары');
		AdminUI::menu('tabs')->add('shop/catalogue/categories', 'Категории');
		AdminUI::menu('tabs')->add('shop/catalogue/brands',     'Бренды');
		AdminUI::menu('tabs')->add('shop/catalogue/properties', 'Свойства');
		AdminUI::menu('tabs')->add('shop/catalogue/migration', '!!!MIGRATION');
	}

	//--------------------------------------------------------------------------

	public function getIndex()
	{
		return $this->getProducts();
	}

	//--------------------------------------------------------------------------

	public function getProducts($ctegory_id = null)
	{
		Page::title('Магазин: Каталог / Товары');
		AdminUI::menu('tabs')->active('shop/catalogue/products');
		$view = $this->view('catalogue/products');

		// $category  = Category::find($id);
		$data      = Product::paginate(30);
		// $childrens = Category::select('category_id', \DB::raw('COUNT(id) AS childs'))->groupBy('category_id')->whereIn('category_id', $data->lists('id'))->lists('childs', 'category_id');

		// // Breadceumbs
		// if ($category && $breadcrumbs = $category->breadcrumbs()) {
		// 	$category->active = true;

		// 	$breadcrumbs->push((object)array('id' => null, 'title' => 'Категории'));

		// 	AdminUI::breadcrumbs($breadcrumbs, array('link'=>function($row){
		// 		return Admin::url('shop/catalogue/categories', $row->id);
		// 	}));
		// }

		$view->data      = $data;
		// $view->childrens = $childrens;

		return $view;
	}


	/***************************************************************************
		Категории
	***************************************************************************/

	public function anyCategory($id)
	{
		AdminUI::menu('tabs')->active('shop/catalogue/categories');

		$this->link  = 'shop/catalogue/category/' . $id;
		$this->model = Category::find($id);
		Page::title('Магазин: Категории / ' . $this->model->title);

		return $this->action('edit', $id);
	}

	//--------------------------------------------------------------------------

	public function getCategories($id = 0)
	{
		Page::title('Магазин: Каталог / Категории');
		AdminUI::menu('tabs')->active('shop/catalogue/categories');
		$view = $this->view('catalogue/categories');

		$category  = Category::find($id);
		$data      = Category::where('category_id', $id)->orderBy('priority')->orderBy('title')->get();
		$childrens = Category::select('category_id', \DB::raw('COUNT(id) AS childs'))->groupBy('category_id')->whereIn('category_id', $data->lists('id'))->lists('childs', 'category_id');

		// Breadceumbs
		if ($category && $breadcrumbs = $category->breadcrumbs()) {
			$category->active = true;

			$breadcrumbs->push((object)array('id' => null, 'title' => 'Категории'));

			AdminUI::breadcrumbs($breadcrumbs, array('link'=>function($row){
				return Admin::url('shop/catalogue/categories', $row->id);
			}));
		}

		$view->data      = $data;
		$view->childrens = $childrens;

		return $view;
	}

	/***************************************************************************
		Бренды
	***************************************************************************/

	public function getBrands()
	{
		Page::title('Магазин: Каталог / Бренды');
		// Protduct::
	}

	//--------------------------------------------------------------------------

	public function getMigration($act = null, $page = 1)
	{
		$updated = 0;
		$total = 0;
		$perIteration = 200;
		switch ($act) {
			case 'product-images':
				set_time_limit(0);
				$total    = Product::count();
				$products = Product::select('id', 'image')->forPage($page, $perIteration)->get();
				// $products = Product::forPage($page, $perIteration)->get();
				if ( ! count($products)) {
					$page = 0;
					return 'END';
				}

				$page ++;

				foreach ($products as $product) {
					$images = DB::table('product_pictures')->where('product_id', $product->id)->get();

					foreach ($images as $img) {
						$file = public_path(trim($img->img_large, '/'));
						if (!file_exists($file)) continue;
						\ImageField::setValue($product, 'image', array('image'=>$file));

						// print_r($product->getAttribute('image'));exit;
						if ($product->forceSave()) {
							// echo $product->sku;

						}
						else {
							print_r($product->errors());exit;
						}
						$updated ++;
					}
				}

				echo Redirect::to( Admin::url('shop/catalogue/migration/product-images' . ($page > 1 ? '/'.$page : '')) );
		}

		//--------------------------------------------------------------------------

		return AdminUI::actions(array(
			array(
				'title' => 'product-images' . ($page > 1 ? ' : '.$page . ' of ' . floor($total/$perIteration) : ''),
				'class' => 'danger',
				'link'  => 'shop/catalogue/migration/product-images' . ($page > 1 ? '/'.$page : ''),
			)
		), '') . ($updated ? ' UPDATED:' . $updated : '');
	}
}