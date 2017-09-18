<?php

namespace App\Helpers;

use App\Models\Event;

use App\Models\Dogday;

use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class DogdayValidationHelper {
    
    /*
     * Validate that there is no other event of Dog Day the same day.
     */
    public function validateDate($date, $onUpdate = false, $dogdayId = null) {
        $events = null;
        
        if($onUpdate){
            $events = Event::where('date',$date)->where('eventable_id', '!=', $dogdayId)->where('eventable_type','Dog Day')->get();
        } else {
            $events = Event::where('date',$date)->where('eventable_type','Dog Day')->get();
        }
        
        if($events->count()){
            throw new UnprocessableEntityHttpException('The event.date is already in use.');
        }
    }

    /*
     * Validates $from < $until
     */
    public function validateTime($from, $until){
        //Time until must be grater than time from
        $from = strtotime($from);
        $until = strtotime($until);
        if($until < $from) {
            throw new UnprocessableEntityHttpException('The event.until must be later or equal from.');
        }
        //end validation
    }

    /*
     * This function calls validate time with correct values on update
     */
    public function validateTimeOnUpdate(array $event_array, Dogday $dogday) {
        
        $from = isset($event_array['from']) ? $event_array['from'] : $dogday->eventInfo->from;
        
        $until = isset($event_array['until']) ? $event_array['until'] : $dogday->eventInfo->until;

        $this->validateTime($from, $until);
    }

}