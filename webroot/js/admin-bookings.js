document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('bookingCalendar');
    
    // Pastikan elemen kalendar dan data PHP wujud
    if (calendarEl && window.calendarEvents) {
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            height: 'auto',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,listWeek'
            },
            events: window.calendarEvents,
            eventTimeFormat: {
                hour: 'numeric',
                minute: '2-digit',
                meridiem: 'short'
            },
            // Benarkan pengguna klik event untuk pergi ke URL View
            eventClick: function(info) {
                if (info.event.url) {
                    window.location.href = info.event.url;
                    info.jsEvent.preventDefault(); // Elak browser buka tab baru secara rawak
                }
            }
        });
        
        calendar.render();
    }
});