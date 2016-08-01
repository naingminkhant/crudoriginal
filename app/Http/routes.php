<?php

Route::get('category', function(){

	return view('category');
});

Route::get('tag',function(){
	return view('tag');
});

Route::resource('/api/category', 'CategoryController');

Route::resource('/api/tag','TagController');

Route::get('/api/tagAll/', function() {	$request = request();
// handle sort option
	if (request()->has('sort')) {
		list($sortCol, $sortDir) = explode('|', request()->sort);
		$query = App\Tags::orderBy($sortCol, $sortDir);
	} else {
		$query = App\Tags::orderBy('id', 'asc');
	}

	if ($request->exists('filter')) {
		$query->where(function($q) use($request) {
			$value = "%{$request->filter}%";
			$q->where('name', 'like', $value)
				->orWhere('title', 'like', $value)
				->orWhere('description', 'like', $value);
		});
	}

	$perPage = request()->has('per_page') ? (int) request()->per_page : null;

	return response()->json(
		$query->paginate($perPage)
	)
		->header('Access-Control-Allow-Origin', '*')
		->header('Access-Control-Allow-Methods', 'GET');
});

Route::get('/api/categoryAll/', function() {	$request = request();

// handle sort option
	if (request()->has('sort')) {
		list($sortCol, $sortDir) = explode('|', request()->sort);
		$query = App\Category::orderBy($sortCol, $sortDir);
	} else {
		$query = App\Category::orderBy('id', 'asc');
	}

	if ($request->exists('filter')) {
		$query->where(function($q) use($request) {
			$value = "%{$request->filter}%";
			$q->where('name', 'like', $value)
				->orWhere('title', 'like', $value)
				->orWhere('description', 'like', $value);
		});
	}

	$perPage = request()->has('per_page') ? (int) request()->per_page : null;

	return response()->json(
		$query->paginate($perPage)
	)
		->header('Access-Control-Allow-Origin', '*')
		->header('Access-Control-Allow-Methods', 'GET');
});

Route::group(['middleware' => ['web']], function () {
    //
});
