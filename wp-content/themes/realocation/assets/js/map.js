(function ($) {
    var settings;
    var element;
    var map;
    var markers = new Array();
    var markerCluster;
    var clustersOnMap = new Array();
    var clusterListener;
    var styles = undefined;

    var methods = {
        init: function (options) {
            element = $(this);

            var defaults = $.extend({
                enableGeolocation: false,
                disableClickEvent: false,
                openAllInfoboxes: false,
                pixelOffsetX     : -100,
                pixelOffsetY     : -255
            });

            if (options.styles !== undefined) {
                styles = options.styles;
            }

            settings = $.extend({}, defaults, options);

            google.maps.visualRefresh = true;
            google.maps.event.addDomListener(window, 'load', loadMap);

            if (settings.filterForm && $(settings.filterForm).length !== 0) {
                $(settings.filterForm).submit(function (e) {
                    var form = $(this);
                    var action = $(this).attr('action');
                    $.ajax({
                        type   : 'GET',
                        url    : action,
                        data   : form.serialize(),
                        success: function (data) {
                            data = JSON.parse(data);
                            var decoded_content = [];
                            data.contents.forEach(function(entry) {
                                decoded_content.push(base64_decode(entry));
                            });

                            element.aviators_map('removeMarkers');
                            element.aviators_map('addMarkers', {
                                locations: data.locations,
                                types    : data.types,
                                contents : decoded_content,
                                images : data.images
                            });
                        }
                    });

                    e.preventDefault();
                });
            }


            if (options.callback) {
                options.callback();
            }
            return $(this);
        },

        removeMarkers: function () {
            for (i = 0; i < markers.length; i++) {
                markers[i].infobox.close();
                markers[i].marker.close();
                markers[i].setMap(null);
            }

            markerCluster.clearMarkers();

            $.each(clustersOnMap, function (index, cluster) {
                cluster.cluster.close();
            });

            clusterListener.remove();
        },

        addMarkers: function (options) {
            markers = new Array();
            settings.locations = options.locations;
            settings.contents = options.contents;
            settings.types = options.types;
            settings.images = options.images;

            renderElements();
        }
    }

    $.fn.aviators_map = function (method) {
        // Method calling logic
        if (methods[method]) {
            return methods[ method ].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Method ' + method + ' does not exist on Map');
        }
    };

    function loadMap() {
        var mapOptions = {
            zoom              : settings.zoom,
            mapTypeId         : google.maps.MapTypeId.ROADMAP,
            scrollwheel       : false,
            draggable         : true,
            mapTypeControl    : false,
            panControl        : false,
            zoomControl       : true,
            zoomControlOptions: {
                style   : google.maps.ZoomControlStyle.SMALL,
                position: google.maps.ControlPosition.LEFT_CENTER
            }
        };

        mapOptions.center = new google.maps.LatLng(settings.center.latitude, settings.center.longitude);
        if (settings.enableGeolocation) {
            if (navigator.geolocation) {
                browserSupportFlag = true;
                navigator.geolocation.getCurrentPosition(function (position) {
                    initialLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                    map.setCenter(initialLocation);
                }, function (err) {
                    mapOptions.center = new google.maps.LatLng(settings.center.latitude, settings.center.longitude);
                });
            } else {
                browserSupportFlag = false;
                mapOptions.center = new google.maps.LatLng(settings.center.latitude, settings.center.longitude);
            }
        }

        if (styles != undefined) {
            mapOptions['mapTypeControlOptions'] = {
                mapTypeIds: ['Styled']
            };
            mapOptions['mapTypeId'] = 'Styled';
        }

        map = new google.maps.Map($(element)[0], mapOptions);

        if (settings.mapMoveCenter) {
            map.panBy(settings.mapMoveCenter.x, settings.mapMoveCenter.y)
        }

        if (styles !== undefined) {
            var styledMapType = new google.maps.StyledMapType(styles, { name: 'Styled' });
            map.mapTypes.set('Styled', styledMapType);
        }
        window.map = map;

        var dragFlag = false;
        var start = 0, end = 0;

        function thisTouchStart(e) {
            dragFlag = true;
            start = e.touches[0].pageY;
        }

        function thisTouchEnd() {
            dragFlag = false;
        }

        function thisTouchMove(e) {
            if (!dragFlag) {
                return
            }

            end = e.touches[0].pageY;
            window.scrollBy(0, ( start - end ));
        }
        var el = $(element.selector)[0];

        if (el.addEventListener) {
            el.addEventListener('touchstart', thisTouchStart, true);
            el.addEventListener('touchend', thisTouchEnd, true);
            el.addEventListener('touchmove', thisTouchMove, true);
        } else if (el.attachEvent){
            el.attachEvent('touchstart', thisTouchStart);
            el.attachEvent('touchend', thisTouchEnd);
            el.attachEvent('touchmove', thisTouchMove);
        }

        if (!settings.disableClickEvent) {
            google.maps.event.addListener(map, 'zoom_changed', function () {
                $.each(markers, function (index, marker) {
                    marker.infobox.close();
                    marker.infobox.isOpen = false;
                });
            });
        }

        renderElements();

        $('.infobox .close').click(function () {
            $.each(markers, function (index, marker) {
                marker.infobox.close();
                marker.infobox.isOpen = false;
            });
        });


    }

    function isClusterOnMap(clustersOnMap, cluster) {
        if (cluster === undefined) {
            return false;
        }

        if (clustersOnMap.length == 0) {
            return false;
        }

        var val = false;

        $.each(clustersOnMap, function (index, cluster_on_map) {
            if (cluster_on_map.getCenter() == cluster.getCenter()) {
                val = cluster_on_map;
            }
        });

        return val;
    }

    function addClusterOnMap(cluster) {
        // Hide all cluster's markers
        $.each(cluster.getMarkers(), (function () {
            if (this.marker.isHidden == false) {
                this.marker.isHidden = true;
                this.marker.close();
            }
        }));

        var newCluster = new InfoBox({
            markers               : cluster.getMarkers(),
            draggable             : true,
            content               : '<div class="clusterer"><div class="clusterer-inner">' + cluster.getMarkers().length + '</div></div>',
            disableAutoPan        : true,
            pixelOffset           : new google.maps.Size(-21, -21),
            position              : cluster.getCenter(),
            closeBoxURL           : "",
            isHidden              : false,
            enableEventPropagation: true,
            pane                  : "mapPane"
        });

        cluster.cluster = newCluster;

        cluster.markers = cluster.getMarkers();
        cluster.cluster.open(map, cluster.marker);
        clustersOnMap.push(cluster);
    }

    function renderElements() {

        $.each(settings.locations, function (index, location) {
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(location[0], location[1]),
                map     : map,
                icon    : settings.transparentMarkerImage
            });

            marker.infobox = new InfoBox({
                content               : settings.contents[index],
                disableAutoPan        : false,
                maxWidth              : 0,
                pixelOffset           : new google.maps.Size(settings.pixelOffsetX, settings.pixelOffsetY),
                zIndex                : null,
                closeBoxURL           : "",
                infoBoxClearance      : new google.maps.Size(1, 1),
                position              : new google.maps.LatLng(location[0], location[1]),
                isHidden              : false,
                pane                  : "floatPane",
                enableEventPropagation: false
            });
            marker.infobox.isOpen = false;

            marker.marker = new InfoBox({
                draggable             : true,
                content               : '<div class="marker ' + settings.types[index] + '"><div class="marker-inner">' + settings.images[index] + '</div></div>',
                disableAutoPan        : true,
                pixelOffset           : new google.maps.Size(-24, -50),
                position              : new google.maps.LatLng(location[0], location[1]),
                closeBoxURL           : "",
                isHidden              : false,
                pane                  : "floatPane",
                enableEventPropagation: true
            });
            marker.marker.isHidden = false;
            marker.marker.open(map, marker);
            markers.push(marker);

            if (settings.openAllInfoboxes) {
                marker.infobox.open(map, marker);
                marker.infobox.isOpen = true;
            }

            if (!settings.disableClickEvent) {
                google.maps.event.addListener(marker, 'click', function (e) {
                    var curMarker = this;

                    $.each(markers, function (index, marker) {
                        // if marker is not the clicked marker, close the marker
                        if (marker !== curMarker) {
                            marker.infobox.close();
                            marker.infobox.isOpen = false;
                        }
                    });

                    if (curMarker.infobox.isOpen === false) {
                        curMarker.infobox.open(map, this);
                        curMarker.infobox.isOpen = true;

                        var point1 = map.getProjection().fromLatLngToPoint(curMarker.getPosition());
                        var point2 = new google.maps.Point(
                            ( (typeof(0) == 'number' ? 0 : 0) / Math.pow(2, map.getZoom()) ) || 0,
                            ( (typeof(-140) == 'number' ? -140 : 0) / Math.pow(2, map.getZoom()) ) || 0
                        );

                        map.setCenter(map.getProjection().fromPointToLatLng(new google.maps.Point(
                            point1.x - point2.x,
                            point1.y + point2.y
                        )));
                    } else {
                        curMarker.infobox.close();
                        curMarker.infobox.isOpen = false;
                    }
                });
            }
        });

        markerCluster = new MarkerClusterer(map, markers, {
            gridSize: 50,
            styles: [
                {
                    height   : 48,
                    url      : settings.transparentClusterImage,
                    width    : 48,
                    textColor: 'transparent'
                }
            ]
        });

        clustersOnMap = new Array();

        clusterListener = google.maps.event.addListener(markerCluster, 'clusteringend', function (clusterer) {
            var availableClusters = clusterer.getClusters();
            var activeClusters = new Array();

            $.each(availableClusters, function (index, cluster) {
                if (cluster.getMarkers().length > 1) {
                    activeClusters.push(cluster);
                }
            });

            $.each(availableClusters, function (index, cluster) {
                if (cluster.getMarkers().length > 1) {
                    var val = isClusterOnMap(clustersOnMap, cluster);

                    if (val !== false) {
                        val.cluster.setContent('<div class="clusterer"><div class="clusterer-inner">' + cluster.getMarkers().length + '</div></div>');
                        val.markers = cluster.getMarkers();
                        $.each(cluster.getMarkers(), (function (index, marker) {
                            if (marker.marker.isHidden == false) {
                                marker.marker.isHidden = true;
                                marker.marker.close();
                            }
                        }));
                    } else {
                        addClusterOnMap(cluster);
                    }
                } else {
                    // Show all markers without the cluster
                    $.each(cluster.getMarkers(), function (index, marker) {
                        if (marker.marker.isHidden == true) {
                            marker.marker.open(map, this);
                            marker.marker.isHidden = false;
                        }
                    });

                    // Remove old cluster
                    $.each(clustersOnMap, function (index, cluster_on_map) {
                        if (cluster !== undefined && cluster_on_map !== undefined) {
                            if (cluster_on_map.getCenter() == cluster.getCenter()) {
                                // Show all cluster's markers/
                                cluster_on_map.cluster.close();
                                clustersOnMap.splice(index, 1);
                            }
                        }
                    });
                }
            });

            var newClustersOnMap = new Array();

            $.each(clustersOnMap, function (index, clusterOnMap) {
                var remove = true;

                $.each(availableClusters, function (index2, availableCluster) {
                    if (availableCluster.getCenter() == clusterOnMap.getCenter()) {
                        remove = false;
                    }
                });

                if (!remove) {
                    newClustersOnMap.push(clusterOnMap);
                } else {
                    clusterOnMap.cluster.close();
                }
            });

            clustersOnMap = newClustersOnMap;
        });
    }
})(jQuery);



function base64_decode(data) {
    var b64 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';
    var o1, o2, o3, h1, h2, h3, h4, bits, i = 0,
        ac = 0,
        dec = '',
        tmp_arr = [];

    if (!data) {
        return data;
    }

    data += '';

    do { // unpack four hexets into three octets using index points in b64
        h1 = b64.indexOf(data.charAt(i++));
        h2 = b64.indexOf(data.charAt(i++));
        h3 = b64.indexOf(data.charAt(i++));
        h4 = b64.indexOf(data.charAt(i++));

        bits = h1 << 18 | h2 << 12 | h3 << 6 | h4;

        o1 = bits >> 16 & 0xff;
        o2 = bits >> 8 & 0xff;
        o3 = bits & 0xff;

        if (h3 == 64) {
            tmp_arr[ac++] = String.fromCharCode(o1);
        } else if (h4 == 64) {
            tmp_arr[ac++] = String.fromCharCode(o1, o2);
        } else {
            tmp_arr[ac++] = String.fromCharCode(o1, o2, o3);
        }
    } while (i < data.length);

    dec = tmp_arr.join('');

    return dec.replace(/\0+$/, '');
}