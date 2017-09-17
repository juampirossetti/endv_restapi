<?php

namespace App\Services;

use App\Repositories\EventRepository;

use App\Models\Dogday;

use App\Models\Event;

use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class DogdayEventService
{
    private $eventRepository;

    public function __construct(EventRepository $eventRepo){

        $this->eventRepository = $eventRepo;

    }

    public function validateAndCreate(array $event, array $dogday) {
        
        //complex validation
        $events = Event::where('date',$event['date'])->where('eventable_type','dogday')->get();

        if($events->count()){
            throw new UnprocessableEntityHttpException('There is another event of DogDay that day');
        }
        //end validation
        $dogday_event = $this->eventRepository->createDogdayEvent($event, $dogday);

        return $dogday_event;
    }

    public function updateDogdayEvent(array $dogday_array, array $event_array, Dogday $dogday){
        
        $dogday_event = $this->eventRepository->updateDogdayEvent($dogday, $dogday_array, $event_array);

        return $dogday_event;
    }
}