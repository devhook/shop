<?php namespace Devhook\Shop;

use Redirect;
use Session;
use Input;
use iForm;

class CartController extends ShopController
{

	//--------------------------------------------------------------------------

	public function getIndex()
	{
		return $this->view('cart/cart')
			->with('products', Cart::content());
	}

	//--------------------------------------------------------------------------

	public function getCheckout()
	{
		$user      = app('user');
		$loginForm = iForm::model($user, 'loginRules', 'login_');
		$userForm  = iForm::model($user);

		return $this->view('cart/checkout')
			->with('loginForm', $loginForm)
			->with('userForm', $userForm);
	}

	//--------------------------------------------------------------------------

	public function postCheckout()
	{
		$user = app('user');
		$redirect = Redirect::back();
		// Session::put('input', Input::all());
		if (!$user->validate())
		{
			$redirect->withErrors($user->validator());
		}
		if (!$user->validate('loginRules', 'login_'))
		{
			$redirect->withErrors($user->validator());
		}

		return $redirect->withInput(Input::all());
	}

	//--------------------------------------------------------------------------

	public function missingMethod($parameters)
	{
		$validActions = array(
			'add',
			'update',
			'remove',
			'clear',
		);

		$action = array_shift($parameters);

		if (in_array($action, $validActions)) {
			call_user_func_array(array('Cart', $action), $parameters);
			return Redirect::back();
		}

		return parent::missingMethod($parameters);
	}

	//--------------------------------------------------------------------------
}