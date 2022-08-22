<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel - Leaflet</title>

    <link rel="shortcut icon" type="image/x-icon" href="docs/images/favicon.ico" />

    {{-- Pada view map.blade ini kita menambahkan beberapa cdn diantaranya
    bootstrap, leaflet css dan js, leaflet control search css dan js --}}
    
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
        integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
        crossorigin="" />

    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"
        integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=="
        crossorigin="">
    </script>

     {{-- cdn leaflet search --}}
     <link rel="stylesheet" href="https://labs.easyblog.it/maps/leaflet-search/src/leaflet-search.css">
     <script src="https://labs.easyblog.it/maps/leaflet-search/src/leaflet-search.js"></script>
    

    <style>
        html,
        body {
            height: 100%;
            margin: 0;
        }

        .leaflet-container {
            height: 400px;
            width: 600px;
            max-width: 100%;
            max-height: 100%;
        }

    </style>

    <style>
        body {
            padding: 0;
            margin: 0;
        }

        #map {
            height: 100%;
            width: 100vw;
        }

    </style>
</head>

<body>
    <div id="map"></div>
    <script>
       
        var mbAttr = 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, ' +
            'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            mbUrl =
            'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw';

        var satellite = L.tileLayer(mbUrl, {
                id: 'mapbox/satellite-v9',
                tileSize: 512,
                zoomOffset: -1,
                attribution: mbAttr
            }),
            dark = L.tileLayer(mbUrl, {
                id: 'mapbox/dark-v10',
                tileSize: 512,
                zoomOffset: -1,
                attribution: mbAttr
            }),
            streets = L.tileLayer(mbUrl, {
                id: 'mapbox/streets-v11',
                tileSize: 512,
                zoomOffset: -1,
                attribution: mbAttr
            });

        var map = L.map('map', {
                       
            center: [{{ $centrePoint->location }}],
            zoom: 5,
            layers: [streets]
        });

        var baseLayers = {
            "Grayscale": dark,
            "Satellite": satellite,
            "Streets": streets
        };

        var overlays = {
            "Streets": streets,
            "Grayscale": dark,
            "Satellite": satellite,
        };

        // Menampilkan popup data ketika marker di klik 
        @foreach ($spaces as $item)
            L.marker([{{ $item->location }}])
                .bindPopup(
                    "<div class='my-2'><img src='{{ $item->getImage() }}' class='img-fluid' width='700px'></div>" +
                    "<div class='my-2'><strong>Nama Space:</strong> <br>{{ $item->name }}</div>" + 
                    "<div><a href='{{ route('map.show', $item->slug) }}' class='btn btn-outline-info btn-sm'>Detail Space</a></div>" +
                    "<div class='my-2'></div>"
                ).addTo(map);
        @endforeach
    
        var datas = [    
        @foreach ($spaces as $key => $value) 
            {"loc":[{{$value->location }}], "title": '{!! $value->name !!}'},
        @endforeach            
        ];

        // pada koding ini kita menambahkan control pencarian data        
        var markersLayer = new L.LayerGroup();
        map.addLayer(markersLayer);
        var controlSearch = new L.Control.Search({
            position:'topleft',
            layer: markersLayer,
            initial: false,
            zoom: 17,
            markerLocation: true
        })

    
    //menambahkan variabel controlsearch pada addControl
       map.addControl( controlSearch );

        // looping variabel datas utuk menampilkan data space ketika melakukan pencarian data
        for(i in datas) {
          
            var title = datas[i].title,	
                loc = datas[i].loc,		
                marker = new L.Marker(new L.latLng(loc), {title: title} );
            markersLayer.addLayer(marker);

            // melakukan looping data untuk memunculkan popup dari space yang dipilih
            @foreach ($spaces as $item)
            L.marker([{{ $item->location }}]
                )
                .bindPopup(
                    "<div class='my-2'><img src='{{ $item->getImage() }}' class='img-fluid' width='700px'></div>" +
                    "<div class='my-2'><strong>Nama Spot:</strong> <br>{{ $item->name }}</div>" +
                    "<a href='{{ route('map.show', $item->slug) }}' class='btn btn-outline-info btn-sm'>Detail Spot</a></div>" +
                    "<div class='my-2'></div>"
                ).addTo(map);
            @endforeach
        }
        L.control.layers(baseLayers, overlays).addTo(map);
    </script>
</body>

</html>
