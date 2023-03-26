@extends('layouts.app')

@section('style-css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
        integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
        crossorigin="" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        #map {
            height: 500px;
        }

    </style>
@endsection


{{-- Pada view create.blade space ini kita kan menginput beberapa data yaitu 
nama space (tempat), deskripsi, gambar jika di perlukan, dan titik koordinat lokasi
Untuk cdn yang kita muat disini hampir sama dengan form create pada file view create centrepoint

--}}

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card rounded">
                    <div class="card-header">Tambah Space</div>
                    <div class="card-body">
                        {{-- action form yang mengarah ke route space.store untuk proses penyimpanan data --}}
                        <form action="{{ route('space.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="">Nama space</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Foto space</label><br>
                                <img id="previewImage" class="mb-2" src="#" width="100%" alt="">
                                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                                    id="image">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="">Deskripsi</label>
                                <textarea name="content" class="form-control @error('content')
                                    is-invalid
                                @enderror" id="" cols="30" rows="10" placeholder="Deskripsi"></textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Lokasi</label>
                                <input type="text" name="location"
                                    class="form-control @error('location') is-invalid @enderror" readonly id="">
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div id="map"></div>
                            <div class="form-group mt-3">
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
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"
        integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=="
        crossorigin=""></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <script>

        // fungsi ini akan berjalan ketika akan menambahkan gambar dimana fungsi ini
        // akan membuat preview image sebelum kita simpan gambar tersebut.      
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#previewImage').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        // Ketika tag input file denghan class image di klik akan menjalankan fungsi di atas
        $("#image").change(function() {
            readURL(this);
        });

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


        var map = L.map('map', {
            // titik koordinat disini kita dapatkan dari tabel centrepoint tepatnya dari field location
            // yang sebelumnya sudah kita tambahkan jadi lokasi map yang akan muncul  sesuai dengan tabel
            // centrepoint
            center: [{{ $centrepoint->location }}],
            zoom: 14,
            layers: [streets]
        });

        var baseLayers = {
            //"Grayscale": grayscale,
            "Streets": streets,
            "Satellite": satellite
        };

        var overlays = {
            "Streets": streets,
            "Satellite": satellite,
        };

        L.control.layers(baseLayers, overlays).addTo(map);

        // Begitu juga dengan curLocation titik koordinatnya dari tabel centrepoint
        // lalu kita masukkan curLocation tersebut ke dalam variabel marker untuk menampilkan marker
        // pada peta.

        var curLocation = [{{ $centrepoint->location }}];
        map.attributionControl.setPrefix(false);

        var marker = new L.marker(curLocation, {
            draggable: 'true',
        });
        map.addLayer(marker);

        marker.on('dragend', function(event) {
            var location = marker.getLatLng();
            marker.setLatLng(location, {
                draggable: 'true',
            }).bindPopup(location).update();

            $('#location').val(location.lat + "," + location.lng).keyup()
        });

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
