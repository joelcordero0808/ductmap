<?php
require('../vendor/autoload.php');
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
   integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
   crossorigin=""/>


<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
   integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
   crossorigin=""></script>
   
<!-- Map -->
<script src='https://kit.fontawesome.com/a076d05399.js'></script>
<!-- polyine measure -->
<link rel="stylesheet" type="text/css" href="https://ppete2.github.io/Leaflet.PolylineMeasure/Leaflet.PolylineMeasure.css">
<script type="text/javascript" src="https://ppete2.github.io/Leaflet.PolylineMeasure/Leaflet.PolylineMeasure.js"></script>
<!-- polyine measure -->

<!-- custom control  -->
<script type="text/javascript" src="js/Leaflet.Control.Custom.js"></script>
<!-- custom control -->

<script type="text/javascript" src="js/leaflet-color-markers.js"></script> <!-- colored marker -->




<script type="text/javascript" src="js/apps.js"></script>

<!-- Bootstrap -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous" defer></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous" defer></script>

<!-- JQ confirm -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<!-- JQ confirm -->

<!-- Bootstrap -->
<link rel="stylesheet" type="text/css" href="css/style.css">

<!-- Easybutton -->
<link rel="stylesheet" href="easybutton/easy-button.css">
<script src="easybutton/easy-button.js"></script>
<!-- Easybutton -->

<style type="text/css">
  /*Legend specific*/
.legend {
  padding: 6px 8px;
  font: 14px Arial, Helvetica, sans-serif;
  background: white;
  background: rgba(255, 255, 255, 0.8);
  /*box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);*/
  /*border-radius: 5px;*/
  line-height: 24px;
  color: #555;
}
.legend h4 {
  text-align: center;
  font-size: 16px;
  margin: 2px 12px 8px;
  color: #777;
  font-weight: bolder;
}

.legend span {
  position: relative;
  bottom: 3px;
}

.legend i {
  width: 18px;
  height: 18px;
  float: left;
  margin: 0 8px 0 0;
  opacity: 0.7;
}

.legend i.icon {
  background-size: 18px;
  background-color: rgba(255, 255, 255, 1);
}

</style>

<script type="text/javascript">
  $(document).ready(function() {
   load_facilities();

   onlyDecimal("#txtlat", 6);
   onlyDecimal("#txtlng", 6) ;

   $('.coordinates').bind('cut copy paste', function(e) {
    e.preventDefault();
    alert("Cut / Copy / Paste Disabled");
});
  });
</script>

<script type="text/javascript">
 $(function(){

   var ctrlloc,measure,strlat,strlng,strSearch;
   var windowObjectReference;
   var windowFeatures = "menubar=no,location=yes,resizable=0,scrollbars=0,status=yes,width=800,height=400";

function openRequestedPopup(url,title) {
  windowObjectReference = window.open(url, title, windowFeatures);
}


  $("#txtSearch").keyup(function() {
    $(this).val($(this).val().toUpperCase());
  });

  $("#txtSearch").keyup(function(e) {
    if(e.which == 13) {
      e.preventDefault();
      $("#btngo").trigger("click");
     
    }
  });
   
   $("#btngo").click(function() {
       
       markersLayer.clearLayers();

        legend.remove(map);

       var strSearch = $("#txtSearch").val();

       var strPrefix = strSearch.substring(0,2); //get db or cb 

       if (strPrefix=="DB" || strPrefix=="SS" || strPrefix=="CB") {
                 load_poly("loadpolyline.php",{ name : strSearch }); //load polyline
                 load_marker("loadmarker.php",{ name : strSearch }); //load marker
                 load_legend("loadlegend.php",{ name : strSearch })
       } else {
                 load_marker("loadmarker.php",{ name : strSearch }); //load marker
       }


   });



   $('#btn_find_nearest').click(function() {
     findNearest(); 
   });

   $('#btnduct').click(function() {
    openRequestedPopup("duct.php","Add Duct");
   });

    $('#btnObjSave').click(function() {
      var txtname = $('#txtname').val();
      var txtlat = $('#txtlat').val();
      var txtlng = $('#txtlng').val();
      var optType = $('#optType').children("option:selected").val();
      var txtDesc = $('#txtDesc').val();

      
      $.confirm({
                   title: 'Confirm',
                   content: 'This cannot be undone.',
                   buttons: {
                               confirm: function () {

                                add_object("add_object.php",{name : txtname,lat : txtlat,lng : txtlng,type : optType});

                                  $('#txtname').val("");
                                  $('#txtlat').val("");
                                  $('#txtlng').val("");
                                  $('#txtDesc').val("");
                                  
                            },
                               cancel: function () {
                                  $.alert('Canceled!');
                                  
                            }
                         }
                });

      
    });

   



});
</script>


