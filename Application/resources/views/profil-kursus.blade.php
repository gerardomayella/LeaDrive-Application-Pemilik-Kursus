@extends('layouts.base')

@push('styles')
    <style>
        #map {
            height: 300px;
            width: 100%;
            border-radius: 8px;
            margin-bottom: 1rem;
            border: 1px solid #334155;
        }

        .map-container {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .map-search {
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 1000;
            width: calc(100% - 40px);
            max-width: 400px;
        }

        .map-search input {
            width: 100%;
            padding: 10px 15px;
            border-radius: 4px;
            border: 1px solid #444;
            background-color: #333;
            color: #fff;
            font-size: 14px;
        }

        .location-coordinates {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .location-coordinates .form-group {
            flex: 1;
            margin-bottom: 0;
        }

        .form-group input[readonly] {
            background-color: #1f2937 !important;
            color: #9ca3af !important;
            cursor: not-allowed;
        }
    </style>
@endpush

@section('content')
<div class="container">
    <h1 style="margin:0 0 16px 0;font-size:20px;font-weight:600;color:#e5e7eb">Profil Kursus</h1>

    @if ($errors->any())
        <div style="background:#432;color:#fca5a5;padding:12px 14px;border-radius:8px;margin-bottom:12px">
            <ul style="margin:0;padding-left:16px">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div style="background:#16321f;color:#86efac;padding:12px 14px;border-radius:8px;margin-bottom:12px">{{ session('success') }}</div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" style="display:grid;gap:14px;max-width:720px">
        @csrf
        @method('PUT')

        <div style="display:flex;gap:16px;align-items:center">
            <div>
                @php $pf = $kursus->foto_profil ?? null; @endphp
                <img src="{{ $pf ?: asset('images/logo.jpg') }}" alt="Foto Profil" style="width:72px;height:72px;border-radius:50%;object-fit:cover;border:1px solid rgba(255,255,255,0.2)">
            </div>
            <div style="flex:1">
                <label for="foto_profil" style="display:block;margin-bottom:6px;color:#9ca3af">Foto Profil</label>
                <input type="file" id="foto_profil" name="foto_profil" accept="image/*" style="width:100%;background:#0f172a;border:1px solid #334155;color:#e5e7eb;border-radius:8px;padding:10px" />
            </div>
        </div>

        <div>
            <label for="nama_kursus" style="display:block;margin-bottom:6px;color:#9ca3af">Nama Kursus</label>
            <input type="text" id="nama_kursus" name="nama_kursus" value="{{ old('nama_kursus', $kursus->nama_kursus) }}" required style="width:100%;background:#0f172a;border:1px solid #334155;color:#e5e7eb;border-radius:8px;padding:10px" />
        </div>

        <div class="form-group">
            <label for="lokasi" style="display:block;margin-bottom:6px;color:#9ca3af">Lokasi</label>
            <div class="map-container">
                <div class="map-search">
                    <input type="text" id="search-box" placeholder="Cari lokasi...">
                </div>
                <div id="map"></div>
            </div>
            <div class="location-coordinates">
                <div class="form-group">
                    <label for="latitude">Latitude <span style="color:#f87171">*</span></label>
                    <input type="text" id="latitude" name="latitude" value="{{ old('latitude', $kursus->latitude) }}" required readonly style="width:100%;background:#0f172a;border:1px solid #334155;color:#e5e7eb;border-radius:8px;padding:10px" />
                </div>
                <div class="form-group">
                    <label for="longitude">Longitude <span style="color:#f87171">*</span></label>
                    <input type="text" id="longitude" name="longitude" value="{{ old('longitude', $kursus->longitude) }}" required readonly style="width:100%;background:#0f172a;border:1px solid #334155;color:#e5e7eb;border-radius:8px;padding:10px" />
                </div>
            </div>
            <div class="form-group">
                <label for="lokasi">Alamat Lengkap <span style="color:#f87171">*</span></label>
                <textarea id="lokasi" name="lokasi" required style="width:100%;background:#0f172a;border:1px solid #334155;color:#e5e7eb;border-radius:8px;padding:10px;min-height:80px">{{ old('lokasi', $kursus->lokasi) }}</textarea>
            </div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
            <div>
                <label for="jam_buka" style="display:block;margin-bottom:6px;color:#9ca3af">Jam Buka</label>
                <input type="text" id="jam_buka" name="jam_buka" value="{{ old('jam_buka', $kursus->jam_buka) }}" style="width:100%;background:#0f172a;border:1px solid #334155;color:#e5e7eb;border-radius:8px;padding:10px" />
            </div>
            <div>
                <label for="jam_tutup" style="display:block;margin-bottom:6px;color:#9ca3af">Jam Tutup</label>
                <input type="text" id="jam_tutup" name="jam_tutup" value="{{ old('jam_tutup', $kursus->jam_tutup) }}" style="width:100%;background:#0f172a;border:1px solid #334155;color:#e5e7eb;border-radius:8px;padding:10px" />
            </div>
        </div>

        <div>
            <label for="nama_pemilik" style="display:block;margin-bottom:6px;color:#9ca3af">Nama Pemilik</label>
            <input type="text" id="nama_pemilik" name="nama_pemilik" value="{{ old('nama_pemilik', $kursus->nama_pemilik) }}" style="width:100%;background:#0f172a;border:1px solid #334155;color:#e5e7eb;border-radius:8px;padding:10px" />
        </div>

        <div>
            <label for="email" style="display:block;margin-bottom:6px;color:#9ca3af">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email', $kursus->email) }}" required style="width:100%;background:#0f172a;border:1px solid #334155;color:#e5e7eb;border-radius:8px;padding:10px" />
        </div>

        <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:8px">
            <a href="{{ route('dashboard') }}" style="background:#1f2937;color:#e5e7eb;border:1px solid #374151;border-radius:8px;padding:10px 14px;text-decoration:none">Batal</a>
            <button type="submit" style="background:#2563eb;color:#fff;border:0;border-radius:8px;padding:10px 16px;cursor:pointer">Simpan Perubahan</button>
        </div>
    </form>
</div>

@push('scripts')
    <script>
        // Function to initialize the map
        function initMap() {
            // Check if Google Maps API is loaded
            if (!window.google || !window.google.maps) {
                console.error('Google Maps API not loaded');
                return;
            }
            
            // Initialize map with current location or default to Jakarta
            const initialLat = parseFloat('{{ old('latitude', $kursus->latitude) }}') || -6.2088;
            const initialLng = parseFloat('{{ old('longitude', $kursus->longitude) }}') || 106.8456;
            const initialZoom = '{{ $kursus->latitude && $kursus->longitude ? 15 : 12 }}';
            
            const map = new google.maps.Map(document.getElementById('map'), {
                center: { lat: initialLat, lng: initialLng },
                zoom: parseInt(initialZoom),
                mapTypeId: 'roadmap',
                styles: [
                    {
                        featureType: 'poi',
                        elementType: 'labels',
                        stylers: [{ visibility: 'off' }]
                    }
                ]
            });

            // Initialize search box
            const input = document.getElementById('search-box');
            const searchBox = new google.maps.places.SearchBox(input);
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

            // Initialize marker with current position if available
            let marker = new google.maps.Marker({
                map: map,
                draggable: true,
                animation: google.maps.Animation.DROP,
                position: { lat: initialLat, lng: initialLng },
                title: 'Lokasi Kursus'
            });

            // Set initial values
            if (!document.getElementById('latitude').value) {
                document.getElementById('latitude').value = initialLat.toFixed(6);
                document.getElementById('longitude').value = initialLng.toFixed(6);
            }

            // Function to update location fields
            function updateLocationFields(location) {
                const lat = location.lat();
                const lng = location.lng();
                
                document.getElementById('latitude').value = lat.toFixed(6);
                document.getElementById('longitude').value = lng.toFixed(6);
                
                // Update address using reverse geocoding
                const geocoder = new google.maps.Geocoder();
                geocoder.geocode({ location: { lat, lng } }, (results, status) => {
                    if (status === 'OK' && results[0]) {
                        document.getElementById('lokasi').value = results[0].formatted_address;
                    }
                });
                
                // Center the map on the marker
                map.panTo(location);
            }

            // Update form fields when marker is dragged
            marker.addListener('dragend', function() {
                updateLocationFields(marker.getPosition());
            });

            // Update marker position when a place is selected from search
            searchBox.addListener('places_changed', function() {
                const places = searchBox.getPlaces();

                if (places.length === 0) {
                    return;
                }

                // Get the first place from the search results
                const place = places[0];

                if (!place.geometry || !place.geometry.location) {
                    console.log("Returned place contains no geometry");
                    return;
                }

                // Move the marker to the selected location
                marker.setPosition(place.geometry.location);
                updateLocationFields(place.geometry.location);

                // Center the map on the selected location
                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(17);
                }
            });

            // Add click event to place marker
            map.addListener('click', function(event) {
                marker.setPosition(event.latLng);
                updateLocationFields(event.latLng);
            });

            // Try to get user's current location if no coordinates are set
            if (!'{{ $kursus->latitude }}' && !'{{ $kursus->longitude }}' && navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const pos = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };
                        marker.setPosition(pos);
                        map.setCenter(pos);
                        map.setZoom(15);
                        updateLocationFields(marker.getPosition());
                    },
                    () => {
                        // Handle location access denied
                        console.log('Geolocation access denied');
                    }
                );
            }
        }

        // Load the Google Maps API script
        function loadGoogleMaps() {
            const script = document.createElement('script');
            script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyA51CWc7oYPE4uj4r6UsNaWOKutp_e85hY&libraries=places&callback=initMap';
            script.async = true;
            script.defer = true;
            document.head.appendChild(script);
        }

        // Initialize when the DOM is fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            loadGoogleMaps();
        });
    </script>
@endpush

@endsection
