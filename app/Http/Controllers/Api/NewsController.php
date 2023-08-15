<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Http\Resources\PostResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //get news
        // $news = News::latest()->paginate(5);
        $news = News::latest()->get();

        //return collection of news as a resource
        return new PostResource(true, 'List Data Pengumuman', $news);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'image'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title'     => 'required',
            'content'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/news', $image->hashName());

        //create news
        $news = News::create([
            'image'     => $image->hashName(),
            'title'     => $request->title,
            'content'   => $request->content,
        ]);

        //return response
        return new PostResource(true, 'Data Pengumuman Berhasil Ditambahkan!', $news);
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        return new PostResource(true, 'Data Pengumuman Ditemukan!', $news);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, News $news)
    {
       //define validation rules
       $validator = Validator::make($request->all(), [
        'title'     => 'required',
        'content'   => 'required',
    ]);

    //check if validation fails
    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    //check if image is not empty
    if ($request->hasFile('image')) {

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/news', $image->hashName());

        //delete old image
        Storage::delete('public/news/'.$news->image);

        //update news with new image
        $news->update([
            'image'     => $image->hashName(),
            'title'     => $request->title,
            'content'   => $request->content,
        ]);

    } else {

        //update news without image
        $news->update([
            'title'     => $request->title,
            'content'   => $request->content,
        ]);
    }

    //return response
    return new PostResource(true, 'Data Pengumuman Berhasil Diubah!', $news);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        //delete image
        Storage::delete('public/news/'.$news->image);

        //delete news
        $news->delete();

        //return response
        return new PostResource(true, 'Data Pengumuman Berhasil Dihapus!', null);
    }
}
