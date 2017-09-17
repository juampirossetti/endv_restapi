<?php

namespace App\Repositories;

use App\Models\Dogday;
use App\Models\Event;

/*
 * Repository to manage events
 */
class EventRepository
{
    /*
     * Create and save a new Dogday event to DB
     */
    public function createDogdayEvent(array $event_data, array $dogday_data)
    {
        \DB::beginTransaction();
        try {

            $event = new Event;
            $event->fill($event_data);

            $dogday = new Dogday;
            $dogday->fill($dogday_data);
            $dogday->save();
            $dogday->eventInfo()->save($event);

            $event->save();
            

        } catch(Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        \DB::commit();

        
        return $dogday;
    }

    /*
     * Update an existing dogday event in the DB
     */
    public function updateDogdayEvent(Dogday $dogday, array $dogday_data, array $event_data)
    {
        \DB::beginTransaction();
        try {
            $dogday->fill($dogday_data);

            $event = $dogday->eventInfo;
            $event->fill($event_data);
            
            $event->save();
            $dogday->save();

        } catch(Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        \DB::commit();


        return $dogday;
    }
}