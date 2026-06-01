<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(Post $post)
    {
        $posts = $post->with('category')
            ->orderBy('created_at', 'desc')
            ->latest()
            ->paginate(10);

        return view('admin.posts.index', compact('posts'));
    }

    public function show(Post $post)
    {
        $categories = Category::with('posts')->get();

        $posts = Post::where('slug', '!=', $post->slug)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('blog.show', compact('post', 'posts', 'categories'));
    }

    public function search(Request $request)
    {
        $request->validate([
            'keyword' => 'required|string'
        ]);

        $keyword = $request->keyword;

        $categories = Category::all();

        $posts = Post::where('title', 'like', '%'.$keyword.'%')
            ->latest()
            ->paginate(10);

        return view('blog.search', compact('keyword', 'categories', 'posts'));
    }

    public function author($author)
    {
        $categories = Category::all();

        $posts = Post::where('author', $author)
            ->latest()
            ->paginate(10);
        
        return view('blog.author', compact('author', 'categories', 'posts'));
    }

    public function category(Category $category)
    {
        $category_name = $category->name;

        $categories = Category::all();

        $posts = $category->posts;
        
        return view('blog.category', compact('category_name', 'categories', 'posts'));
    }

    public function category_save(Request $request)
    {
        $isExists = Category::where('name', $request->name)->exists();

        if (!$request->name || $isExists) {
            return response()->json([
                'status' => 'failed'
            ]);
        }

        $result = Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        return response()->json([
            'status' => 'success',
            'id' => $result->id
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'thumbnail'  => 'required|file|image|mimes:jpg,jpeg,png,svg,webp|max:4096',
            'title' => 'required',
            'body' => 'required',
            'category_id' => 'required',
            'author' => 'required'
        ]);

        $data = $request->only([
            'title',
            'body',
            'category_id',
            'author'
        ]);

        $isExists = Post::where('slug', Str::slug($request->title))->exists();

        $data['slug'] = $isExists
            ? Str::slug($request->title.'-'.substr(md5(time()), 0, 8))
            : Str::slug($request->title);

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');

            $fileName = time().'_'.Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)).'.'.$file->getClientOriginalExtension();

            $folder = Carbon::now()->format('m-d-Y');

            $path = $file->storeAs('posts/'.$folder, $fileName, 'public');

            $data['thumbnail'] = $path;
        }

        Post::create($data);

        return redirect()
            ->route('admin.article.index')
            ->with('success', 'Artikel berhasil disimpan!');
    }

    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    public function update(Post $post, Request $request)
    {
        $request->validate([
            'thumbnail' => 'nullable|file|image|mimes:jpg,jpeg,png,svg,webp|max:4096',
            'title' => 'required',
            'body' => 'required',
            'category_id' => 'required',
            'author' => 'required'
        ]);

        $data = $request->only([
            'title',
            'body',
            'category_id',
            'author'
        ]);

        $data['slug'] = Str::slug($request->title);

        if ($request->hasFile('thumbnail')) {
            if ($post->thumbnail && Storage::disk('public')->exists($post->thumbnail)) {
                Storage::disk('public')->delete($post->thumbnail);
            }

            $file = $request->file('thumbnail');

            $fileName = time().'_'.Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)).'.'.$file->getClientOriginalExtension();

            $folder = Carbon::now()->format('m-d-Y');

            $path = $file->storeAs('posts/'.$folder, $fileName, 'public');

            $data['thumbnail'] = $path;
        } else {
            $data['thumbnail'] = $post->thumbnail;
        }

        $post->update($data);

        return redirect()
            ->route('admin.article.index')
            ->with('success', 'Artikel berhasil diupdate!');
    }

    public function destroy(Post $post)
    {
        if ($post->thumbnail && Storage::disk('public')->exists($post->thumbnail)) {
            Storage::disk('public')->delete($post->thumbnail);
        }

        $post->delete();

        return redirect()
            ->route('admin.article.index')
            ->with('success', 'Artikel berhasil dihapus!');
    }
}