@extends('layouts.app')

@section('style-css')
    {{-- load cdn leaflet css --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
        integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
        crossorigin="" />
    <style>
        #map {
            height: 500px;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card rounded">
                    <div class="card-header">Setup Titik Koordinat Peta</div>
                    <div class="card-body">
                        <form action="{{ route('centre-point.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mb-4">
                                <label for="">Lokasi</label>
                                <input type="text" name="location"
                                    class="form-control @error('location') is-invalid @enderror" readonly id="">
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div id="map"></div>
                            <div class="form-group mt-2">
                                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('javascript')
    {{-- load cdn js leaflet --}}
    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"
        integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=="
        crossorigin=""></script>
    <script>
        // Menambah attribut pada leaflet
        var mbAttr = 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, ' +
            'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            mbUrl =
            'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw';

        // membuat beberapa layer untuk tampilan map diantaranya satelit, dark mode, street
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

        // Membuat var map untuk instance object map ke dalam tag div yang mempunyai id map
        // menambahkan titik koordinat latitude dan longitude peta indonesia kedalam opsi center
        // mengatur zoom map dan mengatur layer yang akan digunakan  
        var map = L.map('map', {
            center: [-0.789275,113.921327],
            zoom: 5,
            layers: [streets]
        });

        var baseLayers = {
            //"Grayscale": grayscale,
            "Streets": streets,
            "Satellite" : satellite
        };

        var overlays = {
            "Streets": streets,
            "Satellite": satellite,
        };

        //Menambahkan beberapa layer ke dalam peta/map
        L.control.layers(baseLayers, overlays).addTo(map);

        // set current location / lokasi sekarang dengan koordinat peta indonesia
        var curLocation = [-0.789275,113.921327];
        map.attributionControl.setPrefix(false);

        // set marker map agar bisa di geser
        var marker = new L.marker(curLocation, {
            draggable: 'true',
        });
        map.addLayer(marker);

        // ketika marker di geser kita akan mengambil nilai latitude dan longitude
        // kemudian memasukkan nilai tersebut ke dalam properti input text dengan name-nya location
        marker.on('dragend', function(event) {
            var location = marker.getLatLng();
            marker.setLatLng(location, {
                draggable: 'true',
            }).bindPopup(location).update();

            $('#location').val(location.lat + "," + location.lng).keyup()
        });

        // untuk fungsi di bawah akan mengambil nilai latitude dan longitudenya
        // dengan cara klik lokasi pada map dan secara otomatis marker juga akan ikut bergeser dan nilai
        // latitude dan longitudenya akan muncul pada input text location
        var loc = document.querySelector("[name=location]");
        map.on("click", function(e) {
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;

            if (!marker) {
                marker = L.marker(e.latlng).addTo(map);
            } else {
                marker.setLatLng(e.latlng);
            }
            loc.value = lat + "," + lng;
        });
    </script>
@endpush
