<?php

namespace App\Repositories;

use App\Models\MeetingRoom;
use App\Models\Event;

/*
 * Repository to manage Meeting Room events
 */
class MeetingRoomRepository
{
    /*
     * Create and save a new Meeting Room event to DB
     */
    public function create(array $event_data, array $meeting_room_data)
    {
        \DB::beginTransaction();
        try {

            $event = new Event;
            $event->fill($event_data);

            $meeting_room = new MeetingRoom;
            $meeting_room->fill($meeting_room_data);
            $meeting_room->save();
            $meeting_room->eventInfo()->save($event);

            $event->save();
            

        } catch(Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        \DB::commit();

        
        return $meeting_room;
    }

    /*
     * Update an existing Meeting Room event in the DB
     */
    public function update(MeetingRoom $meeting_room, array $meeting_room_data, array $event_data)
    {
        \DB::beginTransaction();
        try {
            $meeting_room->fill($meeting_room_data);

            $event = $meeting_room->eventInfo;
            $event->fill($event_data);
            
            $event->save();
            $meeting_room->save();

        } catch(Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        \DB::commit();


        return $meeting_room;
    }
}