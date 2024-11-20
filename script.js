

        window.onload = function() {
            var img = document.getElementById('responsiveImage');
            var map = document.getElementById('mymap');
            var originalWidth = img.naturalWidth;

            function adjustCoords() {
                var currentWidth = img.clientWidth;
                var scale = currentWidth / originalWidth;

                Array.from(map.areas).forEach(function(area) {
                    var coords = area.coords.split(',').map(function(coord) {
                        return Math.round(coord * scale);
                    });
                    area.coords = coords.join(',');
                });
            }

            adjustCoords();
            window.onresize = adjustCoords;
        };

        document.addEventListener('DOMContentLoaded', function() {
            var popup = document.getElementById('popup');
            var trigger = document.getElementById('triggerPopup');
            var closeButton = document.getElementById('closePopup');
            var image = document.getElementById('responsiveImage');

            trigger.addEventListener('click', function(event) {
                event.preventDefault();
                popup.style.display = 'block';
                image.classList.add('blur');
            });

            closeButton.addEventListener('click', function() {
                popup.style.display = 'none';
                image.classList.remove('blur');
            });

            document.addEventListener('click', function(event) {
                if (!popup.contains(event.target) && event.target !== trigger) {
                    popup.style.display = 'none';
                    image.classList.remove('blur');
                }
            });
        });
        

       