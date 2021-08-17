<div>
<style>
    #calendar-container{
        width: 100%;
    }
    #calendar{
        padding: 10px;
        margin: 10px;
        width: 1340px;
        height: 610px;
        border:2px solid black;
    }
</style>

<div>
  <div id='calendar-container' wire:ignore>
    <div id='calendar'></div>
  </div>
</div>

<!-- Modal -->
<div wire:ignore.self class="modal" id="exampleModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="modalBody" class="modal-body">
                <div class="md-form mb-5">
                    <input type="text" id="title" wire:model="title" class="form-control focus">
                    <label data-error="wrong" data-success="right" for="form3">Your name</label>
                </div>

                <div class="md-form mb-4">
                    <i class="fas fa-envelope prefix grey-text"></i>
                    <input wire:model="dateStr" id="dateStr" class="form-control ">
                    <label data-error="wrong" data-success="right" for="form2">Your email</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" wire:click="addevent()">Save changes</button>
            </div>
        </div>
    </div>
</div>

<button class="btn btn-primary" onclick="fun()"> Cargar </button>

<pre wire:model='events'>{{ $events }}</pre>

@push('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.9.0/main.min.js'></script>

<script>
    function fun() {
        $("#exampleModal").calendar.refetchEvents();
        //document.calendar.refetchEvents();
    }
    document.addEventListener('livewire:load', function () {
        var Calendar = FullCalendar.Calendar;
        var Draggable = FullCalendar.Draggable;
        var calendarEl = document.getElementById('calendar');
        var checkbox = document.getElementById('drop-remove');

        var calendar = new Calendar(calendarEl, {
            initialView: 'timeGridWeek',
            allDaySlot: false,
            firstDay: 1,
            slotMinTime: "08:00:00",
            slotDuration: "00:15:00",
            slotMaxTime: "17:30:00",
            //timeFormat: 'HH:mm',
            locale: 'es',
            editable: true,
            selectable: true,
            displayEventTime: false,
            droppable: true, // this allows things to be dropped onto the calendar
            lazyFetching: false,
            slotLabelFormat: {
                hour: 'numeric',
                minute: '2-digit',
                omitZeroMinute: false,
                hour12: false,
                meridiem: 'short'
            },
            //events: JSON.parse(@this.events),
            eventSources:[
                {
                    id: 1,
                events: JSON.parse(@this.events),
                color: 'yellow',   // an option!
                textColor: 'black' // an option!
                }
                
            ],
            dateClick(info) {
                @this.resetdata();
                $('#exampleModal').modal('show');
                //$('#title').html(event.title);
                @this.dateStr = info.dateStr;
                //var title = prompt('Ingrese el título del evento');
                
                //var date = new Date(info.dateStr + 'T00:00:00');
                // if (title != null && title != '') {

                //     var eventAdd = {
                //         title: title,
                //         start: info.dateStr
                //     };
                //     // calendar.addEvent(eventAdd);
                //     //@this.addevent(eventAdd);
                //     //alert('Great. Now, update your database...');
                // } else {
                //     alert('Event Title Is Required');
                // }
                //eventSource.refetch();
                calendar.refetchEvents();
                //calendar.getEvents();
            },
            eventClick: function(info) {
                @this.loadmodal(info.event);
                $('#exampleModal').modal('show');
            },
            eventResize: info => @this.eventResize(info.event, info.oldEvent),
            eventDrop: info => @this.eventDrop(info.event, info.oldEvent),
            loading: function (isLoading) {
                if (!isLoading) {
                    // Reset custom events
                    this.getEvents().forEach(function (e) {
                        if (e.source === null) {
                            e.remove();
                        }
                    });
                }
            }
        });

        //calendar.addEventSource(JSON.parse(@this.events));

        calendar.render();
        @this.on('reloadEvents', () => {
            // var esx = ;
            //console.log(calendar.getEventSourceById( 1 ));
            //calendar.getEventSource[0].refetch();
            //calendar.addEventSource(JSON.parse(@this.events));
            // var es = calendar.getEventSources();
            // console.log(es[0]);
            // eventSource.refetch(es[0]);
            // calendar.getEventSources().forEach(eventSource => {
            //     //console.log(eventSource);
            //     eventSource.refetch();
            // });
            //calendar.fullCalendar('refetchEvents');
            calendar.refetchEvents();
            //console.log(calendar.events);
        });

        @this.on(`refreshCalendar`, (event) => {
            calendar.refetchEvents();
            console.log(event);
            var json = JSON.parse(event);
            var eventAdd = {
                id: json.id,
                title: json.title,
                start: json.start,
                end: json.end
            };
            calendar.addEvent(eventAdd);
        });
    });
</script>
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.9.0/main.min.css' rel='stylesheet' />
@endpush

</div>