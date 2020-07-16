<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::paginate(15);
        return view('posts.index', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            $this->validate($request, [
                'title' => 'required',
                'body' => 'required'
            ]);

            $post = Post::firstOrCreate([
                'title' => $request->title,
            ], [
                'body' => $request->body,
            ]);

            //gravando as tags na tabela pivo
            if (isset($request->tags)) {
                $this->saveTags();
            }

       return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);

        $post->update([
            'title' => $request->title,
            'body' => $request->body,
        ]);

        //Apagando as Tags para não gerar duplicidade
        DB::table('tag_post')->where('post_id', '=', $post->id)->delete();

        //gravando as tags na tabela pivo
        if (isset($request->tags)) {
            $this->saveTags();
        }

        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        DB::table('tag_post')->where('post_id', '=', $post->id)->delete();
        
        $post->delete();

        return redirect()->route('posts.index');
    }

    public function saveTag($tags = null)
    {
        foreach ($tags as $tag_id) {
            DB::table('tag_post')->insert([
                'tag_id' => $tag_id,
                'post_id' => $post->id
            ]);
        }
    }
}
