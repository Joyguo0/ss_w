<script type="text/javascript" src="http://maps.google.com/maps/api/js?v=3&sensor=false"></script>

<div id="gmap_canvas" style="height:325px; width:100%;"></div>

<style type="text/css" media="screen">
    .gm-style img {
        max-width:none;
        !important;
        background:none !important;
    }
    .gm-style-iw span {
        height:auto !important;
        display:block;
        white-space:nowrap;
        overflow:hidden !important;
    }
    .gm-style-iw strong {
        font-weight:400;
    }
    .map-data {
        position:absolute;
        top:-1668px;
    }
    .gm-style-iw {
        height:auto !important;
        color:#000000;
        display:block;
        white-space:nowrap;
        width:auto !important;
        line-height:18px;
        overflow:hidden !important;
    }
</style>

<script type="text/javascript">
    function init_map() {
        var myOptions = {
            zoom: 18,
            center: new google.maps.LatLng($getCoordinateLat, $getCoordinateLng),
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            disableDefaultUI: true
        };
        map1 = new google.maps.Map(document.getElementById("gmap_canvas"), myOptions);
        marker1 = new google.maps.Marker({
            map: map1,
            position: new google.maps.LatLng($getCoordinateLat, $getCoordinateLng)
        });
        infowindow = new google.maps.InfoWindow({
            content: "<span style='height:auto !important; display:block; white-space:nowrap; overflow:hidden !important;'>$FullAddress</span>"
        });
        google.maps.event.addListener(marker1, "click", function() {
            infowindow.open(map1, marker1);
        });
        infowindow.open(map1, marker1);
    }
    google.maps.event.addDomListener(window, "load", init_map);
</script>