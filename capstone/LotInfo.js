document.addEventListener('DOMContentLoaded', (event) => {
    const gridItems = document.querySelectorAll('.grid-itemA3, .grid-itemB3, .grid-itemA2, .grid-itemB2, .grid-itemA,.grid-itemB, .grid-itemC2S1A, '+
        '.grid-itemC2S1B, .grid-itemC2S2A, .grid-itemC2S2B, .grid-itemC2S12A, .grid-itemC2S12B, .grid-itemC2S22A, '+
        '.grid-itemC2S22B, .grid-itemC1S1A, .grid-itemC1S1B, .grid-itemC1SA, .grid-itemC1SB, .grid-itemRAF, .grid-itempeter, '+
        '.grid-itempaul, .grid-itemjude, .grid-itemjohn, .grid-itemjoseph, .grid-itemjames, .grid-itemagustine, .grid-itemdominic, '+
        '.grid-itemmark, .grid-itemluke, .grid-itemisidore, .grid-itemmatthew, .grid-itemC2blk3A, .grid-itemC2blk3B, .grid-itemC2blk4A, '+
        '.grid-itemC2blk4B, .grid-itemblk3AC2, .grid-itemblk3BC2, .grid-itemblk4AC2, .grid-itemblk4BC2, .grid-itemC1S11A, .grid-itemC1S11B, '+
        '.grid-itemC1S22A, .grid-itemC1S22B, .grid-itemC1BLK3A, .grid-itemC1BLK3B, .grid-itemC1BLK4A, .grid-itemC1BLK4B, .grid-itemC1blk3A2nd, '+
        '.grid-itemC1blk3B2nd, .grid-itemC1blk4A2nd, .grid-itemC1blk4A2nd'); // Include all relevant classes
    const popup = document.getElementById('itemPopup');
    const popupContent = document.getElementById('popupContent');
    const closePopup = document.getElementById('closePopup');

    gridItems.forEach(item => {
        item.addEventListener('click', function() {
            // Extract lot number, memorial status, and memorial lot from data attributes
            const lotNo = this.getAttribute('data-lotno');
            const memSts = this.getAttribute('data-memsts');
            const memLot = this.getAttribute('data-memlot');
            
            // Look for the closest container (adjust this part for dynamic parent containers)
            const parentContainer = this.closest('.SAa3Grid, .SBa3Grid, .SAa2GridA2, .SBa2Grid, .SAa1GridA, .SBa1Grid, .C2GRIDS1AGrid, '+
                '.C2GRIDS1BGrid, .C2GRIDS2AGrid, .C2GRIDS2BGrid, .C2GRIDS12AGrid, .C2GRIDS12BGrid, .C2GRIDS22AGrid, .C2GRIDS22BGrid, '+
                '.C1GRIDS1AGrid, .C1GRIDS1BGrid, .C1GRIDSAGrid, .C1GRIDSBGrid, .RAFgrid, .petergrid, .paulgrid, .judegrid, .johngrid, '+
                '.josephgrid, .jamesgrid, .agustinegrid, .dominicgrid, .markgrid, .lukegrid, .isidoregrid, .matthewgrid, .C2GRIDblk3AGrid, '+
                '.C2GRIDblk3BGrid, .C2GRIDblk4AGrid, .C2GRIDblk4BGrid, .C2blk3GRIDGrid, .C2blk3BGRIDGrid, .C2blk4AGRIDGrid, .C2blk4BGRIDGrid, '+
                '.C1GRIDS11AGrid, .C1GRIDS11BGrid, .C1GRIDS22AGrid, .C1GRIDS22BGrid, .C1GRIDBLK3AGrid, .C1GRIDBLK3BGrid, '+
                '.C1GRIDBLK4AGrid, .C1GRIDBLK4BGrid, .C1GRIDblk3A2ndGrid, .C1GRIDblk3B2ndGrid, .C1GRIDblk4A2ndGrid, .C1GRIDblk4B2ndGrid'); // Add any other containers

            if (!parentContainer) {
                console.error('Parent container not found');
                return;
            }

            // Show the popup immediately with a loading message
            popupContent.innerHTML = `<h3 style="color: blue;">Loading details...</h3>`;
            
            // Append the popup to the specific parent container
            parentContainer.appendChild(popup);
            popup.style.display = 'block';

            // Fetch the record based on the lot number (lotNo) and memorial status (memSts)
            fetch(`fetch_record.php?lotno=${lotNo}&memsts=${memSts}`)
                .then(response => {
                    console.log('Fetch response status:', response.status);
                    return response.json();
                })
                .then(data => {
                    console.log('Fetched data:', data);
                    if (data.message) {
                        // If no record is found, check the value of memLot and display corresponding message
                        if (memLot === "Family Estate") {
                            popupContent.innerHTML = `
                            <div style="text-align: left;">
                            <h3 style="color: green;">Status: Available</h3>
                            <hr><br>
                            <p style="font-style: italic;">This lot is currently available for purchase.</p>
                            <br>
                             <p style="font-style: italic;">Memorial Lot Type: Family Estate</p>`;
                        } else if (memLot === "Garden Lots") {
                            popupContent.innerHTML = `
                            <div style="text-align: left;">
                            <h3 style="color: green;">Status: Available</h3>
                            <hr><br>
                             <p style="font-style: italic;">This lot is currently available for purchase.</p>
                            <p style="font-style: italic;">Memorial Lot Type: Garden Lots</p>`;
                        } else if (memLot === "Lawn Lots") {
                            popupContent.innerHTML = `
                            <div style="text-align: left;">
                            <h3 style="color: green;">Status: Available</h3>
                            <hr><br>
                             <p style="font-style: italic;">This lot is currently available for purchase.</p>
                             <br>
                            <p style="font-style: italic;">Memorial Lot Type: Lawn Lots</p>`;
                        } else {
                            popupContent.innerHTML = `
                                <h3 style="color: green;">Status: Available</h3>
                                <hr><br>
                                <p style="font-style: italic;">This lot is currently available for purchase.</p>`;
                        }
                    } else {
                        // Display the fetched record details
                        popupContent.innerHTML = `
                            <div id="backgroundContent" style="text-align: left;">
                                <h4 style="color: red;">Status: Sold</h4>
                                <hr><br>
                                <div>
                                    <label>Lot Number: ${data.Lot_No}</label>
                                </div>
                                <br>
                                <div>
                                    <label>Memorial Lots: ${data.mem_lots}</label>
                                </div>
                                <br>
                                <div>
                                    <label>Memorial Name: ${data.mem_sts}</label>
                                </div>
                                <br>
                                <div>
                                    <label>Lot Owner: ${data.LO_name}</label>
                                </div>
                                <br>
                                <div>
                                    <label>Address: ${data.mem_address}</label>
                                </div>
                            </div>`;
                    }
                })
                .catch(error => {
                    console.error('Error fetching details:', error);
                    popupContent.innerHTML = `<h3 style="color: red;">Error fetching details. Please try again later.</h3>`;
                });
        });
    });

    // Close popup logic
    closePopup.addEventListener('click', function() {
        popup.style.display = 'none';
    });
});
