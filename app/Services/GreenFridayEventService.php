<?php

namespace App\Services;

use App\Repositories\GreenFridayRepository;

use App\Models\GreenFriday;

use App\Models\Event;

use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

use Carbon\Carbon;

class GreenFridayEventService
{
    private $greenFridayRepository;

    public function __construct(GreenFridayRepository $greenFridayRepo){

        $this->greenFridayRepository = $greenFridayRepo;

    }

    //TODO: Hay codigo repetido con DogdayEventService y este no es el lugar de estas funciones. Hay que reestructurar.
    /*
     * Validate that there is no other event of Dog Day the same day.
     * Use the same function for Create and update
     */
    public function validateDate($date, $onUpdate = false, $greenFridayId = null) {
        if($onUpdate){
            $events = Event::where('date',$date)->where('eventable_id', '!=', $greenFridayId)->where('eventable_type','Green Friday')->get();
        } else {
            $events = Event::where('date',$date)->where('eventable_type','Green Friday')->get();
        }
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

    public function validateTimeOnUpdate(array $event_array, GreenFriday $greenFriday) {
        
        $from = isset($event_array['from']) ? $event_array['from'] : $greenFriday->eventInfo->from;
        
        $until = isset($event_array['until']) ? $event_array['until'] : $greenFriday->eventInfo->until;

        $this->validateTime($from, $until);
    }

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
    public function validateAndCreate(array $event, array $green_friday) {

        //Validations
        $this->validateLastFriday($event['date']);
        $this->validateDate($event['date']);
        $this->validateTime($event['from'], $event['until']);
        
        //end validation
        $green_friday_event = $this->greenFridayRepository->create($event, $green_friday);

        return $green_friday_event;
    }

    public function update(array $green_friday_array, array $event_array, GreenFriday $greenFriday){
        
        if(isset($event_array['date'])){
            $this->validateLastFriday($event_array['date']);
            $this->validateDate($event_array['date'], true, $greenFriday->id);
        }
        
        if(isset($event_array['from']) || isset($event_array['until'])){
            $this->validateTimeOnUpdate($event_array, $greenFriday);
        }

        $green_friday_event = $this->greenFridayRepository->update($greenFriday, $green_friday_array, $event_array);

        return $green_friday_event;
    }
}