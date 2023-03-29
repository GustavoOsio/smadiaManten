<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ElectronicEquipment;
use App\Models\Patient;
use App\Models\Service;
use App\Models\Item;
use App\Models\Contract;
use App\Models\Schedule;
use App\Models\ServiceRole;
use App\Models\ServiceUser;
use App\Models\TextInformedConsents;
use App\User;
use Illuminate\Http\Request;

class TextInformedConsentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $this->authorize('view', TextInformedConsents::class);
        $text = TextInformedConsents::orderBy('service_id')->get();
        return view('text-informed-consents.index', ['text' => $text]);
    }

    public function create()
    {
        $this->authorize('create', Service::class);
        $service = Service::orderBy('name','asc')->get();
        $texting = TextInformedConsents::all();
        return view('text-informed-consents.create', [
            'service' => $service,
            'texting'=>$texting
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create', Service::class);
        request()->validate([
            'service_id' => 'required|integer',
            'text' => 'required|string',
        ]);
        $text = TextInformedConsents::create([
            'service_id' => $request->service_id,
            'text' => $request->text,
        ]);
        return redirect()->route('text-informed-consents.index')
            ->with('success','Texto de Consentimiento creado exitosamente.');
    }

    public function edit(TextInformedConsents $text)
    {
        $this->authorize('update', TextInformedConsents::class);
        $service = Service::orderBy('name','asc')->get();
        $id = explode("/", $_SERVER["REQUEST_URI"]);
        $text = TextInformedConsents::find($id[2]);
        $texting = TextInformedConsents::all();
        return view('text-informed-consents.edit',[
            'service' => $service,
            'text'=>$text,
            'texting'=>$texting
        ]);
    }

    public function update(Request $request, TextInformedConsents $text)
    {
        $this->authorize('update', TextInformedConsents::class);
        request()->validate([
            'service_id' => 'required|integer',
            'text' => 'required|string',
        ]);
        $text = TextInformedConsents::find($request->text_id);
        $text->update([
            'service_id' => $request->service_id,
            'text' => $request->text,
        ]);
        return redirect()->route('text-informed-consents.index')
            ->with('success','Texto de Consentimiento actualizado exitosamente.');
    }

    public function destroy(TextInformedConsents $text)
    {
        $this->authorize('delete', TextInformedConsents::class);
        $text->delete();
        return redirect()->route('text-informed-consents.index')
            ->with('success','Texto de Consentimiento eliminado exitosamente');
    }

    public function delete($id)
    {
        $this->authorize('delete', TextInformedConsents::class);
        $text = TextInformedConsents::find($id);
        $text->delete();
        return redirect()->route('text-informed-consents.index')
            ->with('success','Texto de Consentimiento eliminado exitosamente');
    }
}
