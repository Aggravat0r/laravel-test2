<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Collection;
use App\Models\Page;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('collections.index', [
            'collections' => Collection::all(['id', 'name'])
        ]);
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function anyData()
    {
        $collections = Collection::select(['id', 'name']);
        return Datatables::of($collections)->make(true);
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
            'name' => 'required|max:255|unique:collections'
        ]);

        /*Добавление новой страницы в БД*/
        $collection = new Collection();
        $collection->name = $validated["name"];
        $collection->save();

        return redirect("/")->with("success_collection", "Коллекция успешно создана!<br>Для ее заполнения перейдите по <a href='".url("collections/".$collection->id."/edit")."'>ссылке</a>");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show($id)
    {
        $collection = Collection::find($id);
        if(is_null($collection)) abort(404);

        $collection_content = array_merge(
            Application::select(['id', 'name', 'price'])->where('collection_id', $id)->get()->toArray(),
            Page::select(['id', 'url', 'price'])->where('collection_id', $id)->get()->toArray()
        );

        return view('collections.show', [
            "collection" => $collection,
            "content" => $collection_content
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        $collection = Collection::find($id);
        if(is_null($collection)) abort(404);

        return view('collections.edit', [
            'applications' => Application::all(['id', 'name']),
            'pages' => Page::all(['id', 'url']),
            "collection" => $collection
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'data' => [
                function ($attribute, $value, $fail) {
                    for($i = 0; $i < count($value); $i++){
                        if (!in_array(substr($value[$i], 0, 4), array("apps", "page"))) {
                            $fail('The '.$attribute.' is invalid.');
                        }
                    }

                }
            ]
        ]);

        foreach ($request->post("data") as $data){
            preg_match("/^(\w+)_(\d+)$/", $data, $matches);
            if(!empty($matches)){
                if($matches[1] == "apps") $page = Application::find($matches[2]);
                elseif($matches[1] == "page") $page = Page::find($matches[2]);

                if(is_null($page)) continue;
                $page->collection_id = $id;
                $page->save();
            }
        }

        return redirect("/collections/".$id)->with("success", __("messages.success_collection_update"));
    }
}
