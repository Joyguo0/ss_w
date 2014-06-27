;

var CurrentActiveStore;


jQuery(function($) {
    $("#search-results").hide();

    /**
     * Hardcoded co-ordinates and zoom levels of Australia.
     */
    var ausPoint = new google.maps.LatLng(-25.2743980, 133.7751360);
    var ausZoom = 3;


    /**
     * Initialise the map
     */
    var mobile = document.getElementById('store-locator-map-mobile');

    if (mobile) {
        var map = new google.maps.Map(
            document.getElementById('store-locator-map-mobile'), {
                zoom: ausZoom,
                center: ausPoint,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            }
        );
    } else {
        var map = new google.maps.Map(
            document.getElementById('store-locator-map'), {
                zoom: ausZoom,
                center: ausPoint,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            }
        );
    }

    /**
     * Adds markers to the map from a set of elements.
     */
    var cluster;

    var addMarkers = function(set) {
        var markers = [];

        $.each(set, function(i, el) {
            var id = $(el).attr('data-id');
            var lat = $(el).attr('data-lat');
            var lng = $(el).attr('data-lng');

            var info = new google.maps.InfoWindow({
                content: $('h4', el).html(),
                maxWidth: 200
            });

            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(lat, lng)
            });

            google.maps.event.addListener(marker, 'click', function() {
                info.open(map, marker);
            });

            markers.push(marker);
        });

        cluster = new MarkerClusterer(map, markers, {
            maxZoom: 9
        });
    }

    /**
     * Fits the map to fit around an array of markers.
     */
    var fitMap = function(points) {
        var bounds = new google.maps.LatLngBounds();

        $.each(points, function(i, marker) {
            bounds.extend(marker.getPosition());
        });

        map.fitBounds(bounds);

        if (points.length == 1) {
            map.setZoom(18);
        }

    }


    addMarkers($('#search-results .store'));


    //redirect to suburb page-------------------------------------
    $("#search-suburb-form-notajax input[type=checkbox]").each(function() {
        $(this).click(function() {
            if ($(this).val()) {
                $("#search-suburb-form-notajax").submit();
            }
        });
    });
    $("#search-suburb-form-notajax select").change(function() {
        $("#search-suburb-form-notajax").submit();
    });
    //redirect to suburb page end---------------------------------

    $("#search-suburb-form input[type=checkbox]").each(function() {
        $(this).click(function() {
            if ($(this).val()) {
                $("#search-suburb-form").submit();
            }
        });
    });


    $('#select-state').change(function() {
        if ($(this).val()) {
            $("#search-suburb-form").submit();
        }
    });



    /**
     * Autocompleting suburb search.
     */
    $('#search-suburb-form #suburb').each(function() {
        $(this).autocomplete({
            source: $(this).attr('data-source'),
            minLength: 3,
            select: function(e, ui) {
                var form = $('#search-suburb-form');

                $('#search-suburb-form #suburb').val(ui.item.label);
                //$('#search-suburb-form #suburb-val').val(ui.item.value);

                //$('#state-list, #all-stores').hide();
                //$('#search-results').empty().show().addClass('loading');

                $.ajax({
                    url: form.attr('action'),
                    data: form.serialize(),
                    success: function(data) {
                        $('#search-results').html(data);

                        cluster.clearMarkers();
                        addMarkers($('#search-results .store'));
                        fitMap(cluster.getMarkers());
                    },
                    error: function(xhr) {
                        alert(xhr.statusText);
                    }
                });

                //$(this).val('')
                return false;
            },
            focus: function(e, ui) {
                $('#suburb').val(ui.item.label);
                return false;
            }
        });
    });
    $('#search-suburb-form').submit(function() {

        var form = $(this);

        if ($('input#suburb').val() == "")
            $('input#suburb-val').val("");

        $('#state-list, #all-branches').hide();
        $('#search-results').empty().show().addClass('loading');

        $.ajax({
            url: form.attr('action'),
            data: form.serialize(),
            success: function(data) {
                $('#search-results').html(data);

                cluster.clearMarkers();
                addMarkers($('#search-results .store'));

                var cArr = cluster.getMarkers();


                if (cArr.length > 0) {
                    fitMap(cluster.getMarkers());
                } else {
                    map.setCenter(ausPoint);
                    map.setZoom(ausZoom);
                }
            },
            error: function(xhr) {
                alert(xhr.statusText);
            }
        });
        return false;
    });





    /**
     * Reset the map button.
     */
    $('#reset-map').click(function() {
        map.setCenter(ausPoint);
        map.setZoom(ausZoom);

        $('#all-stores, #search-results').hide();
        $('#state-list').show();

        cluster.clearMarkers();
        addMarkers($('#all-stores .store'));

        return false;
    });

    $('a#reset-map').click(function() {
        map.setCenter(ausPoint);
        map.setZoom(ausZoom);

        $('#all-stores, #search-results').hide();
        $('#state-list').show();

        cluster.clearMarkers();
        addMarkers($('#all-stores .store'));

        return false;
    });

    /**
     * Shows a help dialog.
     */
    $('#map-help').click(function() {
        $('#map-help-content').dialog({
            title: 'Map Help',
            height: 380,
            width: 550,
            modal: true,
            draggable: false,
            resizable: false
        });
        return false;
    });


    $('#search-results .store').livequery('click', function() {
        var storeDOM = $(this),
            resultDIV = $('#find-store .store-details');

        //css active class
        if (CurrentActiveStore) {
            CurrentActiveStore.removeClass('active');
        }
        CurrentActiveStore = storeDOM;
        storeDOM.addClass('active');

        resultDIV.html('LOADING...');

        //ajax get store details html data
        $.ajax({
            url: $('#current_link').val(),
            data: 'store_id=' + storeDOM.attr('data-id'),
            success: function(data) {

                resultDIV.html(data);

                cluster.clearMarkers();

                addMarkers(storeDOM);

                var cArr = cluster.getMarkers();

                if (cArr.length > 0) {

                    //set location
                    fitMap(cluster.getMarkers());

                } else {

                    //centre au map if there is no location details
                    map.setCenter(ausPoint);
                    map.setZoom(ausZoom);

                }
            },
            error: function(xhr) {
                alert(xhr.statusText);
            }
        });
    });
});
