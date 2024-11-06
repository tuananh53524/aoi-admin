<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use App\Services\BlogService;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    protected $blogService;

    public function __construct(BlogService $blogService)
    {
        $this->blogService = $blogService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::where('status',1)->where('role', config('app.roles.admin'))->orderBy('name', 'asc')->get();
        $blogs = $this->blogService->getAllBlogs($request->all());
        return view('dashboard.blog.index', compact('blogs', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $authors = User::where('status',1)->where('role', config('app.roles.admin'))->orderBy('name', 'asc')->get();
        return view('dashboard.blog.create', compact('categories', 'authors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $this->blogService->createBlog($data);
        return redirect()->route('blogs.index')->with('success', 'Blog created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $blog = $this->blogService->find($id);
        $categories = Category::all();
        $authors = User::where('status',1)->where('role', config('app.roles.admin'))->orderBy('name', 'asc')->get();
        return view('dashboard.blog.edit', compact('blog', 'categories', 'authors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();
        $this->blogService->update($id, $data);
        return redirect()->route('blogs.index')->with('success', 'Blog updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->blogService->delete($id);
        return redirect()->route('blogs.index')->with('success', 'Blog deleted successfully.');
    }
}
