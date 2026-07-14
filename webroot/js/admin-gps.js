var map;
var carMarkers = {};
var liveInterval;

document.addEventListener('DOMContentLoaded', function() {
    
    map = L.map('map').setView([3.1415, 101.4881], 13);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap'
    }).addTo(map);

    var bounds = [];
    
    if(window.fleetData && window.fleetData.length > 0) {
        window.fleetData.forEach(function(car) {
            var lat = parseFloat(car.latitude);
            var lng = parseFloat(car.longitude);
            var statusStr = car.availability_status.toLowerCase();
            var markerColor = '#6c757d';
            
            if (statusStr.includes('available')) markerColor = '#28a745';
            else if (statusStr.includes('rent')) markerColor = '#dc3545'; 
            else if (statusStr.includes('maintenance')) markerColor = '#ffc107';
            
            var svgIcon = L.divIcon({
                className: 'custom-div-icon',
                html: `<div style="background-color:${markerColor}; width:28px; height:28px; border-radius:50%; border:3px solid white; box-shadow: 0 0 10px rgba(0,0,0,0.5); display:flex; justify-content:center; align-items:center; color:white; font-size:12px;"><i class="fas fa-car"></i></div>`,
                iconSize: [34, 34],
                iconAnchor: [17, 17],
                popupAnchor: [0, -17]
            });
            
            var marker = L.marker([lat, lng], {icon: svgIcon}).addTo(map);
            
            marker.bindTooltip(`
                <strong style="color: #333;">${car.car_model}</strong><br>
                <span style="color: ${markerColor}; font-weight: bold;">${car.plate_number}</span>
            `, {
                permanent: true, direction: 'top', offset: [0, -15], className: 'car-permanent-label'
            });
            
            var popupContent = `
                <div style="text-align:center; min-width: 150px;">
                    <h4 style="margin:0 0 5px 0; color:#333;">${car.car_model}</h4>
                    <span style="background:#007bff; color:#fff; padding:2px 6px; border-radius:4px; font-size:12px;">${car.plate_number}</span><br>
                    <span style="font-size:12px; color:#666; display:block; margin-top:8px;">Status: <b style="color:${markerColor}">${car.availability_status}</b></span>
                    <hr style="margin:10px 0; border:0; border-top:1px dashed #ccc;">
                    <span style="font-size:11px; color:#555; display:block;"><b>GPS Coordinates:</b><br><span id="popup-coord-${car.id}">${lat.toFixed(6)}, ${lng.toFixed(6)}</span></span>
                </div>
            `;
            marker.bindPopup(popupContent);
            bounds.push([lat, lng]);
            
            carMarkers[car.id] = {
                marker: marker, baseLat: lat, baseLng: lng, status: statusStr, id: car.id
            };
        });

        if(bounds.length > 0) {
            map.fitBounds(bounds, {padding: [50, 50]});
        }
    }

    // SEARCH LOGIC
    const filterButtons = document.querySelectorAll('.cat-filter-btn');
    const searchInput = document.getElementById('gpsSearch');
    const tableRows = document.querySelectorAll('.gps-row');

    function filterFleet() {
        let activeCatBtn = document.querySelector('.cat-filter-btn.active');
        let activeCat = activeCatBtn ? activeCatBtn.getAttribute('data-cat') : 'all';
        let searchTerm = searchInput.value.toLowerCase();
        let visibleBounds = [];

        tableRows.forEach(row => {
            let cat = row.getAttribute('data-cat');
            let plate = row.getAttribute('data-plate').toLowerCase();
            let rowId = row.getAttribute('data-id');

            let matchCat = (activeCat === 'all' || cat === activeCat);
            let matchSearch = plate.includes(searchTerm);

            if (matchCat && matchSearch) {
                row.style.display = '';
                if(carMarkers[rowId]) {
                    map.addLayer(carMarkers[rowId].marker);
                    visibleBounds.push([carMarkers[rowId].marker.getLatLng().lat, carMarkers[rowId].marker.getLatLng().lng]);
                }
            } else {
                row.style.display = 'none';
                if(carMarkers[rowId]) {
                    map.removeLayer(carMarkers[rowId].marker);
                }
            }
        });

        if(visibleBounds.length > 0) {
            map.fitBounds(visibleBounds, {padding: [50, 50], maxZoom: 15});
        }
    }

    filterButtons.forEach(btn => btn.addEventListener('click', function() {
        filterButtons.forEach(b => { b.classList.remove('active', 'badge-blue'); b.classList.add('badge-grey'); });
        this.classList.remove('badge-grey');
        this.classList.add('active', 'badge-blue');
        filterFleet();
    }));

    if(searchInput) searchInput.addEventListener('input', filterFleet);

    // LIVE SIMULATION LOGIC
    const liveToggle = document.getElementById('liveToggle');
    const liveText = document.getElementById('liveStatusText');
    const timeCells = document.querySelectorAll('.gps-time');

    if(liveToggle) {
        liveToggle.addEventListener('change', function() {
            if(this.checked) {
                liveText.innerText = 'Live Tracking: ON';
                liveText.style.color = '#dc3545';
                
                liveInterval = setInterval(() => {
                    Object.keys(carMarkers).forEach(key => {
                        let carData = carMarkers[key];
                        if(carData.status.includes('rent')) {

                            let newLat = carData.marker.getLatLng().lat + (Math.random() - 0.5) * 0.0005;
                            let newLng = carData.marker.getLatLng().lng + (Math.random() - 0.5) * 0.0005;
                            carData.marker.setLatLng([newLat, newLng]);
                            
                            // Produce random speed between 50 - 80 km/h
                            let speed = Math.floor(Math.random() * (80 - 50 + 1)) + 50;
                            
                            let coordCell = document.querySelector('.gps-coord-' + carData.id);
                            let popupCoord = document.getElementById('popup-coord-' + carData.id);
                            let speedCell = document.querySelector('.gps-speed-' + carData.id);
                            
                            if(coordCell) coordCell.innerText = newLat.toFixed(6) + ', ' + newLng.toFixed(6);
                            if(popupCoord) popupCoord.innerText = newLat.toFixed(6) + ', ' + newLng.toFixed(6);
                            if(speedCell) speedCell.innerText = speed + ' km/h';
                        }
                    });
                    
                    timeCells.forEach(cell => {
                        cell.innerHTML = '<i class="fas fa-circle live-blink" style="color: #dc3545;"></i> Just now';
                    });
                }, 2500);
            } else {
                liveText.innerText = 'Live Tracking: OFF';
                liveText.style.color = '#555';
                clearInterval(liveInterval);
                
                Object.keys(carMarkers).forEach(key => {
                    let carData = carMarkers[key];
                    carData.marker.setLatLng([carData.baseLat, carData.baseLng]);
                    let speedCell = document.querySelector('.gps-speed-' + carData.id);
                    if(speedCell) speedCell.innerText = '0 km/h';
                });
                
                timeCells.forEach(cell => {
                    cell.innerHTML = '<i class="fas fa-circle"></i> Paused';
                });
            }
        });
    }
    
    // VIEW BUTTON
    const viewBtns = document.querySelectorAll('.btn-view');
    const gpsModalOverlay = document.getElementById('gpsViewModal');
    const closeGpsModalBtn = document.getElementById('closeGpsModalBtn');

    if(viewBtns.length > 0 && gpsModalOverlay) {
        viewBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                
                document.getElementById('modalCarModel').innerText = this.getAttribute('data-model');
                document.getElementById('modalCarPlate').innerText = this.getAttribute('data-plate');
                
                let statusText = this.getAttribute('data-status');
                let statusEl = document.getElementById('modalCarStatus');
                statusEl.innerText = statusText;
                
                let lowerStatus = statusText.toLowerCase();
                if(lowerStatus.includes('available')) statusEl.style.color = '#28a745';
                else if(lowerStatus.includes('rent')) statusEl.style.color = '#dc3545';
                else statusEl.style.color = '#ffc107';

                document.getElementById('modalCarCoords').innerText = this.getAttribute('data-lat') + ', ' + this.getAttribute('data-lng');
                
                let baseIndicator = document.getElementById('modalBaseIndicator');
                if(lowerStatus.includes('available')) {
                    baseIndicator.style.display = 'flex';
                } else {
                    baseIndicator.style.display = 'none';
                }
                
                gpsModalOverlay.classList.add('show');
            });
        });

        closeGpsModalBtn.addEventListener('click', () => { gpsModalOverlay.classList.remove('show'); });
        gpsModalOverlay.addEventListener('click', (e) => {
            if(e.target === gpsModalOverlay) gpsModalOverlay.classList.remove('show');
        });
    }

});

function focusOnCar(carId) {
    if(carMarkers[carId]) {
        let targetMarker = carMarkers[carId].marker;
        let currentLat = targetMarker.getLatLng().lat;
        let currentLng = targetMarker.getLatLng().lng;

        map.flyTo([currentLat, currentLng], 17, { animate: true, duration: 1.5 });
        setTimeout(() => targetMarker.openPopup(), 1500);
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
}