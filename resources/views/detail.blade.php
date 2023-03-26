<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.1/dist/leaflet.css"
        integrity="sha256-sA+zWATbFveLLNqWO2gtiw3HL/lh1giY/Inf1BJ0z14=" crossorigin="" />

    <script src="https://unpkg.com/leaflet@1.9.1/dist/leaflet.js"
        integrity="sha256-NDI0K41gVbWqfkkaHj15IzU7PtMoelkzyKp8TOaFQ3s=" crossorigin=""></script>

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
</head>

<body>
    <div class="container py-4 justify-content-center">
        <div class="row">
            <div class="col-md-6 col-xs-6 mb-2">
                <div class="card">
                    <div class="card-body">
                        <p>
                        <h4><strong>Nama Space :</strong></h4>
                        <h5>{{ $spaces->name }}</h5>
                        </p>

                        <p>
                        <h4><strong>Keterangan Space :</strong></h4>
                        <p>{{ $spaces->content }}</p>
                        </p>

                        <p>
                        <h4>
                            <strong>Foto</strong>
                        </h4>
                        <img class="img-fluid" width="200" src="{{ $spaces->getImage() }}"
                            alt="">
                        </p>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('map.index') }}" class="btn btn-outline-primary">Kembali</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xs-6">
                <div class="card">
                    <div class="card-body">
                        <div id="map"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- karena hanya akan menampilkan single data dari marker yang dipilih jadi kita tidak 
    melakukan looping untuk halaman detail ini --}}
    <script>
        var mbAttr = 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, ' +
            'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            mbUrl =
            'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiZXJpcHJhdGFtYSIsImEiOiJjbGZubmdib3UwbnRxM3Bya3M1NGE4OHRsIn0.oxYqbBbaBwx0dHLguu5gOA';

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


        var data{{ $spaces->id }} = L.layerGroup()

        var map = L.map('map', {
            center: [{{ $spaces->location }}],
            zoom: 20,
            fullscreenControl: {
                pseudoFullscreen: false
            },
            layers: [streets, data{{ $spaces->id }}]
        });

        var baseLayers = {
            "Streets": streets,
            "Satellite": satellite,
            "Dark": dark,
        };

        var overlays = {
            //"Streets": streets
            "{{ $spaces->name }}": data{{ $spaces->id }},
        };

        L.control.layers(baseLayers, overlays).addTo(map);


        var curLocation = [{{ $spaces->location }}];
        map.attributionControl.setPrefix(false);

        var marker = new L.marker(curLocation, {
            draggable: 'false',
        });
        map.addLayer(marker);
    </script>
</body>

</html>
