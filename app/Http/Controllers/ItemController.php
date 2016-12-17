<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Category;
use App\Item;
use App\Photo;
use App\User;
use App\Basket\Basket;
use Auth;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($name)
    {
        $user = User::where('name', $name)->first();
        if(!$user){
            return redirect('/admin');
        }

        $items = Item::where('user_id', $user->id)->get();
        $categories = Category::where('user_id', $user->id)->get();
        return view('item.index')->with('categories', $categories)->with('items', $items)->with('user', $user);
    }

    public function category($name, Request $request)
    {
        $searchData = explode('|||',$request->category);
        $category = $searchData[0];
        $user_id = $searchData[1];
        $user = User::where('id', $user_id)->first();
        $category = Category::where('id', $category)->where('user_id', $user_id)->first();
        $items = Item::where('category_id', $category->id)->where('user_id', $user_id)->get();
        $categories = Category::where('user_id', $user_id)->get();
        return view('item.category')->with('items', $items)->with('mainCategory', $category)->with('categories', $categories)->with('user', $user);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('user_id', Auth::User()->id)->get();
        return view('item.create')->with('categories', $categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $filename = date("DMjGisY")."".rand(1000,9999).".jpg";

        if($request->file('photo')){
            $request->file('photo')->move('uploads', $filename);
        }

        $item = new Item;

        $item->user_id = Auth::User()->id;
        $item->name = $request->name;
        $item->description = $request->description;
        $item->category_id = $request->category;
        $item->price = $request->price;
        $item->seller_email = $request->seller_email;
        $item->save();

        $item->photo()->create([
            'filename' => $filename,
            'thumbnail' => 1,
        ]);

        return redirect()->route('admin');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($name, $id, Basket $basket)
    {
        $user = User::where('name', $name)->first();
        if(!$user){
            return redirect('/');
        }
        $item = Item::where('id', $id)->where('user_id', $user->id)->first();
        return view('item.show')->with('item', $item)->with('basket', $basket)->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Item::where('id', $id)->where('user_id', Auth::User()->id)->first();
        $categories = Category::where('user_id', Auth::User()->id)->get();
        return view('item.edit')->with('item', $item)->with('categories', $categories);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $item = Item::find($request->id);

        $item->name = $request->name;
        $item->description = $request->description;
        $item->category_id = $request->category;
        $item->price = $request->price;
        $item->seller_email = $request->seller_email;
        $item->save();

        if($request->file('photo')){
            $filepath = "uploads". $item->thumbnail()->filename;
                if (file_exists($filepath)) {
                    unlink($filepath);
                }
                $request->file('photo')->move('uploads', $item->thumbnail()->filename);
        }        

        return redirect(url('/admin'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Item::where('id', $id)->where('user_id', Auth::User()->id)->first();
        $item->delete();

        $thumbnail = "uploads/".$item->thumbnail()->filename; 
        if (file_exists($thumbnail)) {
            unlink($thumbnail);
            $thumbnail = Photo::where('filename', $item->thumbnail()->filename)->first();
            $thumbnail->delete();
        }
        return redirect(url('/admin'));
    }
}
