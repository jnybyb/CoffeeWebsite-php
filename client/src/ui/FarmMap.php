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
    top: 1rem;
    right: 1rem;
    z-index: 1000;
    display: flex;
    gap: 0.5rem;
  }

  .map-style-btn {
    width: 48px;
    height: 45px;
    padding: 0;
    border: 3px solid transparent;
    border-radius: 4px;
    cursor: pointer;
    overflow: hidden;
    background-size: cover;
    background-position: center;
    position: relative;
    transition: all 0.2s ease;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
  }

  .map-style-btn.street {
    background-image: url('../../assets/images/mapstyles/street.png');
  }

  .map-style-btn.satellite {
    background-image: url('../../assets/images/mapstyles/satellite.png');
  }

  .map-style-btn.active {
    border-color: var(--dark-green, #055035);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
  }

  .map-style-btn:not(.active):hover {
    transform: scale(1.05);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
  }

  .map-style-label {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(to top, rgba(0, 0, 0, 0.8) 0%, rgba(0, 0, 0, 0.1) 100%);
    color: white;
    font-size: 9px;
    font-weight: 600;
    padding: 4px 2px;
    text-align: center;
    pointer-events: none;
  }
</style>

<div class="map-container-inner" id="farmMapId">
  <!-- Map Style Selector -->
  <div class="map-style-selector">
    <button type="button" class="map-style-btn street" id="mapStyleStreetBtn" title="Street">
      <span class="map-style-label">Street</span>
    </button>
    <button type="button" class="map-style-btn satellite active" id="mapStyleSatelliteBtn" title="Satellite">
      <span class="map-style-label">Satellite</span>
    </button>
  </div>
</div>

<?php include_once __DIR__ . '/FarmPlotIndicator.php'; ?>
<?php include_once __DIR__ . '/PopUp FarmDetails.php'; ?>

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

    var streetBtn = document.getElementById('mapStyleStreetBtn');
    var satelliteBtn = document.getElementById('mapStyleSatelliteBtn');

    if (streetBtn && satelliteBtn) {
        streetBtn.addEventListener('click', function() {
            if (!map.hasLayer(streetLayer)) {
                map.removeLayer(satelliteLayer);
                map.addLayer(streetLayer);
                streetBtn.classList.add('active');
                satelliteBtn.classList.remove('active');
            }
        });

        satelliteBtn.addEventListener('click', function() {
            if (!map.hasLayer(satelliteLayer)) {
                map.removeLayer(streetLayer);
                map.addLayer(satelliteLayer);
                satelliteBtn.classList.add('active');
                streetBtn.classList.remove('active');
            }
        });
    }

    window.leafletMap = map;

    let activePolygon = null;
    let activeCornerMarkers = [];

    window.clearActivePlotBoundary = function() {
      if (activePolygon && window.leafletMap.hasLayer(activePolygon)) {
        window.leafletMap.removeLayer(activePolygon);
      }
      activePolygon = null;

      activeCornerMarkers.forEach(m => {
        if (window.leafletMap.hasLayer(m)) {
          window.leafletMap.removeLayer(m);
        }
      });
      activeCornerMarkers = [];
    };

    window.showActivePlotBoundary = function(plot) {
      window.clearActivePlotBoundary();

      if (!plot || !plot.polygon) return;

      activePolygon = plot.polygon;
      activePolygon.addTo(window.leafletMap);

      if (plot.coordinates && plot.coordinates.length > 0) {
        plot.coordinates.forEach(coord => {
          const cornerMarker = L.circleMarker([coord.lat, coord.lng], {
            radius: 5,
            color: '#055035',
            fillColor: '#ffffff',
            fillOpacity: 1,
            weight: 3
          }).addTo(window.leafletMap);

          activeCornerMarkers.push(cornerMarker);
        });
      }
    };

    // Define global function to draw farm plots on Leaflet map
    window.drawFarmPlotsOnMap = function(plots) {
      if (!window.leafletMap) return;

      // Clear any active boundary first
      window.clearActivePlotBoundary();

      // Clear existing polygons
      if (window.mapPolygons) {
        window.mapPolygons.forEach(p => {
          if (window.leafletMap.hasLayer(p)) {
            window.leafletMap.removeLayer(p);
          }
        });
      }
      window.mapPolygons = [];

      // Clear existing center markers
      if (window.mapMarkers) {
        window.mapMarkers.forEach(m => window.leafletMap.removeLayer(m));
      }
      window.mapMarkers = [];

      plots.forEach(plot => {
        if (plot.coordinates && plot.coordinates.length >= 3) {
          const latlngs = plot.coordinates.map(c => [c.lat, c.lng]);

          // Draw the plot boundary polygon (do not addTo map yet)
          const polygon = L.polygon(latlngs, {
            color: '#055035',
            fillColor: '#066e46',
            fillOpacity: 0.35,
            weight: 2
          });

          plot.polygon = polygon;
          window.mapPolygons.push(polygon);

          // ── Centroid marker ──────────────────────────────────────────
          // Calculate the average lat/lng of all coordinate points
          let sumLat = 0, sumLng = 0;
          latlngs.forEach(ll => { sumLat += ll[0]; sumLng += ll[1]; });
          const centerLat = sumLat / latlngs.length;
          const centerLng = sumLng / latlngs.length;

          // Build the custom teardrop icon (defined in FarmPlotIndicator.php)
          const icon = (typeof createLocationIcon === 'function')
            ? createLocationIcon(plot.beneficiaryPicture, plot.beneficiaryName)
            : null;

          const markerOpts = icon ? { icon: icon } : {};
          const marker = L.marker([centerLat, centerLng], markerOpts)
            .addTo(window.leafletMap);

          // Attach the same popup info to the center marker
          if (typeof createPlotPreviewPopup === 'function') {
            marker.bindPopup(createPlotPreviewPopup(plot), { closeButton: false, className: 'custom-popup' });
          } else {
            marker.bindPopup(`
              <div style="font-family:'Montserrat',sans-serif;font-size:11px;color:#333;line-height:1.4;padding:4px;">
                <h4 style="color:#055035;margin:0 0 4px 0;font-size:12px;font-weight:700;">Plot ID: ${plot.id}</h4>
                <div style="margin-bottom:2px;"><strong>Owner:</strong> ${plot.beneficiaryName}</div>
                <div style="margin-bottom:2px;"><strong>Size:</strong> ${plot.hectares ? parseFloat(plot.hectares).toFixed(2) + ' ha' : '—'}</div>
                <div><strong>Address:</strong> ${plot.address || 'No address'}</div>
              </div>
            `);
          }
          // Attach popup open/close listeners to the marker
          marker.on('popupopen', function() {
            if (typeof window.showActivePlotBoundary === 'function') {
              window.showActivePlotBoundary(plot);
            }
          });
          marker.on('popupclose', function() {
            if (typeof window.clearActivePlotBoundary === 'function') {
              window.clearActivePlotBoundary();
            }
          });

          plot.marker = marker;
          window.mapMarkers.push(marker);
        }
      });

      // Fit the map view to cover all plots
      if (window.mapPolygons.length > 0) {
        const group = L.featureGroup([...window.mapPolygons, ...window.mapMarkers]);
        window.leafletMap.fitBounds(group.getBounds(), { padding: [40, 40] });
      }
    };

    // If plots are already loaded, draw them now
    if (window.allFarmPlots) {
      window.drawFarmPlotsOnMap(window.allFarmPlots);
    }

    // Stop propagation on the style selector so clicks don't hit the map
    var styleSelector = document.querySelector('.map-style-selector');
    if (styleSelector) {
        L.DomEvent.disableClickPropagation(styleSelector);
    }
  });
</script>
