
/* Notice that we are setting the function to call when submit is selected */
window.onload=myMap;

function myMap() {
    var mapProp= {
        center:new google.maps.LatLng(38.986822,-76.942576),
        zoom:15,
        disableDefaultUI: true
    };
    
    var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);
                        
           
    //adds the location marker and animation   
    var marker = new google.maps.Marker({
        position: mapProp.center,
        animation: google.maps.Animation.BOUNCE
    });
    
    marker.setMap(map);
}


