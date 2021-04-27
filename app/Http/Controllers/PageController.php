<?php

namespace App\Http\Controllers;

use App\Http\Helpers\PageDownloader;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.index', [
            'pages' => Page::all(['id', 'hash', 'url', 'price'])
        ]);
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function anyData()
    {
        $pages = Page::select(['id', 'hash', 'url', 'price']);
        return Datatables::of($pages)->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'url' => 'required|url|max:255',
        ]);

        /*Добавление новой страницы в БД*/
        $page = new Page();
        $page->url = $validated["url"];
        $page->save();

        /*Загружаем содержимое веб-страницы*/
        $pageDownloader = new PageDownloader($page->url);
        $pageDownloader->store($page->id);

        /*Определяем размер содержимого*/
        $webpage_size = $pageDownloader->getSize($page->id);
        $page->price = intval($webpage_size/1000)*0.001;

        /*Генерация хэша*/
        $page->hash = Hash::make($page->id);
        $page->save();

        return redirect("/")->with("success", __("messages.success_load_page"));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($hash)
    {
        $page = Page::where("hash", $hash)->first();
        if(is_null($page)) abort(404);

        $contents = Storage::get('webpages/'.$page->id.'.html');
        return response($contents, 200)
            ->header('Content-Type', 'text/html')
            ->header('Access-Control-Allow-Credentials', 'true')
            ->header('Access-Control-Allow-Origin', $page->url);
    }
}
