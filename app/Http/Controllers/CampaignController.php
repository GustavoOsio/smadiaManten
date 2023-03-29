<?php

namespace App\Http\Controllers;


use App\Models\Campaign;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CampaignController extends Controller
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
        $this->authorize('view', Campaign::class);
        $campaign = Campaign::orderByDesc('created_at')
        ->get();
        return view('campaign.index', ['campaign' => $campaign]);
    }

    public function create()
    {
        $this->authorize('create', Campaign::class);
        return view('campaign.create', [
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create', Campaign::class);
        request()->validate([
            'name' => 'required|string|max:255',
            'text' => 'required',
            'status' => 'required|alpha|max:8',
        ]);
        Campaign::create([
            'name' => $request->name,
            'text' => $request->text,
            'status' => $request->status,
        ]);
        return redirect()->route('campaign.index')
            ->with('success','Campaña o promocion creada exitosamente.');
    }

    public function edit(Campaign $campaign)
    {
        $this->authorize('update', Campaign::class);
        return view('campaign.edit',['campaign' => $campaign]);
    }

    public function update(Request $request, Campaign $campaign)
    {
        $this->authorize('update', Campaign::class);
        request()->validate([
            'name' => 'required|string|max:255',
            'text' => 'required',
            'status' => 'required|alpha|max:8',
        ]);
        $campaign->update([
            'name' => $request->name,
            'text' => $request->text,
            'status' => $request->status,
        ]);
        return redirect()->route('campaign.index')
            ->with('success','Campaña o promocion actualizada exitosamente.');
    }

    public function delete($id)
    {
        $this->authorize('delete', Campaign::class);
        $campaign = Campaign::find($id);
        $campaign->delete();
        return redirect()->route('campaign.index')
            ->with('success','Campaña o promocion eliminada exitosamente');
    }

}
