String.prototype.toProperCase = function() { return this.replace(/\w\S*/g, function(txt) { return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase(); }); };


document.addEventListener('DOMContentLoaded', (event) => {
    const gridItems = document.querySelectorAll('.grid-itemA3, .grid-itemB3, .grid-itemA2, .grid-itemB2, .grid-itemA,.grid-itemB, .grid-itemC2S1A, ' +
        '.grid-itemC2S1B, .grid-itemC2S2A, .grid-itemC2S2B, .grid-itemC2S12A, .grid-itemC2S12B, .grid-itemC2S22A, ' +
        '.grid-itemC2S22B, .grid-itemC1S1A, .grid-itemC1S1B, .grid-itemC1SA, .grid-itemC1SB, .grid-itemRAF, .grid-itempeter, ' +
        '.grid-itempaul, .grid-itemjude, .grid-itemjohn, .grid-itemjoseph, .grid-itemjames, .grid-itemagustine, .grid-itemdominic, ' +
        '.grid-itemmark, .grid-itemluke, .grid-itemisidore, .grid-itemmatthew, .grid-itemC2blk3A, .grid-itemC2blk3B, .grid-itemC2blk4A, ' +
        '.grid-itemC2blk4B, .grid-itemblk3AC2, .grid-itemblk3BC2, .grid-itemblk4AC2, .grid-itemblk4BC2, .grid-itemC1S11A, .grid-itemC1S11B, ' +
        '.grid-itemC1S22A, .grid-itemC1S22B, .grid-itemC1BLK3A, .grid-itemC1BLK3B, .grid-itemC1BLK4A, .grid-itemC1BLK4B, .grid-itemC1blk3A2nd, ' +
        '.grid-itemC1blk3B2nd, .grid-itemC1blk4A2nd, .grid-itemC1blk4B2nd, .grid-itempm'); // Include all relevant classes
    const popup = document.getElementById('itemPopup');
    const popupContent = document.getElementById('popupContent');
    const closePopup = document.getElementById('closePopup');

    gridItems.forEach(item => {
        item.addEventListener('click', function() {
            const lotNo = this.getAttribute('data-lotno');
            const memSts = this.getAttribute('data-memsts');
            const memLot = this.getAttribute('data-memlot');

            const parentContainer = this.closest('.SAa3Grid, .SBa3Grid, .SAa2GridA2, .SBa2Grid, .SAa1GridA, .SBa1Grid, .C2GRIDS1AGrid, ' +
                '.C2GRIDS1BGrid, .C2GRIDS2AGrid, .C2GRIDS2BGrid, .C2GRIDS12AGrid, .C2GRIDS12BGrid, .C2GRIDS22AGrid, .C2GRIDS22BGrid, ' +
                '.C1GRIDS1AGrid, .C1GRIDS1BGrid, .C1GRIDSAGrid, .C1GRIDSBGrid, .RAFgrid, .petergrid, .paulgrid, .judegrid, .johngrid, ' +
                '.josephgrid, .jamesgrid, .agustinegrid, .dominicgrid, .markgrid, .lukegrid, .isidoregrid, .matthewgrid, .C2GRIDblk3AGrid, ' +
                '.C2GRIDblk3BGrid, .C2GRIDblk4AGrid, .C2GRIDblk4BGrid, .C2blk3GRIDGrid, .C2blk3BGRIDGrid, .C2blk4AGRIDGrid, .C2blk4BGRIDGrid, ' +
                '.C1GRIDS11AGrid, .C1GRIDS11BGrid, .C1GRIDS22AGrid, .C1GRIDS22BGrid, .C1GRIDBLK3AGrid, .C1GRIDBLK3BGrid, ' +
                '.C1GRIDBLK4AGrid, .C1GRIDBLK4BGrid, .C1GRIDblk3A2ndGrid, .C1GRIDblk3B2ndGrid, .C1GRIDblk4A2ndGrid, .C1GRIDblk4B2ndGrid, .pmgrid'); // Add any other containers

            if (!parentContainer) {
                console.error('Parent container not found');
                return;
            }

            popupContent.innerHTML = `<h3 style="color: blue;">Loading details...</h3>`;
            parentContainer.appendChild(popup);
            popup.style.display = 'block';

            fetch(`fetch_record.php?lotno=${lotNo}&memsts=${memSts}`)
                .then(response => {
                    console.log('Fetch response status:', response.status);
                    return response.json();
                })
                .then(data => {
                    console.log('Fetched data:', data);
                    if (data.message) {
                        let memLotMessage = '';

                        switch (memLot) {
                            case "Family Estate":
                                memLotMessage = 'Memorial Lot Type: Family Estate';
                                break;
                            case "Garden Lots":
                                memLotMessage = 'Memorial Lot Type: Garden Lots';
                                break;
                            case "Lawn Lots":
                                memLotMessage = 'Memorial Lot Type: Lawn Lots';
                                break;
                            default:
                                memLotMessage = 'This lot is currently available for purchase.';
                        }

                        popupContent.innerHTML = `
                            <div style="text-align: left;">
                                <h3 style="color: green;">Status: Available</h3>
                                <hr><br>
                                <p style="font-style: italic;">This lot is currently available for purchase.</p>
                                <br>
                                <p style="font-style: italic;">${memLotMessage.toProperCase()}</p>
                            </div>`;
                    } else {
                        popupContent.innerHTML = `
                            <div id="backgroundContent" style="text-align: left;">
                                <h4 style="color: red;">Status: Owned</h4>
                                <hr><br>
                                <div>
                                    <label>Lot Number: ${(data.Lot_No || '').toProperCase()}</label>
                                </div>
                                <br>
                                <div>
                                    <label>Memorial Lots: ${(data.mem_lots || '').toProperCase()}</label>
                                </div>
                                <br>
                                <div>
                                    <label>Memorial Name: ${(data.mem_sts || '').toProperCase()}</label>
                                </div>
                                <br>
                                <div>
                                    <label>Lot Owner: ${(data.LO_name || '').toProperCase()}</label>
                                </div>
                                <br>
                                <div>
                                    <label>Address: ${(data.mem_address || '').toProperCase()}</label>
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

    closePopup.addEventListener('click', function() {
        popup.style.display = 'none';
    });
});
