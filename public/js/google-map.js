function geolocation() {
    if("geolocation" in navigator){
        navigator.geolocation.getCurrentPosition(success, error);

        function success(position) {
            let lat = position.coords.latitude
            let lng = position.coords.longitude
            
            var geolocation = 'https://maps.googleapis.com/maps/api/geocode/json?language=pt-br&key=AIzaSyAnFB0-MM3wedtBe_NWrO_0V7AbvtNuL9s&latlng=' + lat+ ',' + lng;

            $.getJSON(geolocation).done(function(location) {
                console.log(location.results)
                // document.querySelector('#country').html(location.results[0].address_components[5].long_name);
                // document.querySelector('#state').html(location.results[0].address_components[4].long_name);
                document.querySelector('#search_input').value = location.results[0].address_components[2].long_name;
                // document.querySelector('#address').html(location.results[0].formatted_address);
                // document.querySelector('#latitude').html(position.coords.latitude);
                // document.querySelector('#longitude').html(position.coords.longitude);
            })

        }

        function error(err) {
            console.log(err)
        }
    }else{
        alert("We couldn't reach your position") 
    }
}

// google.maps.event.addDomListener(window, 'load', geolocation);