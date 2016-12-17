<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

	// Authentication Routes
	Route::get('auth/login', ['as' => 'login', 'uses' => 'Auth\AuthController@getLogin']);
	Route::post('auth/login', ['as' => 'login', 'uses' => 'Auth\AuthController@postLogin']);
	Route::get('auth/logout', ['as' => 'logout', 'uses' => 'Auth\AuthController@getLogout']);

	// Registration Routes
	Route::get('auth/register', ['as' => 'register', 'uses' => 'Auth\AuthController@getRegister']);
	Route::post('auth/register', ['as' => 'register', 'uses' => 'Auth\AuthController@postRegister']);

	// Route::get('contact', 'PagesController@getContact');
	// Route::get('about', 'PagesController@getAbout');
	Route::get('admin', ['as' => 'admin',
						 'uses' => 'PagesController@getAdmin',
						 'middleware' => 'auth',
						]);
	Route::get('/{name}', 'PagesController@getStoreIndex');

	Route::get('/', 'PagesController@getIndex');


	// Category Routes
	Route::get('category/create', ['as' => 'category.create',
							   	   'uses' => 'CategoryController@create',
							       'middleware' => 'auth',
							      ]);

	Route::post('category/store', ['as' => 'category.store',
							  	   'uses' => 'CategoryController@store',
							       'middleware' => 'auth',
							   	  ]);

	// Credentials Routes
	Route::get('credentials/create', ['as' => 'credentials.create',
							   	      'uses' => 'CredentialsController@create',
							          'middleware' => 'auth',
							         ]);

	Route::post('credentials/store', ['as' => 'credentials.store',
							  	      'uses' => 'CredentialsController@store',
							          'middleware' => 'auth',
							   	     ]);


	// Item Routes 
	Route::get('item/create', ['as' => 'item.create',
							   'uses' => 'ItemController@create',
							   'middleware' => 'auth',
							  ]);

	Route::post('item/store', ['as' => 'item.store',
							   'uses' => 'ItemController@store',
							   'middleware' => 'auth',
							  ]);

	Route::get('item/edit/{id}', ['as' => 'item.edit',
							      'uses' => 'ItemController@edit',
								  'middleware' => 'auth',
								 ]);

	Route::post('item/update', ['as' => 'item.update',
							    'uses' => 'ItemController@update',
								'middleware' => 'auth',
							   ]);

	Route::get('item/delete/{id}', ['as' => 'item.delete',
							        'uses' => 'ItemController@destroy',
								    'middleware' => 'auth',
								   ]);

	Route::get('{name}/item/show/{id}', ['as' => 'item.show',
							             'uses' => 'ItemController@show',
									    ]);

	Route::get('{name}/item/index', ['as' => 'item.index',
								     'uses' => 'ItemController@index',
								     'middleware' => 'auth',
									]);

	Route::post('{name}/item/category', ['as' => 'item.category',
							 	         'uses' => 'ItemController@category',
										]);


	// Cart Routes
	Route::get('{name}/cart/index', ['as' => 'cart.index',
							  		 'uses' => 'CartController@index',
							 		]);

	Route::get('{name}/cart/add/{id}/{quantity}', ['as' => 'cart.add',
							     			       'uses' => 'CartController@add',
						       			 		  ]);

	Route::post('{name}/cart/update/{id}', ['as' => 'cart.update',
							     		    'uses' => 'CartController@update',
						       	  		   ]);


	// Order Routes
	Route::get('{name}/order/index', ['as' => 'order.index',
							 		  'uses' => 'OrderController@index',
							 		 ]);

	Route::post('{name}/order/create', ['as' => 'order.create',
							  			'uses' => 'OrderController@create',
							  		   ]);

	Route::get('{name}/order/show/{hash}', ['as' => 'order.show',
							      	        'uses' => 'OrderController@show',
							       		   ]);
	

	// Payment Routes
	Route::post('payment/show', ['as' => 'payment.show',
								 'uses' => 'PaymentController@show'
								]);

	// Route::get('payment/markaspaid/{transactionId}', ['as' => 'payment.markaspaid',
	// 												  'uses' => 'PaymentController@markAsPaid'
	// 												 ]);
