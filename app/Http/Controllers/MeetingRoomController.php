<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MeetingRoomEventService;
use App\Http\Requests\CreateMeetingRoomRequest;
use App\Http\Requests\UpdateMeetingRoomRequest;
use App\Models\MeetingRoom;
use Optimus\Bruno\EloquentBuilderTrait;
use Optimus\Bruno\LaravelController;

class MeetingRoomController extends LaravelController
{
    use EloquentBuilderTrait;

    private $meetingRoomService;

    public function __construct(MeetingRoomEventService $meetingRoomServ) {
        $this->meetingRoomService =  $meetingRoomServ;
    }

    public function index()
    {
        //TODO: mejorar esta funcion. Hay cosas que creo no deberian estar aca.
        $resourceOptions = $this->parseResourceOptions();
        // Start a new query using Eloquent query builder

        $query = MeetingRoom::query();
        $this->applyResourceOptions($query, $resourceOptions);
        $meeting_rooms = $query->get();

        // Parse the data using Optimus\Architect
        $parsedData = $this->parseData($meeting_rooms, $resourceOptions, 'meeting_rooms');

        // Create JSON response of parsed data
        return $this->response($parsedData);
    }

    public function show(MeetingRoom $meetingRoom)
    {
        return $meetingRoom->load('eventInfo');
    }

    public function create(CreateMeetingRoomRequest $request)
    {

        $meetingRoom = $request->get('meeting_room', []);
        
        $event = $request->get('event', []);

        $meeting_room_event = $this->meetingRoomService->validateAndCreate($event, $meetingRoom);

        return response()->json($meeting_room_event->load('eventInfo'), 201);
    }

    public function update(UpdateMeetingRoomRequest $request, MeetingRoom $meetingRoom)
    {

        $meeting_room_array = $request->get('meeting_room', []);

        $event_array = $request->get('event', []);
        
        $meeting_room_event = $this->meetingRoomService->update($meeting_room_array, $event_array, $meetingRoom);
        
        return response()->json($meeting_room_event->load('eventInfo'), 200);

    }

    public function delete(MeetingRoom $meetingRoom)
    {
        $meetingRoom->eventInfo()->delete();
        
        $meetingRoom->delete();

        return response()->json(null, 204);
    }
}