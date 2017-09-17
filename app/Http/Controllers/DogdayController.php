<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\EventRepository;
use App\Http\Requests\CreateDogdayRequest;
use App\Http\Requests\UpdateDogdayRequest;
use App\Models\Dogday;
use Optimus\Bruno\EloquentBuilderTrait;
use Optimus\Bruno\LaravelController;

class DogdayController extends LaravelController
{
    use EloquentBuilderTrait;

    private $eventRepository;

    public function __construct(EventRepository $eventRepo) {
        $this->eventRepository = $eventRepo;
    }

    public function index()
    {
        $resourceOptions = $this->parseResourceOptions();
        // Start a new query using Eloquent query builder
        $query = Dogday::query();
        $this->applyResourceOptions($query, $resourceOptions);
        $dogdays = $query->get();

        // Parse the data using Optimus\Architect
        $parsedData = $this->parseData($dogdays, $resourceOptions, 'dogdays');

        // Create JSON response of parsed data
        return $this->response($parsedData);
    }

    public function show(Dogday $dogday)
    {
        return $dogday->load('eventInfo');
    }

    public function create(CreateDogdayRequest $request)
    {

        $dogday = $request->get('dogday', []);
        
        $event = $request->get('event', []);

        $dogday_event = $this->eventRepository->createDogdayEvent($event, $dogday);

        return response()->json($dogday_event->load('eventInfo'), 201);
    }

    public function update(UpdateDogdayRequest $request, Dogday $dogday)
    {

        $dogday_array = $request->get('dogday', []);

        $event_array = $request->get('event', []);
        
        $dogday_event = $this->eventRepository->updateDogdayEvent($dogday, $dogday_array, $event_array);
        
        return response()->json($dogday_event->load('eventInfo'), 201);

    }

    public function delete(Dogday $dogday)
    {
        $dogday->eventInfo()->delete();
        
        $dogday->delete();

        return response()->json(null, 204);
    }
}
