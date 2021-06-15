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


<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Launch demo modal
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" 
        aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            ...
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
        </div>
        </div>
    </div>
    </div>


  </div>
</div>



@push('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.7.2/main.min.js'></script>

<script>
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
            timeFormat: 'HH:mm',
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
            events: JSON.parse(@this.events),
            eventClick: function(info) {
                //alert('Event: ' + info.event.title);
                alert('Coordinates: ' + info.view.type);
                //info.jsEvent.('#exampleModal').modal(); 
                $("#exampleModal").modal();
            },
            dateClick(info) {
                //$('#exampleModal').modal('show');
                //$('#exampleModal').modal();
                //var myModal = new bootstrap.Modal(document.getElementById('exampleModal'), options)
                
                var title = prompt('Ingrese el título del evento');
                //var date = new Date(info.dateStr + 'T00:00:00');
                if (title != null && title != '') {

                    var eventAdd = {
                        title: title,
                        start: info.dateStr
                    };
                    calendar.addEvent(eventAdd);
                    @this.addevent(eventAdd);
                    //alert('Great. Now, update your database...');
                } else {
                    alert('Event Title Is Required');
                }
                //eventSource.refetch();
                calendar.refetchEvents();
                calendar.getEvents();
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
        calendar.render();
        @this.on(`refreshCalendar`, () => {
            calendar.refetchEvents()
        });
    });
</script>
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.7.2/main.min.css' rel='stylesheet' />
@endpush