<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{


    public function blog(Request $request)
    {
        $posts = Post::paginate(10);
        $featured_post = Post::limit(6)->get();
        $page_name = "Blog";
        return view('blog', compact('posts', 'featured_post', 'page_name'));
    }

    public function categories(Request $request, $slug)
    {

        $posts = Category::paginate(10);

        return view('blog', compact('posts'));
    }

    public function postDetail(Request $request, $slug)
    {
        $post = Post::where('slug', $slug)->first();
        $related_post = Post::limit(6)->get();
        $page_name = $post->title;
        return view('single_post', compact('post', 'related_post', 'page_name'));
    }
}
