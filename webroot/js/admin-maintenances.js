document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('maintenanceCalendar');
    
    if (calendarEl && window.maintenanceEvents) {
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,listMonth'
            },
            events: window.maintenanceEvents,
            eventClick: function(info) {
                if (info.event.url) {
                    window.location.href = info.event.url;
                    info.jsEvent.preventDefault();
                }
            }
        });
        calendar.render();
    }
});