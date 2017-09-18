<?php

namespace App\Services;

use App\Repositories\DogdayRepository;

use App\Models\Dogday;

use App\Models\Event;

use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class DogdayEventService
{
    private $dogdayRepository;

    public function __construct(DogdayRepository $dogdayRepo){

        $this->dogdayRepository = $dogdayRepo;

    }
    //TODO: Hay codigo repetido con GreenFridayEventService y este no es el lugar de estas funciones. Hay que reestructurar.
    /*
     * Validate that there is no other event of Dog Day the same day.
     * Use the same function for Create and update
     */
    public function validateDate($date, $onUpdate = false, $dogdayId = null) {
        if($onUpdate){
            //dd($dogdayId);
            $events = Event::where('date',$date)->where('eventable_id', '!=', $dogdayId)->where('eventable_type','Dog Day')->get();
        } else {
            $events = Event::where('date',$date)->where('eventable_type','Dog Day')->get();
        }
        //dd($events);
        if($events->count()){
            throw new UnprocessableEntityHttpException('The event.date is already in use.');
        }
    }

    public function validateTime($from, $until){
        //Time until must be grater than time from
        $from = strtotime($from);
        $until = strtotime($until);
        if($until < $from) {
            throw new UnprocessableEntityHttpException('The event.until must be later or equal from.');
        }
        //end validation
    }
    public function validateAndCreate(array $event, array $dogday) {
        
        //Validations
        $this->validateDate($event['date']);
        $this->validateTime($event['from'], $event['until']);

        $dogday_event = $this->dogdayRepository->create($event, $dogday);

        return $dogday_event;
    }

    public function validateTimeOnUpdate(array $event_array, Dogday $dogday) {
        
        $from = isset($event_array['from']) ? $event_array['from'] : $dogday->eventInfo->from;
        
        $until = isset($event_array['until']) ? $event_array['until'] : $dogday->eventInfo->until;

        $this->validateTime($from, $until);
    }

    public function update(array $dogday_array, array $event_array, Dogday $dogday){
        
        if(isset($event_array['date'])){
            $this->validateDate($event_array['date'], true, $dogday->id);
        }
        if(isset($event_array['from']) || isset($event_array['until'])){
            $this->validateTimeOnUpdate($event_array, $dogday);
        }
        
        $dogday_event = $this->dogdayRepository->update($dogday, $dogday_array, $event_array);

        return $dogday_event;
    }
}