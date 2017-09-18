<?php

namespace App\Helpers;

use App\Models\MeetingRoom;

use App\Models\Event;

use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class MeetingRoomValidationHelper {

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
     * Validates that there is no other event of Meeting Room the same day at the same time.
     */
    public function validateTimeOverlapping($date, $from, $until, $onUpdate = false, $meetingRoomId = null){
        
        $events = null;

        if($onUpdate) {
            $events = Event::where('eventable_type','Meeting Room')->where('date', $date)->where('eventable_id','!=',$meetingRoomId)->get();
        } else {
            $events = Event::where('eventable_type','Meeting Room')->where('date', $date)->get();
        }

        $newEventStartTime = strtotime($from);
        $newEventEndTime = strtotime($until);

        foreach($events as $event) {
            $startTime = strtotime($event->from);
            $endTime = strtotime($event->until);

            if($newEventStartTime > $startTime && $newEventStartTime < $endTime){
                throw new UnprocessableEntityHttpException('There is another event on the event.from time.');
            }

            if($newEventEndTime > $startTime && $newEventEndTime < $endTime){
                throw new UnprocessableEntityHttpException('There is another event on the event.until time');
            }

            if($startTime > $newEventStartTime && $startTime < $newEventEndTime){
                throw new UnprocessableEntityHttpException('There is another event in the middle of that time');
            }

        }

    }

    /*
     * Calls time validatons on update
     */
    public function validateTimeOnUpdate(array $event_array, MeetingRoom $meetingRoom) {
        
        $from = isset($event_array['from']) ? $event_array['from'] : $meetingRoom->eventInfo->from;
        
        $until = isset($event_array['until']) ? $event_array['until'] : $meetingRoom->eventInfo->until;

        $date = isset($event_array['date']) ? $event_array['date'] : $meetingRoom->eventInfo->date;

        $this->validateTimeOverlapping($date, $from, $until, true);
    }
}