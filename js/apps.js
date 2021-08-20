
 function onlyDecimal(element, decimals)
        {
            $(element).keypress(function(event)
            {
                num = $(this).val() ;
                num = isNaN(num) || num === '' || num === null ? 0.00 : num ;
                if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57))
                {
                    event.preventDefault();

                }
                if($(this).val() == parseFloat(num).toFixed(decimals))
                {
                    event.preventDefault();
                }
            });
        }

function add_object(page,formdata,response) {
 $.ajax({
         url: page,
         type:"POST",
         data:formdata,
         cache: false,
         success: function(data){
                  
                  if(data==1) {
                     load_facilities();
                     $.alert('Confirmed!');
                  }
          }  

  });
}



function load_facilities() {

 $.ajax({
         url: "./loadfacility.php",
         type:"POST",
         cache: false,
         success: function(data){

            $.each(JSON.parse(data), function(i, item) {
              var latlng = new L.LatLng(item.lat,item.lng);
              var custIcon = new L.Icon({iconUrl: 'img/building.png'});
              var marker = new L.marker(latlng).bindTooltip("" + item.manhole + "",{permanent:true,direction:'top'});

              buildings.addLayer(marker);

            });
        }  

});

}

function load_manholes() {

 $.ajax({
         url: "./loadallmh.php",
         type:"POST",
         cache: false,
         success: function(data){
         
            //markersLayer.clearLayers();
            $.each(JSON.parse(data), function(i, item) {

            var latlng = new L.LatLng(item.lat,item.lng);

            var marker = new L.circleMarker(latlng,{color: '#000',
            fillColor: '#ccc',
            fillOpacity: 1,
            radius: 8,
            weight: 2,
            opacity: 1}).bindTooltip("" + item.manhole + "",{permanent:true,direction:'top'});
            
            markersLayer.addLayer(marker);
            map.addLayer(markersLayer);
          });
        }  

});

}


 function load_marker(page,formdata) {

 $.ajax({
         url: page,
         type:"POST",
         data:formdata,
         cache: false,
         success: function(data){
         
            //markersLayer.clearLayers();
            $.each(JSON.parse(data), function(i, item) {

            var latlng = new L.LatLng(item.lat,item.lng);

            var marker = new L.circleMarker(latlng,{color: '#000',
            fillColor: '#ccc',
            fillOpacity: 1,
            radius: 8,
            weight: 2,
            opacity: 1}).bindPopup(item.manhole).openPopup();
            
            markersLayer.addLayer(marker);
            map.addLayer(markersLayer);
            map.flyTo(latlng,17);
          });
        }  

});

}





function load_poly(page,formdata) {
 $.ajax({
         url: page,
         type:"POST",
         data:formdata,
         cache: false,
         success: function(data){
console.log(data);
            $.each(JSON.parse(data), function(i, item) {
              
               var pointa = new L.LatLng(item.lat1,item.lng1);
               var pointb = new L.LatLng(item.lat2,item.lng2);
               var plist = [pointa,pointb];
               var distance = item.distance * 1000;
               var strSearch = $("#txtSearch").val();
               var polyline = new L.polyline(plist).bindTooltip("" + distance.toFixed(2) + "&nbsp;<strong>m</strong>");
               var strcolor = item.color;
               polyline.setStyle({color:strcolor,weight : 8});



                markersLayer.addLayer(polyline);
                map.addLayer(markersLayer);
            });
        }  

  });
}



function load_nearest_pt(page,formdata) {
 $.ajax({
         url: page,
         type:"POST",
         data:formdata,
         cache: false,
         success: function(data){

            //markersLayer.clearLayers();
            $.each(JSON.parse(data), function(i, item) {
            var distance_in_km = item.distance_in_km * 1000;
            var distance = distance_in_km.toFixed(2);
            var latlng = new L.LatLng(item.lat,item.lng);
            var marker = new L.marker(latlng,{icon: greenIcon}).bindPopup("" + item.manhole + "<br/><strong>Distance:</strong>&nbsp;" + distance +"m").openPopup();


            tempLayer.addLayer(marker);
            map.addLayer(tempLayer);

          });
        }  

});

}


function addMarker(e) {
    var templatlng = e.latlng.toString();
    var strlatlng = templatlng.slice(7,-1);
    var newlatlng = strlatlng.split(",");
    strlat = newlatlng[0]; /* store lat to public var */
    strlng = newlatlng[1]; /* store lng to public var */

   // var custIcon = new L.Icon({iconUrl: 'marker2.png'});

    var Marker = L.marker(e.latlng,{
         draggable: false,icon: redIcon}).bindPopup("" + e.latlng + "<br ><a onclick='findNearest();' href='#' style='text-align:center;font-weight:bold;'>Find Nearest manhole</a><br><a onclick='plot_object(" + strlat + ","+ strlng +");' href='#' style='text-align:center;font-weight:bold;'>Save Pin</a>");
    
      tempLayer.addLayer(Marker);
      map.addLayer(tempLayer);
   // Marker.addTo(map);
    map.off('click');
     $('#map').css("cursor","grab");
}

function plot_object(lat,lng) {
 $('#txtlat').val(lat);
 $('#txtlng').val(lng);
 $('#btnOpenAddObj').click();
}


function findNearest() {
  load_nearest_pt("loadnearestmarker.php",{lat : strlat, lng: strlng});
}




function load_legend(page,formdata) {

 $.ajax({
         url: page,
         type:"POST",
         data:formdata,
         cache: false,
         success: function(data){

                 

                  legend.onAdd = function(map) {
  
                  var div = L.DomUtil.create("div", "legend");
                            div.innerHTML += "<h4>Legend</h4>";

                            $.each(JSON.parse(data), function(i, item) {
                              div.innerHTML += '<i style="background:' + item.color + '"></i><span>' + item.name + '</span><br>';
                            });
                            
                  return div;};
                  legend.addTo(map);

        }  

});

}


