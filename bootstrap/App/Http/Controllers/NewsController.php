<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;

class NewsController extends Controller
{
    public function index()
    {
        // Lấy tin tức mới nhất, phân trang 10 bản ghi mỗi trang
        $news = News::latest()->paginate(2);

        // Trả về view hiển thị
        return view('news.index', compact('news'));
    }
    public function show(string $id)
    {
        $news = News::findOrFail($id);
        $comments = $news->comments()->latest()->paginate(5);
        return view('news.show', compact('news'));
    }

    // Các method khác (create, store, edit, update, destroy) giữ nguyên
}
