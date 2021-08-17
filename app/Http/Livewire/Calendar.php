<?php

namespace App\Http\Livewire;
use Livewire\Component;
use App\Models\Event;
use Carbon\Carbon;

class Calendar extends Component
{
    public $events = '';
    public $title;
    public $dateStr;

    public function getevent()
    {
        debug('getevent');
        $events = Event::select('id','title','start','end')->get();
        $this->events = json_encode($events);
        //debug($this->events);
        //$this->count = json_encode($events);
        //dd($this->events);
        //return json_encode($this->events);
        debug($this->events);
    }

    public function mount()
    {
        $this->getevent();
    }

    public function resetdata()
    {
        $this->title = '';
        $this->dateStr = '';

    }
    /**
    * Write code on Method
    *
    * @return response()
    */
    public function addevent($event = null)
    {
        debug('addevent');
        $input['title'] = $this->title;
        $input['start'] = Carbon::parse($this->dateStr);
        $input['end'] = Carbon::parse($this->dateStr)->addMinute('15');
        $event = Event::create($input);
        // $eventAdd = [
        //     'title' => 'title',
        //     'start' => $event['start']
        // ];
        $this->getevent();
        //$this->emit('refreshCalendar',json_encode($event));
        //return json_encode($eventAdd);
    }

    /**
    * Write code on Method
    *
    * @return response()
    */
    public function eventDrop($event, $oldEvent)
    {   
        debug("eventDrop");
        $eventdata = Event::find($event['id']);
        $duration = $eventdata->duration;
        $eventdata->start = Carbon::parse($event['start']);
        $eventdata->end = $eventdata->start->copy()->addMinutes($duration);
        $eventdata->save();       
    }

    public function eventResize($event, $oldEvent)
    {
        debug("eventResize");
        $eventdata = Event::find($event['id']);
        $eventdata->start = Carbon::parse($event['start']);
        $eventdata->end = Carbon::parse($event['end']);
        $eventdata->save();
    }

    public function loadmodal($event) {
        $this->title = $event['title'];
        $this->dateStr = $event['start'];
    }
    /**
    * Write code on Method
    *
    * @return response()
    */
    public function render()
    {
        debug("render");
        $this->emit('reloadEvents');
        return view('livewire.calendar');
    }
}
