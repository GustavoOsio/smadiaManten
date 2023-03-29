<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ReservationDate;
use App\Models\Schedule;
use App\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LoteProductExport;

class ReservationDateController extends Controller
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
        $this->authorize('view', ReservationDate::class);
        $data = ReservationDate::orderByDesc('date_start')->get();
        return view('reservation-date.index', [
            'data' => $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', ReservationDate::class);
        $user = User::where('status', 'activo')->orderBy('name')->get();
        return view('reservation-date.create', [ 'user' => $user]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', ReservationDate::class);
        request()->validate([
            'user_id' => 'required|numeric',
            'responsable_id' => 'required|numeric',
            'option' => 'required|string',
            'date_start' => 'required|string',
            'motiv' => 'required|string|max:5000',
        ]);
        $User = User::find($request->responsable_id);
        if($request->option == 'dias'){
            $date_start = $request->date_start;
            $date_end = $request->date_end;
            $countSchedules = Schedule::where(function ($query) use ($date_start,$date_end ) {
                $query->whereBetween('date', [$date_start, $date_end])
                    ->orWhere('date', $date_start);
            })->where('personal_id', $request->responsable_id)
                ->whereIn('status', ['programada', 'confirmada','vencida'])
                ->count();
            if($countSchedules > 0){
                return redirect()->route('reservation-date.create')
                    ->with('error','Ya hay citas agendadas, en este rango de dias '.$date_start.' al '.$date_end.
                        ' para '.$User->name.' '.$User->lastname);
            }
        }else if($request->option == 'horas'){
            $date= $request->date_start;
            $start_time = date("H:i",  strtotime($request->hour_start));
            $start_time_s = date("H:i", strtotime('+1 minute', strtotime($request->hour_start)));
            $end_time_s = date("H:i", strtotime('-1 minute', strtotime($request->hour_end)));
            $countSchedules = Schedule::where(function ($query) use ($start_time,$start_time_s, $end_time_s) {
                $query->whereBetween('start_time', [$start_time_s, $end_time_s])
                    ->orWhereBetween('end_time', [$start_time_s, $end_time_s])
                    ->orWhere('start_time', $start_time);
            })->where('personal_id', $request->responsable_id)
                ->where('date', $date)
                ->whereIn('status', ['programada', 'confirmada','vencida'])
                ->count();
            if($countSchedules > 0){
                $start_time = date("h:i a", strtotime($request->hour_start));
                $end_time = date("h:i a", strtotime($request->hour_end));
                return redirect()->route('reservation-date.create')
                    ->with('error','Ya hay citas agendadas, en este rango de horas '.$start_time.' a '. $end_time .' en la fecha '.$date.
                        ' para '.$User->name.' '.$User->lastname);
            }
        }
        /*
        //dd('entro');
        dd($request->date_start);
        return false;
        */
        ReservationDate::create($request->all());
        return redirect()->route('reservation-date.index')
            ->with('success','Reserva de cita creada exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', LoteProducts::class);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ReservationDate $ReservationDate)
    {
        $this->authorize('update', ReservationDate::class);
        $id = explode("/", $_SERVER["REQUEST_URI"]);
        $ReservationDate = ReservationDate::find($id[2]);
        $user = User::where('status', 'activo')->orderBy('name')->get();
        return view('reservation-date.edit', [ 'value' => $ReservationDate,'user'=>$user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReservationDate $ReservationDate)
    {
        $this->authorize('update', ReservationDate::class);
        request()->validate([
            'user_id' => 'required|numeric',
            'responsable_id' => 'required|numeric',
            'option' => 'required|string',
            'date_start' => 'required|string',
            'motiv' => 'required|string|max:5000',
        ]);

        $id = explode("/", $_SERVER["REQUEST_URI"]);

        $User = User::find($request->responsable_id);
        if($request->option == 'dias'){
            $date_start = $request->date_start;
            $date_end = $request->date_end;
            $countSchedules = Schedule::where(function ($query) use ($date_start,$date_end ) {
                $query->whereBetween('date', [$date_start, $date_end])
                    ->orWhere('date', $date_start);
            })->where('personal_id', $request->responsable_id)
                ->whereIn('status', ['programada', 'confirmada','vencida'])
                ->count();
            if($countSchedules > 0){
                return redirect()->route('reservation-date.edit',$id[2])
                    ->with('error','Ya hay citas agendadas, en este rango de dias '.$date_start.' al '.$date_end.
                        ' para '.$User->name.' '.$User->lastname);
            }
        }else if($request->option == 'horas'){
            $date= $request->date_start;
            $start_time = date("H:i",  strtotime($request->hour_start));
            $start_time_s = date("H:i", strtotime('+1 minute', strtotime($request->hour_start)));
            $end_time_s = date("H:i", strtotime('-1 minute', strtotime($request->hour_end)));
            $countSchedules = Schedule::where(function ($query) use ($start_time,$start_time_s, $end_time_s) {
                $query->whereBetween('start_time', [$start_time_s, $end_time_s])
                    ->orWhereBetween('end_time', [$start_time_s, $end_time_s])
                    ->orWhere('start_time', $start_time);
            })->where('personal_id', $request->responsable_id)
                ->where('date', $date)
                ->whereIn('status', ['programada', 'confirmada','vencida'])
                ->count();
            if($countSchedules > 0){
                $start_time = date("h:i a", strtotime($request->hour_start));
                $end_time = date("h:i a", strtotime($request->hour_end));
                return redirect()->route('reservation-date.edit',$id[2])
                    ->with('error','Ya hay citas agendadas, en este rango de horas '.$start_time.' a '. $end_time .' en la fecha '.$date.
                        ' para '.$User->name.' '.$User->lastname);
            }
        }
        $ReservationDate = ReservationDate::find($id[2]);
        $ReservationDate->update($request->all());
        return redirect()->route('reservation-date.index')
            ->with('success','Reserva de cita actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReservationDate $ReservationDate)
    {
        $this->authorize('delete', ReservationDate::class);
        $id = explode("/", $_SERVER["REQUEST_URI"]);
        $ReservationDate = ReservationDate::find($id[2]);
        $ReservationDate->delete();
        return redirect()->route('reservation-date.index')
            ->with('success','Reserva de cita eliminada exitosamente');
    }

    public function delete($id)
    {
        $this->authorize('delete', ReservationDate::class);
        $ReservationDate = ReservationDate::find($id);
        $ReservationDate->delete();
        return redirect()->route('reservation-date.index')
            ->with('success','Reserva de cita eliminada exitosamente');
    }
}
