<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GreenFridayEventService;
use App\Http\Requests\CreateGreenFridayRequest;
use App\Http\Requests\UpdateGreenFridayRequest;
use App\Models\GreenFriday;
use Optimus\Bruno\EloquentBuilderTrait;
use Optimus\Bruno\LaravelController;

class GreenFridayController extends LaravelController
{
    use EloquentBuilderTrait;

    private $greenFridayService;

    public function __construct(GreenFridayEventService $greenFridayServ) {
        $this->greenFridayService =  $greenFridayServ;
    }

    public function index()
    {
        //TODO: mejorar esta funcion. Hay cosas que creo no deberian estar aca.
        $resourceOptions = $this->parseResourceOptions();
        // Start a new query using Eloquent query builder

        $query = GreenFriday::query();
        $this->applyResourceOptions($query, $resourceOptions);
        $green_fridays = $query->get();

        // Parse the data using Optimus\Architect
        $parsedData = $this->parseData($green_fridays, $resourceOptions, 'green_fridays');

        // Create JSON response of parsed data
        return $this->response($parsedData);
    }

    public function show(GreenFriday $greenFriday)
    {
        return $greenFriday->load('eventInfo');
    }

    public function create(CreateGreenFridayRequest $request)
    {

        $greenFriday = $request->get('green_friday', []);
        
        $event = $request->get('event', []);

        $green_friday_event = $this->greenFridayService->validateAndCreate($event, $greenFriday);

        return response()->json($green_friday_event->load('eventInfo'), 201);
    }

    public function update(UpdateGreenFridayRequest $request, GreenFriday $greenFriday)
    {

        $green_friday_array = $request->get('green_friday', []);

        $event_array = $request->get('event', []);
        
        $green_friday_event = $this->greenFridayService->update($green_friday_array, $event_array, $greenFriday);
        
        return response()->json($green_friday_event->load('eventInfo'), 200);

    }

    public function delete(GreenFriday $greenFriday)
    {
        $greenFriday->eventInfo()->delete();
        
        $greenFriday->delete();

        return response()->json(null, 204);
    }
}