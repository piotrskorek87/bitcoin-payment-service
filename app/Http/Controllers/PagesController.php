<?php 

namespace App\Http\Controllers;

use App\User;
use App\Item;
use App\Category;

class PagesController extends Controller {

	public function getStoreIndex($name)
	{
		$user = User::where('name', $name)->first();
		if(!$user){
			return redirect('/');
		}
        $items = Item::where('user_id', $user->id)->get();
        $categories = Category::where('user_id', $user->id)->get();

		return view('pages.index')->with('categories', $categories)->with('items', $items)->with('user', $user);
	}

	public function getIndex()
	{

		$user = new User;
		$user->name = 'nouser';

		return view('pages.welcome')->with('user', $user);
	}

	public function getAdmin()
	{
		
		return view('pages.admin');
	}

}