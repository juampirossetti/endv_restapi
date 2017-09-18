<?php

namespace App\Services;

use App\Repositories\GreenFridayRepository;

use App\Models\GreenFriday;

use App\Models\Event;

use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

use App\Helpers\GreenFridayValidationHelper;

class GreenFridayEventService
{
    private $greenFridayRepository;

    private $validator;

    public function __construct(GreenFridayRepository $greenFridayRepo, GreenFridayValidationHelper $validator){

        $this->greenFridayRepository = $greenFridayRepo;
        $this->validator = $validator;

    }

    /*
     * Validate and create a Green Friday Event
     */
    public function validateAndCreate(array $event, array $green_friday) {

        //Validations
        $this->validator->validateLastFriday($event['date']);
        $this->validator->validateDate($event['date']);
        $this->validator->validateTime($event['from'], $event['until']);
        
        //end validation
        $green_friday_event = $this->greenFridayRepository->create($event, $green_friday);

        return $green_friday_event;
    }

    /*
     * Validate Green Friday information and save it
     */
    public function update(array $green_friday_array, array $event_array, GreenFriday $greenFriday){
        
        if(isset($event_array['date'])){
            $this->validator->validateLastFriday($event_array['date']);
            $this->validator->validateDate($event_array['date'], true, $greenFriday->id);
        }
        
        if(isset($event_array['from']) || isset($event_array['until'])){
            $this->validator->validateTimeOnUpdate($event_array, $greenFriday);
        }

        $green_friday_event = $this->greenFridayRepository->update($greenFriday, $green_friday_array, $event_array);

        return $green_friday_event;
    }
}