<title>Home</title>
</head>

<body>
 <nav class="navbar navbar-fixed-top navbar-inverse p-0" style="background-color: #25215c;">
     <form class="form-inline mx-2" onsubmit="return false;"> 
        <div class="btn-toolbar mr-auto" role="toolbar">
          <div class="btn-group btn-group-sm mr-2" role="group">
            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#myModal"><i class="fa fa-bars fa-fw"></i></button>
          </div>
          <div class="input-group input-group-sm">
            <input type="text" autocomplete="off" class="form-control" id="txtSearch" style="border:1px solid #adadad;" placeholder="Search..." aria-describedby="btnGroupAddon">
            <button class="btn btn-secondary input-group-addon" id="btngo" type="button"><i class="fa fa-search fa-fw"></i></button>
          </div>
        </div>
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" data-target="#accountmenu"><span class="hidden-sm-down mr-2"><?php /*echo $user;*/ ?></span><i class="fa fa-user"></i></a>
          <div id="accountmenu" class="dropdown">
          <div class="dropdown-menu dropdown-menu-right p-0">
            <div class="card">
              <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                  <li class="nav-item">
                    <a class="nav-link active" href="#">Active</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link disabled" href="#">Disabled</a>
                  </li>
                </ul>
              </div>
              <div class="card-block">
                <h4 class="card-title">Special title treatment</h4>
                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
              </div>
            </div>
          </div>
          </div>
        </li>
      </ul>
    </form>
     </nav>
    <!-- Broken Nav -->
    <!-- Modal Sidebar -->
    <div class="modal left fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog">
        <div class="modal-content">
          <div id="SideMenu">
            <div class="card">
              <div class="card-header btn btn-default mh1" data-toggle="collapse" data-target="#MenuLayers" data-parent="#SideMenu">
                <i class="fa fa-map fa-fw"></i>&nbsp;Details
              </div>
              <div id="MenuLayers" class="collapse show">
                <div class="card-block list-group mg1">
                  <button type="button" id="btn_cmh_detail" class="list-group-item list-group-item-action"><i class="fa fa-question fa-fw"></i>&nbsp;Details</button>
                  <div id="trView"></div>
                </div>
              </div>
            </div>
            <div class="card">
              <div class="card-header btn btn-default mh1" data-toggle="collapse" data-target="#MenuTools" data-parent="#SideMenu">
                <i class="fa fa-wrench fa-fw"></i>&nbsp;Tools
              </div>
              <div id="MenuTools" class="collapse">
                <div class="card-block list-group mg1">
                  <button type="button" class="list-group-item list-group-item-action"><i class="fa fa-question fa-fw"></i>&nbsp;Any tools</button>
        
                </div>
              </div>
            </div>
            <div class="card">
              <div class="card-header btn btn-default mh1" data-toggle="collapse" data-target="#MenuSettings" data-parent="#SideMenu">
                <i class="fa fa-cog fa-fw"></i>&nbsp;Manage
              </div>
              <div id="MenuSettings" class="collapse">
                <div class="card-block list-group mg1">
                  <button type="button" id="btnOpenAddObj" class="list-group-item list-group-item-action" data-target="#AddObject" data-toggle="modal"><i class="fa fa-plus fa-fw"></i>&nbsp;Add object</button>
                  <button type="button" id="btnduct" class="list-group-item list-group-item-action"><i class="fas fa-route fa-fw"></i>&nbsp;Add duct</button>
                  <button type="button" class="list-group-item list-group-item-action"><i class="fa fa-user-plus fa-fw"></i>&nbsp;Add users</button>
                </div>
              </div>
            </div>
          </div>
        </div><!-- modal-content -->
      </div><!-- modal-dialog -->
    </div><!-- modal -->


    <!-- Modal add object -->
    <!-- Modal -->
