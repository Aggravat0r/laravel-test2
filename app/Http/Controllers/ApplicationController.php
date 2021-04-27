<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('applications.index', [
            'applications' => Application::all(['id', 'name', 'price'])
        ]);
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function anyData()
    {
        $applications = Application::select(['id', 'name', 'price']);
        return Datatables::of($applications)->make(true);
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
            'name' => 'required|max:255',
            'price' => 'required|numeric|regex:/^\d+(\.\d{1,3})?$/',
        ]);

        /*Добавление новой страницы в БД*/
        $page = new Application();
        $page->name = $validated["name"];
        $page->price = $validated["price"];
        $page->save();

        return redirect("/")->with("success_app", __("messages.success_store_app"));
    }
}
