//<![CDATA[
function load() {
  var map = new google.maps.Map(document.getElementById("map"), {
    center: new google.maps.LatLng(37.7577,-122.4376),
    zoom: 12,
    mapTypeId: google.maps.MapTypeId.ROADMAP,
  });
  var infoWindow = new google.maps.InfoWindow;

  var bounds = new google.maps.LatLngBounds();

  // Change this depending on the name of your PHP file
  downloadUrl('../others/maps.xml', function(data) {
    var xml = data.responseXML;
    var markers = xml.documentElement.getElementsByTagName("marker");
    for (var i = 0; i < markers.length; i++) {
      var property_id = markers[i].getAttribute("property_id");
      var address = markers[i].getAttribute("address");
      var price = markers[i].getAttribute("price");
      var point = new google.maps.LatLng(
          parseFloat(markers[i].getAttribute("lat")),
          parseFloat(markers[i].getAttribute("lng")));
      bounds.extend(point);
      // var html = "<b>" + address + "<br/>Price: </b>$" + price;
      var html =
          [ '<strong>Address: </strong>' + address + '<br/>',
           '<strong>Price: $' + price + '</strong><br/>',
           '<a href="property.php?PropertyId='+ property_id +'" role="button" class="btn btn-info btn-xs">Details</a>',
           // '<a href="property.php" role="button" class="btn btn-primary btn-xs">Details</a>',
           ].join('\n');
      j = i + 1
      var marker = new google.maps.Marker({
        map: map,
        position: point,
        icon: 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld='+ j +'|FF0000|000000',
      });
      bindInfoWindow(marker, map, infoWindow, html);
    }
    map.fitBounds(bounds);
  });
}

function bindInfoWindow(marker, map, infoWindow, html) {
  google.maps.event.addListener(marker, 'click', function() {
    infoWindow.setContent(html);
    infoWindow.open(map, marker);
  });
}

function downloadUrl(url, callback) {
  var request = window.ActiveXObject ?
      new ActiveXObject('Microsoft.XMLHTTP') :
      new XMLHttpRequest;

  request.onreadystatechange = function() {
    if (request.readyState === 4) {
      request.onreadystatechange = doNothing;
      callback(request, request.status);
    }
  };

  request.open('GET', url, true);
  request.send(null);
}

function doNothing() {}

//]]>

