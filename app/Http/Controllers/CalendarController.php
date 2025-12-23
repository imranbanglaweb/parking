<?php

namespace App\Http\Controllers;

use App\Events\Voyager\BreadDataAdded;
use App\Facades\Voyager;
use App\Http\Controllers\Voyager\VoyagerBaseController;
use App\Models\Calendar;
use App\Models\DataType;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;


class CalendarController extends VoyagerBaseController
{

    protected $additionalColumnsInList = [];

    public function index(Request $request)
    {

        /** @var User $user */
        /** @var Builder $query */
        $user = Auth::user();
        $this->authorize('browse', app(Calendar::class));

        $query = Calendar::acl();
        $data = $query->get();

        $events = [];
        foreach ($data as $key => $value) {
            $endDate = clone $value->end_date;
            $endDate->addDay(1);
            $events[] = array(
                'backgroundColor' => $value->bg_color,
                'textColor' => $value->text_color,
                'overlap' => false,
                'allDay' => true,
                'id' => $value->id,
                'title' => $value->title,
                'start' => $value->start_date->startOfDay()->format('Y-m-d'),
                'end' => $endDate->format('Y-m-d'),
                'description' => $value->details ?? "",
                'type' => $value->event_type ? $value->event_type : '',
                'edit_permission' => $user->can('edit', $value),
                'delete_permission' => $user->can('delete', $value),
            );
        }

        $type = Calendar::getEventTypes();
        return parent::index($request)
            ->with('type', $type)
            ->with('events', $events);
    }

    public function store(Request $request)
    {
        $slug = $this->getSlug($request);

        /** @var DataType $dataType */
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        $this->authorize('add', app($dataType->model_name));

        if ($request->event_type == Calendar::HOLIDAY) {

            $eventCount = Calendar::where('start_date', '=', $request->start_date)->where('event_type', '=', Calendar::HOLIDAY);

            if ($eventCount->count()) {
                return back()->with(['message' => __('Sorry! Holiday has already been added to this Day'), 'alert-type' => 'error']);
            }
        }

        $val = $this->validateBread($request->all(), $dataType->addRows, $dataType->name)->validate();
        $data = $this->insertUpdateData($request, $slug, $dataType->addRows, new $dataType->model_name());

        event(new BreadDataAdded($dataType, $data));

        return redirect()
            ->route("voyager.{$dataType->slug}.index")
            ->with([
                'message' => __('voyager::generic.successfully_added_new') . " {$dataType->getTranslatedAttribute('display_name_singular')}",
                'alert-type' => 'success',
            ]);
    }

    public function eventUpdate(Request $request)
    {

        if ($request->more == 1) {

            $this->authorize('add', app(Calendar::class));

            if ($request->event_type == Calendar::HOLIDAY) {

                $eventCount = Calendar::where('start_date', '=', $request->start_date)->where('event_type', '=', Calendar::HOLIDAY);

                if ($eventCount->count()) {
                    return back()->with(['message' => __('Sorry! Holiday has already been added to this Day'), 'alert-type' => 'error']);
                }
            }

            $this->validate($request, [
                'title' => 'required|min:2',
                'start_date' => 'required|date',
                'event_type' => ['required', Rule::in(Calendar::getEventTypes())],
            ]);

            $cal = new Calendar();

            $cal->title = $request->title;
            if ($request->event_details) {
                $cal->details = $request->event_details;
            }

            $cal->start_date = $request->start_date;
            $cal->end_date = $request->start_date;
            $cal->event_type = $request->event_type;
            $cal->save();
            return redirect()->back()->with(['message' => __('Event Successfully Added'), 'alert-type' => 'success']);
        } else {

            $this->validate($request, [
                'id' => 'required|integer',
                'title' => 'required|min:2',
                'start_date' => 'required|date',
                'event_type' => ['required', Rule::in(Calendar::getEventTypes())],
            ]);

            $cal = Calendar::find($request->id);
            $this->authorize('edit', $cal);

            $cal->title = $request->title;
            if ($request->details) {
                $cal->details = $request->details;
            }

            $cal->start_date = $request->start_date;
            $cal->end_date = $request->start_date;
            $cal->event_type = $request->event_type;

            $cal->update();
            return redirect()->back()->with(['message' => __('Event Successfully Updated'), 'alert-type' => 'success']);
        }
    }

    public function eventAdd(Request $request)
    {
        if ($request->event_type == Calendar::HOLIDAY) {

            $eventCount = Calendar::where('start_date', '=', $request->start_date)->where('event_type', '=', Calendar::HOLIDAY);

            if ($eventCount->count()) {
                return back()->with(['message' => __('Sorry! Holiday has already been added to this Day'), 'alert-type' => 'error']);
            }
        }

        $this->validate($request, [
            'title' => 'required|min:2',
            'start_date' => 'required|date',
            'event_type' => ['required', Rule::in(Calendar::getEventTypes())],
        ]);

        $this->authorize('add', app(Calendar::class));

        $cal = new Calendar();

        $cal->title = $request->title;
        $cal->details = $request->details;
        $cal->start_date = $request->start_date;
        $cal->end_date = $request->start_date;
        $cal->event_type = $request->event_type;
        $cal->save();
        return redirect()->back()->with(['message' => __('Event Successfully Added'), 'alert-type' => 'success']);
    }

    public function eventDelete(Request $request)
    {
        $cal = Calendar::find($request->id);
        $this->authorize('delete', $cal);

        $cal->delete();
        return redirect()->back()->with(['message' => __('Event Successfully Deleted'), 'alert-type' => 'success']);
    }
}
