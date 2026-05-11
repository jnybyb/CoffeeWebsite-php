<!-- FarmMap Component -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<style>
  .map-container-inner {
    width: 100%;
    height: 100%;
    background-color: #e5e3df; /* Map-like background color */
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #888;
    background-image: radial-gradient(#d5d3cf 1px, transparent 1px);
    background-size: 20px 20px;
  }
  
  .map-style-selector {
    position: absolute;
    top: 10px;
    right: 10px;
    z-index: 1000;
    display: flex;
    gap: 0.5rem;
  }
  
  .map-style-btn {
    width: 44px;
    height: 44px;
    border-radius: 6px;
    border: 2px solid white;
    box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    cursor: pointer;
    background-size: cover;
    background-position: center;
    position: relative;
  }
  
  .map-style-btn.street {
    background-color: #ddd;
    /* Placeholder for Street map tile */
    background-image: url('https://a.tile.openstreetmap.org/12/3421/2143.png');
  }
  
  .map-style-btn.satellite {
    background-color: #333;
    /* Placeholder for Satellite map tile */
    background-image: url('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/12/2143/3421');
  }

  .map-style-btn.active {
    border-color: var(--dark-green, #055035);
  }

  .map-style-label {
    position: absolute;
    bottom: -18px;
    left: 50%;
    transform: translateX(-50%);
    font-size: 0.55rem;
    background: rgba(0,0,0,0.7);
    color: white;
    padding: 2px 6px;
    border-radius: 3px;
    font-weight: 500;
    white-space: nowrap;
  }
</style>

<div class="map-container-inner" id="farmMapId">
  <!-- Map Style Selector -->
  <div class="map-style-selector">
    <div>
      <div class="map-style-btn street">
        <div class="map-style-label">Street</div>
      </div>
    </div>
    <div>
      <div class="map-style-btn satellite active">
        <div class="map-style-label">Satellite</div>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Initialize the Leaflet map
    var map = L.map('farmMapId', {
      zoomControl: false // Custom zoom control position
    }).setView([7.2589, 126.3883], 15); // Default coordinate: Taocanga, Manay, Davao Oriental
    
    L.control.zoom({
      position: 'topleft'
    }).addTo(map);

    var streetLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    });

    var satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
      attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community'
    }).addTo(map);

    var streetBtn = document.querySelector('.map-style-btn.street');
    var satelliteBtn = document.querySelector('.map-style-btn.satellite');

    if (streetBtn && satelliteBtn) {
        streetBtn.addEventListener('click', function(e) {
            e.preventDefault();
            if (!map.hasLayer(streetLayer)) {
                map.removeLayer(satelliteLayer);
                map.addLayer(streetLayer);
                streetBtn.classList.add('active');
                satelliteBtn.classList.remove('active');
            }
        });

        satelliteBtn.addEventListener('click', function(e) {
            e.preventDefault();
            if (!map.hasLayer(satelliteLayer)) {
                map.removeLayer(streetLayer);
                map.addLayer(satelliteLayer);
                satelliteBtn.classList.add('active');
                streetBtn.classList.remove('active');
            }
        });
    }

    // Stop propagation on the style selector so clicks don't hit the map
    var styleSelector = document.querySelector('.map-style-selector');
    if (styleSelector) {
        L.DomEvent.disableClickPropagation(styleSelector);
    }
  });
</script>
