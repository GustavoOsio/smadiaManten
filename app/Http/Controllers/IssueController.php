<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Issue;
use Illuminate\Http\Request;

class IssueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $this->authorize('view', Issue::class);
        $data = Issue::orderByDesc('created_at')->paginate(10);
        return view('issues.index', ['issues' => $data])->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Issue::class);
        return view('issues.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Issue::class);
        request()->validate([
            'name' => 'required|string|max:40',
            'status' => 'required|alpha|max:8',
        ]);


        Issue::create([
            'name' => $request->name,
            'status' => $request->status,
        ]);


        return redirect()->route('issues.index')
            ->with('success','Tema de seguimiento creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', Issue::class);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Issue $issue)
    {
        $this->authorize('update', Issue::class);
        return view('issues.edit',['issue' => $issue]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Issue $issue)
    {
        $this->authorize('update', Issue::class);
        request()->validate([
            'name' => 'required|string|max:40',
            'status' => 'required|alpha|max:8',
        ]);


        $issue->update([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return redirect()->route('issues.index')
            ->with('success','Tema de seguimiento actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Issue $issue)
    {
        $this->authorize('delete', Issue::class);
        $issue->delete();
        return redirect()->route('issues.index')
            ->with('success','Tema de seguimiento eliminado exitosamente');
    }
}
