<?php

namespace App\Services;

use App\Repositories\MeetingRoomRepository;

use App\Models\MeetingRoom;

use App\Models\Event;

use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

use App\Helpers\MeetingRoomValidationHelper;

class MeetingRoomEventService
{
    private $meetingRoomRepository;

    private $validator;

    public function __construct(MeetingRoomRepository $meetingRoomRepo, MeetingRoomValidationHelper $validator){

        $this->meetingRoomRepository = $meetingRoomRepo;

        $this->validator = $validator;
    }

    /*
     * Validate and create a Meeting Room Event
     */
    public function validateAndCreate(array $event, array $meeting_room) {

        //Validations
        $this->validator->validateTime($event['from'], $event['until']);
        $this->validator->validateTimeOverlapping($event['date'], $event['from'], $event['until']);
        //end validation

        $meeting_room_event = $this->meetingRoomRepository->create($event, $meeting_room);

        return $meeting_room_event;
    }

    /*
     * Validate Meeting Room information and save it
     */
    public function update(array $meeting_room_array, array $event_array, MeetingRoom $meetingRoom){
        
        if(isset($event_array['date']) || isset($event_array['from']) || isset($event_array['until'])){
            $this->validator->validateTime($event_array['from'], $event_array['until']);
            $this->validator->validateTimeOnUpdate($event_array, $meetingRoom);
        }

        $meeting_room_event = $this->meetingRoomRepository->update($meetingRoom, $meeting_room_array, $event_array);

        return $meeting_room_event;
    }
}