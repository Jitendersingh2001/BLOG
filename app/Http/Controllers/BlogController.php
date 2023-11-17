<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\view;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class BlogController extends Controller
{
    // FUNCTION TO GET BLOG CATEGORIES
    public function GetCategory()
    {
        $category = Category::all();
        return response()->json($category);
    }
    // FUNCTION TO CREATE BLOG
    public function CreateBlog(request $request)
    {
        $title = $request->input('postTitle');
        $description = $request->input('PostContent');
        $category = $request->input('Blogcategory');
        $otherCategory = $request->input('OtherCategory');
        if ($request->hasFile('BlogImage')) {
            $file = $request->file('BlogImage');
            $targetFileupload = StoreImage($file);
        }
        if ($category === 'Other') {
            $category = $otherCategory;
            Category::create([
                'category' => $category
            ]);
        }
        Blog::create([
            'title' => $title,
            'description' => $description,
            'category' => $category,
            'BlogImage' => $targetFileupload,
        ]);
        return response()->json(['message' =>  __('message.BLOG_CREATED')], RESPONSE::HTTP_OK);
    }
    // FUNCTION TO GET ALL BLOGS
    public function GetBlogs()
    {
        $blogs = Blog::all();
        return response()->json($blogs);
    }
    // FUNCTION TO DELETE BLOG
    public function  DeleteBlog($id)
    {
        $blog = Blog::find($id);

        if ($blog) {
            // delete image from storage using helper function
            DeleteImage($blog->BlogImage);
            $blog->delete();

            return response()->json(['message' =>  __('message.BLOG_DELETED')]);
        } else {
            return response()->json(['message' => __('NOT_FOUND')], Response::HTTP_NOT_FOUND);
        }
    }
    // FUNCTION TO GET SPECIFIC BLOG
    public function GetBlog($id)
    {
        $blog = Blog::find($id);
        return response()->json(['blogs' => $blog,]);
    }
    // FUNCTION TO UPDATE BLOG
    public function UpdateBlog(request $request)
    {
        // dd($request);
        $blog = Blog::find($request->blogId);

        if ($blog) {
            $category = $request->input('Blogcategory');
            $otherCategory = $request->input('OtherCategory');
            if ($category === 'Other') {
                $category = $otherCategory;
                Category::create([
                    'category' => $category
                ]);
            }
            $data = [
                'title' => $request->postTitle,
                'description' => $request->PostContent,
                'category' => $category,
            ];
            if ($request->hasFile('BlogImage')) {
                // delete image from storage using helper function
                DeleteImage($blog);
                // Store image in storage using helper function
                $targetFileupload = StoreImage($request);
                $data['BlogImage'] = $targetFileupload;
            }
            if ($blog->update($data)) {
                return response()->json(['message' =>  __('message.BLOG_UPDATED')], RESPONSE::HTTP_OK);
            }
        }
    }
    // FUNCTION TO GET BLOGS ON SEARCH
    public function GetSearchedBlogs($keyword)
    {
        $blogs = Blog::where('title', 'like', '%' . $keyword . '%')
            ->orWhere('category', 'like', '%' . $keyword . '%')
            ->get();

        return response()->json($blogs);
    }
    // FUNCTION TO GET BLOGS ACC TO CATEGORY
    public function getCategoryBlogs($keyword)
    {
        $blogs = Blog::where('category', $keyword)->get();
        return response()->json($blogs);
    }
    // FUNCTION ADD VIEW COUNT ON SPECIFIC BLOG
    public function GetSpecificBlog($id)
    {
        View::updateOrCreate(
            ['blog_id' => $id],
            ['view' => DB::raw('view + 1')],
            // DB::raw() is used to insert raw SQL expressions into queries. In this case, \DB::raw('view + 1') is a raw SQL expression that increments the value of the 'view' column by 1. It's a way of directly including SQL code within the query.
            // DB::raw() indicates that you're providing a raw SQL expression.
            // Inside the parentheses, 'view + 1' is the SQL expression. It means "take the current value of the 'view' column and add 1 to it."
        );;
        $blog = Blog::find($id);
        return view('Blog')->with('blog', $blog);
    }
}
