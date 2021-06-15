<?php

namespace App\Http\Livewire;
use Livewire\Component;
use App\Models\Event;
use Carbon\Carbon;

class Calendar extends Component
{
    public $events = '';

    public function getevent()
    {
        $events = Event::select('id','title','start','end')->get();
        $this->events = json_encode($events);
        return  json_encode($this->events);
    }

    /**
    * Write code on Method
    *
    * @return response()
    */
    public function addevent($event)
    {
        //dd($event);
        $input['title'] = $event['title'];
        $input['start'] = Carbon::parse($event['start']);
        $input['end'] = Carbon::parse($event['start'])->addMinute('15');
        Event::create($input);
        $eventAdd = [
            'title' => 'title',
            'start' => $event['start']
        ];
        return json_encode($eventAdd);
    }

    /**
    * Write code on Method
    *
    * @return response()
    */
    public function eventDrop($event, $oldEvent)
    {
      $eventdata = Event::find($event['id']);
      $eventdata->start = Carbon::parse($event['start']);
      $eventdata->end = clone $eventdata->start;
      $eventdata->end->addMinute('15');
      $eventdata->save();
    }

    public function eventResize($event, $oldEvent)
    {
        $eventdata = Event::find($event['id']);
        $eventdata->start = Carbon::parse($event['start']);
        $eventdata->end = Carbon::parse($event['end']);
        $eventdata->save();
    }

    /**
    * Write code on Method
    *
    * @return response()
    */
    public function render()
    {
        $this->getevent();

        return view('livewire.calendar');
    }
}
