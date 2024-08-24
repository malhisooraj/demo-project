<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PostController extends Controller
{

    public function test()
    {
        $array = array(
            0 => array('id' => 1, 'date' => '2018-09-15'),
            1 => array('id' => 1, 'date' => '2018-06-12'),
            2 => array('id' => 1, 'date' => '2017-01-01'),
            3 => array('id' => 1, 'date' => '2019-09-10'),
            4 => array('id' => 1, 'date' => '2018-10-15')
        );

// Extract the 'date' column to a separate array
        $dates = array_column($array, 'date');

// Sort the original array based on the 'date' column
        array_multisort($dates, SORT_ASC, $array);

// Output the sorted array
        print_r($array);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //$posts = Post::all(); // this will add n+1 problem, if you need to load the associated categories

        //$posts = Post::latest()->with('category','author')->get(); // use this to include the categories in the posts

        // log queries in log file
        /*DB::listen(function ($query) {
            logger($query->sql);
        });*/
        //$posts = Post::latest()->get(); // use this to include the categories in the posts
        $query = isset($request['search']) ? $request['search'] : '';
        $search = array_merge(
            $request->only('search'),
            $request->only('category'),
            $request->only('author'),
            ['status' => 'published']
        );
       // dd($request['category'] ?? Category::where('slug', $request['category'])->first());

        return view('posts.index', [
            //'posts' => $this->getPosts($query),
            //'posts' => Post::latest()->filter($search)->get(), // without pagination
            'posts' => Post::latest()->filter(
                $search)
                ->paginate(3)->withQueryString(), // get with pagination
            //'categories' => Category::all(), as we moved this to the CategoryDropdown component itself
            //'currentCategory' =>  Category::where('slug', $request['category'])->first()
        ]);
    }

    public function getPosts($query)
    {
       // Method 1
        /*$posts = Post::latest();
        if ($query) {
            $posts
                ->where('title', 'like', '%' . $query . '%')
                ->orWhere('body', 'like', '%' . $query . '%');
        }
        return $posts->get();*/

        // Method 2
        return Post::latest()->filter()->get();
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        /*$post = Post::findOrFail($id);
        if (! $post) {
            abort(404);
        }*/
        return view('posts.show', ['post' => $post]);
    }
}
