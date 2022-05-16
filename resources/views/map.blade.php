<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel - Leaflet</title>

    <link rel="shortcut icon" type="image/x-icon" href="docs/images/favicon.ico" />

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
        integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
        crossorigin="" />

    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"
        integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=="
        crossorigin=""></script>
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
        var map = L.map('map').fitWorld().setView([{{ $centrePoint->location }}], 13);

        var tiles = L.tileLayer(
            'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
                maxZoom: 18,
                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, ' +
                    'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                id: 'mapbox/streets-v11',
                tileSize: 512,
                zoomOffset: -1
            }).addTo(map);

        @foreach ($spaces as $item)
            L.marker([{{ $item->location }}])
                .bindPopup(
                    "<div class='my-2'><img src='{{ asset('/uploads/imgCover/' . $item->image) }}' class='img-fluid' width='700px'></div>" +
                    "<div class='my-2'><strong>Nama Space:</strong> <br>{{ $item->name }}</div>" +
                    
                    "<div class='my-2'><strong>Kategori Space:</strong> </div>" +
                    @foreach ($item->getCategory as $itemCategory)
                        "  {{ $itemCategory->name }}" +
                    @endforeach

                    "<div><a href='{{ route('map.show', $item->slug) }}' class='btn btn-outline-info btn-sm'>Detail Space</a></div>" +
                    "<div class='my-2'></div>"

                ).addTo(map);
        @endforeach

        var popup = L.popup()
            .setLatLng([{{ $centrePoint->location }}])
            .setContent('I am a standalone popup.');

        function onMapClick(e) {
            popup
                .setLatLng(e.latlng)
                .setContent('You clicked the map at ' + e.latlng.toString())
                .openOn(map);
        }

        map.on('click', onMapClick);
    </script>
</body>

</html>
