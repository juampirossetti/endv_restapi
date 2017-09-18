<?php

namespace App\Repositories;

use App\Models\GreenFriday;
use App\Models\Event;

/*
 * Repository to manage Green Friday events
 */
class GreenFridayRepository
{
    /*
     * Create and save a new Green Friday event to DB
     */
    public function create(array $event_data, array $green_friday_data)
    {
        \DB::beginTransaction();
        try {

            $event = new Event;
            $event->fill($event_data);

            $green_friday = new GreenFriday;
            $green_friday->fill($green_friday_data);
            $green_friday->save();
            $green_friday->eventInfo()->save($event);

            $event->save();
            

        } catch(Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        \DB::commit();

        
        return $green_friday;
    }

    /*
     * Update an existing Green Friday event in the DB
     */
    public function update(GreenFriday $green_friday, array $green_friday_data, array $event_data)
    {
        \DB::beginTransaction();
        try {
            $green_friday->fill($green_friday_data);

            $event = $green_friday->eventInfo;
            $event->fill($event_data);
            
            $event->save();
            $green_friday->save();

        } catch(Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        \DB::commit();


        return $green_friday;
    }
}