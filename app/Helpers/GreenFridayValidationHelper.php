<?php

namespace App\Helpers;

use App\Models\GreenFriday;

use App\Models\Event;

use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

use Carbon\Carbon;

class GreenFridayValidationHelper {

    /*
     * Validate that there is no other event of Green Friday the same day.
     */
    public function validateDate($date, $onUpdate = false, $greenFridayId = null) {
        $events = null;
        if($onUpdate){
            $events = Event::where('date',$date)->where('eventable_id', '!=', $greenFridayId)->where('eventable_type','Green Friday')->get();
        } else {
            $events = Event::where('date',$date)->where('eventable_type','Green Friday')->get();
        }
        if($events->count()){
            throw new UnprocessableEntityHttpException('The event.date is already in use.');
        }
    }

    /*
     * Validates $from < $until
     */
    public function validateTime($from, $until){

        $from = strtotime($from);
        
        $until = strtotime($until);
        
        if($until < $from) {
            throw new UnprocessableEntityHttpException('The event.until must be later or equal from.');
        }
    }

    /*
     * This function calls validate time with correct values on update
     */
    public function validateTimeOnUpdate(array $event_array, GreenFriday $greenFriday) {
        
        $from = isset($event_array['from']) ? $event_array['from'] : $greenFriday->eventInfo->from;
        
        $until = isset($event_array['until']) ? $event_array['until'] : $greenFriday->eventInfo->until;

        $this->validateTime($from, $until);
    }

    /*
     * Validates that $date is the last friday of the month
     */
    public function validateLastFriday($date) {
        $c_date = Carbon::createFromFormat('Y-m-d', $date, 'America/Argentina/Buenos_Aires');
        
        $end_of_month = $c_date->endOfMonth();

        if(Carbon::createFromFormat('Y-m-d', $date)->dayOfWeek != Carbon::FRIDAY) {
            throw new UnprocessableEntityHttpException('The event.date must be friday date.');
        }
        
        if(Carbon::createFromFormat('Y-m-d', $date)->diffInDays($end_of_month) > 7) {
            throw new UnprocessableEntityHttpException('The event.date must be last friday of month.');
        }
    }

}
