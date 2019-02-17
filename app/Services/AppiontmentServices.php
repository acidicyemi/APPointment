<?php  

namespace App\Services;

use App\Appointment;
use Illuminate\Support\Facades\Auth;

class AppointmentServices  
{
    /**
     * @var App\User
      */
      protected $userId;

      public function __construct()
      {
          $this->userId = Auth::user()->id;
      }

    /**
     * Add a new appointment
     * 
     * @param String $title
     * @param String $description
     * @param String $date
     * @param Bool $status
     * 
     * return App\Appointment
      */
      public function createAppointment(
          $title,
          $description,
          $date,
          $status = false
      )
      {
          $appiontment = new Appointment;
        
          $appiontment->title = $title;
          $appiontment->description = $description;
          $appiontment->date = $date;
          $appiontment->status = $status;
          $appiontment->user_id = Auth::user()->id;
          try {
              $appiontment->save()
;
          } catch (\Exception $e) {
              throw $e;
          }
          return $appiontment;
      }

      public function getAllUserAppointments()
      {
          return Appointment::where('user_id', Auth::user()->id)->get();
      }

    
}
