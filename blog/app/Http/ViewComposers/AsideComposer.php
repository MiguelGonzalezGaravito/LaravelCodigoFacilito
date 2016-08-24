<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Category;
use App\Tag;

class AsideComposer {

	public function compose(View $view)
	{
		$categories = Category::orderBy('name', 'asc')->get();
		$tags = Tag::orderBy('name', 'asc')->get();
		$view->with('categories', $categories)->with('tags', $tags);

	}

}