<div class="modal fade" id="AddObject" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalLabel">Add Object</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <!-- Form -->
       <form>
  <div class="form-group">
    <label for="txtname">Name:</label>
    <input type="input" class="form-control" id="txtname" placeholder="Name of object...">
  </div>
  <div class="form-group">
    <label for="txtlat">Latitude:</label>
    <input type="input" class="form-control coordinates"  id="txtlat" placeholder="Latitude...">
  </div>
   <div class="form-group">
    <label for="txtlng">Longhitude:</label>
    <input type="input" class="form-control coordinates" id="txtlng" placeholder="Longhitude...">
  </div>

  <div class="form-group">
    <label for="optType">Type:</label>
    <select class="form-control" id="optType">
      <option value="1">Duct Bank</option>
      <option value="2">Building</option>
    </select>
  </div>
  <div class="form-group">
    <label for="txtDesc">Description</label>
    <textarea class="form-control" id="txtDesc" rows="3"></textarea>
  </div>
</form>
<!-- Form -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="btnObjSave" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
    <!-- Modal add object -->

  
    
    <div id="map"></div>
    <div id="statusbar"></div>


<script type="text/javascript">

var markersLayer = new L.LayerGroup();
var buildings = new L.LayerGroup();
var tempLayer = new L.LayerGroup();
var stateChangingButton;



var streets = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '&copy; HIA Network'}),
    satellite =  L.tileLayer('http://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        attribution: '&copy; HIA Network'});


var legend = L.control({ position: "bottomright",opacity : 1});


    var map = L.map('map', {
        center: [25.265602, 51.611726],
        zoom: 13,
        layers: [streets]
    });

    var baseMaps = {
      "Streets" : streets,
      "Satellite" : satellite
    };

    var overlayMaps = {
       "HIA Facilities": buildings
    };


    L.control.layers(baseMaps,overlayMaps).addTo(map);
  
  /* Scale */
   ctrlloc = new L.control.scale({maxWidth:240, metric:true, imperial:false, position: 'bottomleft'}).addTo(map);
   /* Scale */

/* Polyline measure */
    measure = new L.control.polylineMeasure ({position:'topleft', unit:'metres', showBearings:true, clearMeasurementsOnStop: true, showClearControl: true, showUnitControl: true}).addTo(map);
  /* Polyline measure */



   stateChangingButton = L.easyButton({
    states: [{
            stateName: 'place-marker',        // name the state
            icon:      'fa-map-marker',               // and define its properties
            title:     'Place Marker',      // like its title
            onClick: function(btn, map) {       // and its callback
                  map.on('click', addMarker)
                  $('#map').css("cursor","crosshair");
                  tempLayer.clearLayers();
                  btn.state('remove-marker');
            }
        }, {
            stateName: 'remove-marker',
            icon:      'fa-undo',
            title:     'Clear',
            onClick: function(btn, map) {
                 tempLayer.clearLayers();
                 map.off('click');
                 $('#map').css("cursor","grab");
                 btn.state('place-marker');
            }
    }]
});

stateChangingButton.addTo(map);


</script>




</body>

</html>
