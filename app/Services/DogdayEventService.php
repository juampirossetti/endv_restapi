<?php

namespace App\Services;

use App\Repositories\DogdayRepository;

use App\Models\Dogday;

use App\Models\Event;

use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

use App\Helpers\DogdayValidationHelper;

class DogdayEventService
{
    private $dogdayRepository;

    private $validator;

    public function __construct(DogdayRepository $dogdayRepo, DogdayValidationHelper $validator){

        $this->dogdayRepository = $dogdayRepo;
        $this->validator = $validator;

    }

    /*
     * Validate and create a Dog Day Event
     */    
    public function validateAndCreate(array $event, array $dogday) {
        //Validations
        $this->validator->validateDate($event['date']);
        $this->validator->validateTime($event['from'], $event['until']);

        $dogday_event = $this->dogdayRepository->create($event, $dogday);

        return $dogday_event;
    }

    /*
     * Validate Dog Day information and save it
     */
    public function update(array $dogday_array, array $event_array, Dogday $dogday){
        
        if(isset($event_array['date'])){
            $this->validator->validateDate($event_array['date'], true, $dogday->id);
        }
        if(isset($event_array['from']) || isset($event_array['until'])){
            $this->validator->validateTimeOnUpdate($event_array, $dogday);
        }
        
        $dogday_event = $this->dogdayRepository->update($dogday, $dogday_array, $event_array);

        return $dogday_event;
    }
}