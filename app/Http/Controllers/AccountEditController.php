<?php

namespace App\Http\Controllers;


use App\Models\Blood;
use App\Models\Filter;
use App\Models\Gender;
use App\Models\Role;
use App\Models\State;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AccountEditController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('update', User::class);
        $user = User::find(Auth::id());
        return view('account', [
            'roles' => Role::where('status', 'activo')->get(),
            'user' => $user,
            'states' => State::orderBy('name')->get(),
            'genders' => Gender::where('status', 'activo')->get(),
            'arl' => Filter::where(['status' => 'activo', 'type' => 'arl'])->orderBy('name')->get(),
            'pension' => Filter::where(['status' => 'activo', 'type' => 'pension'])->orderBy('name')->get(),
            'bloods' => Blood::all(),
            'cities' => State::find($user->state_id)->cities
        ]);
    }

    public function update(Request $request)
    {
        $user = User::find(Auth::id());
        $this->authorize('update', User::class);
        request()->validate([
            'name' => 'required|string|max:50',
            'lastname' => 'required|string|max:80',
            'username' => 'required|string|max:30',
            'state_id' => 'required|integer',
            'city_id' => 'required|integer',
            'address' => 'required|string|max:80',
            'phone' => 'required|numeric',
            'cellphone' => 'required|numeric',
            'email' => 'required|email|',
            'pension_id' => 'required|integer',
            'f_name' => 'required|string|max:50',
            'f_lastname' => 'required|string|max:80',
            'f_address' => 'required|string|max:80',
            'f_phone' => 'required|numeric',
            'f_cellphone' => 'required|numeric',
            'f_relationship' => 'required|string|min:3|max:20',
            'schedule' => 'required',
        ]);

        if (!empty($request->password)) {
            request()->validate([
                'password' => 'required|string|min:6|confirmed',
            ]);
            $user->update($request->except('photo'));
        } else {
            $user->update($request->except(['password', 'photo']));
        }

        if ($request->file('photo')) {
            $photo = time() . '-' . str_slug($user->name . " " . $user->lastname) . '.' .  $request->file('photo')->extension();
            $path = 'profile/' . $photo;
            $user->update([
                'photo' => $path
            ]);
            $request->file('photo')->move('profile', $photo);
        }

        return redirect()->route('account.index')
            ->with('success','Datos actualizados exitosamente.');
    }
}
