var map;
var carMarkers = {};

document.addEventListener('DOMContentLoaded', function() {
    // 1. Inisialisasi Peta
    map = L.map('map').setView([3.1415, 101.4881], 13);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap'
    }).addTo(map);

    var carIcon = L.icon({
        iconUrl: 'https://cdn-icons-png.flaticon.com/512/3202/3202926.png',
        iconSize: [40, 40],
        iconAnchor: [20, 40],
        popupAnchor: [0, -40]
    });

    var bounds = [];
    
    // 2. Baca data yang appear dari PHP (window.fleetData)
    if(window.fleetData && window.fleetData.length > 0) {
        window.fleetData.forEach(function(car) {
            var lat = parseFloat(car.latitude);
            var lng = parseFloat(car.longitude);
            
            var marker = L.marker([lat, lng], {icon: carIcon}).addTo(map);
            
            marker.bindTooltip(`
                <span style="font-size:10px; color:#666;">${car.car_model}</span><br>
                <span style="font-size:12px; color:#007bff;">${car.plate_number}</span>
            `, {
                permanent: true, 
                direction: 'top', 
                offset: [0, -45],
                className: 'car-permanent-label'
            });
            
            var popupContent = `
                <div style="text-align:center; min-width: 150px;">
                    <h4 style="margin:0 0 5px 0; color:#333;">${car.car_model}</h4>
                    <span style="background:#007bff; color:#fff; padding:2px 6px; border-radius:4px; font-size:12px;">${car.plate_number}</span><br>
                    <span style="font-size:12px; color:#666; display:block; margin-top:8px;">Status: <b>${car.availability_status}</b></span>
                    <hr style="margin:10px 0; border:0; border-top:1px dashed #ccc;">
                    <span style="font-size:11px; color:#555; display:block;"><b>GPS Coordinates:</b><br>${lat.toFixed(6)}, ${lng.toFixed(6)}</span>
                </div>
            `;
            marker.bindPopup(popupContent);
            bounds.push([lat, lng]);
            
            var markerKey = lat + "_" + lng;
            carMarkers[markerKey] = marker;
        });

        if(bounds.length > 0) {
            map.fitBounds(bounds, {padding: [50, 50]});
        }
    }
});

// 3. Fungsi fly ke kereta
function focusOnCar(lat, lng) {
    map.flyTo([lat, lng], 17, {
        animate: true,
        duration: 1.5
    });
    
    setTimeout(function() {
        var markerKey = lat + "_" + lng;
        if(carMarkers[markerKey]) {
            carMarkers[markerKey].openPopup();
        }
    }, 1500);
    
    window.scrollTo({ top: 0, behavior: 'smooth' });
}