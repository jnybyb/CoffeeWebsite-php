<!-- FarmMap Component -->
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
  <span style="background: rgba(255,255,255,0.8); padding: 0.5rem 1rem; border-radius: 4px; font-size: 0.8rem; border: 1px dashed #ccc;">[ Interactive Leaflet Map Placeholder ]</span>
  
  <!-- Map Style Selector -->
  <div class="map-style-selector">
    <div>
      <div class="map-style-btn street active">
        <div class="map-style-label">Street</div>
      </div>
    </div>
    <div>
      <div class="map-style-btn satellite">
        <div class="map-style-label">Satellite</div>
      </div>
    </div>
  </div>
</div>
