<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use illuminate\Support\Facades\Redirect;
use Laracasts\Flash\Flash;
use App\Http\Requests\ArticleRequest;

use App\Category;
use App\Tag;
use App\Article;
use App\Image;


class ArticlesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$articles = Article::Search($request->title)->orderBy('id', 'DESC')->paginate(5);
		$articles->each(function($articles){
			$articles->category;
			$articles->user;
		});

		return view('admin.articles.index')->with('articles', $articles);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{

		$categories = Category::orderBy('name', 'ASC')->lists('name', 'id');
		$tags = Tag::orderBy('name', 'ASC')->lists('name', 'id');
		return view('admin.articles.create')
			->with('categories', $categories)
			->with('tags', $tags);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(ArticleRequest $request)
	{
		//MANIPULACION DE IMAGENES
		if($request->file('image'))
		{
			$file = $request->file('image');
			$name = 'blogfacilito_' . time() . '.'. $file->getClientOriginalExtension();
			$path = public_path(). '/images/articles/';
			$file->move($path, $name);
		}

		$article = new Article($request->all());
		$article->user_id = \Auth::user()->id;
		$article->save();

		$article->tags()->sync($request->tags);

		$image = new Image();
		$image->name = $name;
		$image->article()->associate($article);
		$image->save();

		Flash::success('Se ha creado el articulo '. $article->title . ' con exito !');
		return redirect()->route('admin.articles.index');


	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$article = Article::find($id);
		$article->category;
		$categories = Category::orderBy('name', 'DESC')->lists('name','id');
		$tags = Tag::orderBy('name', 'DESC')->lists('name','id');

		$my_tags = $article->tags->lists('id');
		

		return view('admin.articles.edit')
			->with('categories', $categories)
			->with('article', $article)
			->with('tags', $tags )
			->with('my_tags', $my_tags);

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
		$article = Article::find($id);
		$article->fill($request->all());
		$article->save();

		$article->tags()->sync($request->tags);
		Flash::warning('Se ha editado el articulo '. $article->title . ' de forma exitosa');
		return redirect()->route('admin.articles.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$article = Article::find($id);
		$article->delete();

		Flash::error('Se a eliminado el articulo '. $article->title .' con exito');
		return redirect()->route('admin.articles.index');
	}

}
