<?php
/**
 * FarmPlotIndicator Component
 *
 * Provides the createLocationIcon() JavaScript function for rendering
 * custom Leaflet markers shaped like a location pin (teardrop) with the
 * beneficiary's profile photo clipped inside the circle portion.
 *
 * Usage:
 *   include_once '../ui/FarmPlotIndicator.php';
 *
 * Then in a Leaflet map context:
 *   var icon = createLocationIcon(plot.beneficiaryPicture, plot.beneficiaryName);
 *   L.marker(centerLatLng, { icon: icon }).addTo(map);
 */
?>

<style>
  /* Suppress default Leaflet divIcon border/background so our custom HTML shines through */
  .location-pin-marker {
    background: transparent !important;
    border: none !important;
    overflow: visible !important;
  }
</style>

<script>
  /**
   * createLocationIcon(pictureUrl, beneficiaryName)
   *
   * Returns a Leaflet L.DivIcon shaped as a green teardrop pin.
   * The rounded top contains the beneficiary's profile photo.
   * Falls back to initials on image load error or when no picture is provided.
   *
   * @param {string|null} pictureUrl  - Relative "/uploads/…" path or full URL
   * @param {string}      beneficiaryName - Beneficiary's full name
   * @returns {L.DivIcon}
   */
  function createLocationIcon(pictureUrl, beneficiaryName) {
    const serverBase = (typeof API_BASE_URL !== 'undefined')
      ? API_BASE_URL.replace(/\/api\/?$/, '')
      : 'http://localhost:5000';

    // Resolve image source
    let imgSrc = '';
    if (pictureUrl) {
      if (pictureUrl.startsWith('http')) {
        imgSrc = pictureUrl;
      } else {
        // Strip leading slash to avoid double-slash
        imgSrc = serverBase + '/' + pictureUrl.replace(/^\//, '');
      }
    }

    // Build initials fallback (up to 2 chars)
    const initials = beneficiaryName
      ? beneficiaryName
          .trim()
          .split(/\s+/)
          .map(w => w[0] || '')
          .join('')
          .substring(0, 2)
          .toUpperCase()
      : '?';

    // Bounding dimensions
    const totalW = 50;
    const totalH = 60;

    const html = `
      <div style="
        position: relative;
        width:  ${totalW}px;
        height: ${totalH}px;
        filter: drop-shadow(0 4px 6px rgba(0,0,0,0.3));
      ">
        <!-- SVG Teardrop Pin Shape -->
        <svg width="${totalW}" height="${totalH}" viewBox="0 0 ${totalW} ${totalH}" style="
          position: absolute;
          top: 0;
          left: 0;
          z-index: 1;
        ">
          <path d="M25,2 C12.8,2 3,11.8 3,24 C3,38.5 25,58 25,58 C25,58 47,38.5 47,24 C47,11.8 37.2,2 25,2 Z" fill="#2d7c4a" />
        </svg>

        <!-- Inner Circular Content (Photo/Initials) -->
        <div style="
          position: absolute;
          z-index: 2;
          top: 7px;
          left: 8px;
          width: 34px;
          height: 34px;
          border-radius: 50%;
          overflow: hidden;
          background-color: #ffffff;
          display: flex;
          align-items: center;
          justify-content: center;
        ">
          ${imgSrc ? `
            <img
              src="${imgSrc}"
              alt="${initials}"
              style="
                width: 100%;
                height: 100%;
                object-fit: cover;
              "
              onerror="
                this.style.display='none';
                if (this.nextElementSibling) {
                  this.nextElementSibling.style.display='flex';
                }
              "
            />
            <div style="
              display: none;
              width: 100%;
              height: 100%;
              align-items: center;
              justify-content: center;
              font-size: 13px;
              font-weight: 700;
              color: #2d7c4a;
              font-family: 'Montserrat', sans-serif;
              background-color: #f1f3f5;
            ">${initials}</div>
          ` : `
            <div style="
              width: 100%;
              height: 100%;
              display: flex;
              align-items: center;
              justify-content: center;
              font-size: 13px;
              font-weight: 700;
              color: #2d7c4a;
              font-family: 'Montserrat', sans-serif;
              background-color: #f1f3f5;
            ">${initials}</div>
          `}
        </div>
      </div>
    `;

    return L.divIcon({
      className:   'location-pin-marker',
      html:        html,
      iconSize:    [totalW, totalH],
      iconAnchor:  [25, 58],  // tip touches the coordinate point
      popupAnchor: [0, -60]   // popup floats above the pin
    });
  }
</script>
