<?php

namespace App\Http\Controllers;

use App\Appointment;
use Illuminate\Http\Request;
use App\Http\Resources\Appointments as AppointmentsResource;
use App\Services\AppointmentServices;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AppointmentServices $appointmentServices)
    {
        return AppointmentsResource::collection($appointmentServices->getAllUserAppointments());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request, 
        AppointmentServices $appointmentServices
        )
    {
        $createAppointment = $appointmentServices->createAppointment(
                                                    $request->title,
                                                    $request->description,
                                                    $request->date
                                                );
        
        return response()->json([
            'message' => 'Appointment saved successfully',
            'id' => $createAppointment->id,
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function update(
        Request $request, 
        Appointment $appointment,
        AppointmentServices $appointmentServices)
    {
        $appointment->title = $request->title;
        $appointment->description = $request->description;
        $appointment->date = $request->date;
        $appointment->save();
        return $appointment;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appointment $appointment)
    {
        //
    }
}
