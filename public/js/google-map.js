function geolocation() {
    if("geolocation" in navigator){
        navigator.geolocation.getCurrentPosition(success, error);

        function success(position) {
            let lat = position.coords.latitude
            let lng = position.coords.longitude
            
            var geolocation = 'https://maps.googleapis.com/maps/api/geocode/json?language=pt-br&key=AIzaSyAnFB0-MM3wedtBe_NWrO_0V7AbvtNuL9s&latlng=' + lat+ ',' + lng;

            $.getJSON(geolocation).done(function(location) {
                console.log(location.results)
                document.querySelector('#search_input').value = location.results[0].address_components[2].long_name;
                document.querySelector('#lat').value = position.coords.latitude;
                document.querySelector('#lng').value = position.coords.longitude;
            })

        }

        function error(err) {
            console.log(err)
        }
    }else{
        alert("We couldn't reach your position") 
    }
}

google.maps.event.addDomListener(window, 'load', geolocation);