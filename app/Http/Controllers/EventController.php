<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Optimus\Bruno\EloquentBuilderTrait;
use Optimus\Bruno\LaravelController;

use App\Models\Event;
class EventController extends LaravelController
{
    use EloquentBuilderTrait;

    public function index()
    {
        //TODO: mejorar esta funcion. Hay cosas que creo no deberian estar aca.
        $resourceOptions = $this->parseResourceOptions();
        // Start a new query using Eloquent query builder

        $query = Event::query();
        $this->applyResourceOptions($query, $resourceOptions);
        $dogdays = $query->get();

        // Parse the data using Optimus\Architect
        $parsedData = $this->parseData($dogdays, $resourceOptions, 'events');

        // Create JSON response of parsed data
        return $this->response($parsedData);
    }

    public function show(Event $event)
    {
        return $event->load('eventable');
    }

    public function delete(Event $event)
    {
        $event->eventable()->delete();
        
        $event->delete();

        return response()->json(null, 204);
    }
}