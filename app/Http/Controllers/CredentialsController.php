<?php 

namespace App\Http\Controllers;

use App\Item;
use App\Block_io_account;
use App\User;
use Auth;
use App\Http\Requests\CredentialsCreateRequest;

class CredentialsController extends Controller {

	public function Create() {

		return view('credentials.index');
	}

	public function Store(CredentialsCreateRequest $request, Block_io_account $block_io_account) {

		$block_io_account = $block_io_account->where('user_id', Auth::User()->id)->first();
		if(!$block_io_account){
			$block_io_account = new Block_io_account;
			$block_io_account->user_id = Auth::User()->id;			
			$block_io_account->api_key = $request->api_key;
			$block_io_account->pin = $request->pin;	
			$block_io_account->primary_address = $request->primary_address;	
			$block_io_account->save();
		}else{
			$block_io_account =  Auth::User()->block_io_account;
			$block_io_account->api_key = $request->api_key;
			$block_io_account->pin = $request->pin;	
			$block_io_account->primary_address = $request->primary_address;	
			$block_io_account->save();			
		}

		return redirect('admin');
	}

}