<?php
namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;  

class PostController extends Controller
{
    public function index()
    {
        // return 'Hi';
        return view('posts.index');
    }

    public function fetch()
    {
        return response()->json(Post::latest()->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $post = Post::create($request->all());
        return response()->json($post);
    }

    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        $post->update($request->all());
        return response()->json($post);
    }

    public function destroy($id)
    {
        Post::find($id)->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }

    public function edit($id)
    {
        return response()->json(Post::find($id));
    }
}

