<?php
/**
 * PopUp FarmDetails Component
 *
 * A minimalist popup component for displaying plot information on map markers.
 * Displays: Picture, Name, ID Number, and Plot ID.
 *
 * Usage:
 *   include_once '../ui/PopUp FarmDetails.php';
 *
 * Then in JS:
 *   marker.bindPopup(createPlotPreviewPopup(plot));
 */
?>
<style>
  /* Override leaflet popup container padding and margins */
  .custom-popup .leaflet-popup-content-wrapper {
    padding: 0px !important;
    border-radius: 8px !important;
  }
  .custom-popup .leaflet-popup-content {
    margin: 0px !important;
    padding: 0px !important;
  }
  /* Force hide close button just in case */
  .custom-popup .leaflet-popup-close-button {
    display: none !important;
  }
</style>
<script>
  /**
   * Generates the HTML string for the Leaflet marker popup preview.
   *
   * @param {Object} plot - The plot data object
   * @returns {string} HTML string
   */
  function createPlotPreviewPopup(plot) {
    if (!plot) return '';

    // Helper function to get initials from name
    const getInitials = (name) => {
      if (!name) return '??';
      return name.trim().split(/\s+/)
        .map(n => n[0] || '')
        .join('')
        .toUpperCase()
        .slice(0, 2);
    };

    const serverBase = (typeof API_BASE_URL !== 'undefined')
      ? API_BASE_URL.replace(/\/api\/?$/, '')
      : 'http://localhost:5000';

    // Resolve picture URL
    let pictureUrl = plot.beneficiaryPicture;
    let imgSrc = '';
    if (pictureUrl) {
      if (pictureUrl.startsWith('http')) {
        imgSrc = pictureUrl;
      } else {
        imgSrc = serverBase + '/' + pictureUrl.replace(/^\//, '');
      }
    }

    const name = plot.beneficiaryName || 'Unknown';
    const initials = getInitials(name);
    const beneficiaryId = plot.beneficiaryId || 'N/A';
    const plotId = plot.id || 'N/A';

    return `
      <div style="
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
        padding: 8px;
        min-width: 170px;
        max-width: 170px;
        border-radius: 2px;
        font-family: 'Montserrat', sans-serif;
        box-sizing: border-box;
      ">
        <!-- Profile Picture -->
        <div style="
          width: 60px;
          height: 60px;
          border-radius: 50%;
          overflow: hidden;
          border: 3px solid #2d7c4a;
          background-color: #f1f3f5;
          position: relative;
          box-sizing: border-box;
        ">
          ${imgSrc ? `
            <img 
              src="${imgSrc}"
              alt="Beneficiary"
              style="
                width: 100%;
                height: 100%;
                object-fit: cover;
                position: absolute;
                top: 0;
                left: 0;
              "
              onerror="
                this.style.display = 'none';
                if (this.nextElementSibling) {
                  this.nextElementSibling.style.display = 'flex';
                }
              "
            />
            <div style="
              display: none;
              position: absolute;
              top: 0;
              left: 0;
              width: 100%;
              height: 100%;
              align-items: center;
              justify-content: center;
              font-size: 24px;
              font-weight: bold;
              color: #6c757d;
            ">
              ${initials}
            </div>
          ` : `
            <div style="
              display: flex;
              align-items: center;
              justify-content: center;
              width: 100%;
              height: 100%;
              font-size: 20px;
              font-weight: bold;
              color: #6c757d;
              position: absolute;
              top: 0;
              left: 0;
            ">
              ${initials}
            </div>
          `}
        </div>
        
        <!-- Name -->
        <div style="
          font-size: 14px;
          font-weight: 600;
          color: #2d7c4a;
          text-align: center;
          line-height: 0.1;
        ">
          ${name}
        </div>
        
        <!-- ID Number -->
        <div style="
          font-size: 10px;
          color: #6c757d;
          text-align: center;
          font-weight: 500;
        ">
          ID: ${beneficiaryId}
        </div>
        
        <!-- Plot ID -->
        <div style="
          font-size: 12px;
          color: #2d7c4a;
          text-align: center;
          font-weight: 600;
          background-color: rgba(45, 124, 74, 0.1);
          padding: 6px 12px;
          border-radius: 4px;
          width: 100%;
          box-sizing: border-box;
        ">
          ${plotId}
        </div>
      </div>
    `;
  }
</script>
