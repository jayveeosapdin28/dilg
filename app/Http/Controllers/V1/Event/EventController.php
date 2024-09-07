<?php

namespace App\Http\Controllers\V1\Event;

use App\Http\Controllers\Controller;
use App\Http\Requests\Event\StoreEventRequest;
use App\Http\Requests\Event\UpdateEventRequest;
use App\Models\Event\Event;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EventController extends Controller
{


    public function index(Request $request)
    {
        abort_if(!auth()->user()->can('access event'), Response::HTTP_FORBIDDEN, '401 Unauthorized');

              $pages = $request->input('pages', 10);
              $order_by = $request->input('order_by', 'ASC');
              $sort_by = $request->input('sort_by', 'event_name');

              $events = Event::with([])
                  ->where(function ($query) use ($request) {
                      $query->when($request->has('query'), function ($query) use ($request) {
                          $queryString = trim($request['query']);
                          $query->where('event_name', 'LIKE', "%{$queryString}%");
                      });
                  })
                  ->orderBy($sort_by, $order_by)
                  ->paginate($pages)
                  ->withQueryString();


              return inertia('Event/Index', [
                  'events' => $events,
                  'request' => $request->all(),
              ]);

    }


    public function edit($id)
    {
        abort_if(!auth()->user()->can('edit event'), Response::HTTP_FORBIDDEN, '401 Unauthorized');

        $event = Event::find($id);

        return inertia('Event/Form');
    }

    public function show($id)
    {
        abort_if(!auth()->user()->can('view event'), Response::HTTP_FORBIDDEN, '401 Unauthorized');

        $event = Event::with([])->find($id);
        return inertia('Event/Show');
    }

    public function store(StoreEventRequest $request)
    {

         $event_arr = $request->validated();

         $event = Event::create( $event_arr);

         return redirect()->back();
    }


    public function update(UpdateEventRequest $request, $id): \Illuminate\Http\RedirectResponse
    {

        $event_arr = $request->validated();

        $event = Event::find($id);
        $event->update($event_arr);

        return redirect()->back();
    }

    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        abort_if(!auth()->user()->can('delete event'), Response::HTTP_FORBIDDEN, '401 Unauthorized');

        $event = Event::find($id);
        $event->delete();

        return redirect()->back();
    }
}
