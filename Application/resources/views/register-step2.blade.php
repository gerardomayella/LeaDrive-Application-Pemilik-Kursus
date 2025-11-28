@extends('layouts.base', ['title' => 'Registrasi - Data Kursus | LeadDrive', 'hideTopbar' => true])

@push('styles')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body { background-color:#1c1c1c; color:#fff; }
        .auth-shell { min-height: calc(100vh - 44px); padding: 2rem 1rem; }

        .container {
            max-width: 1000px;
            margin: 0 auto;
        }

        .progress-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .progress-step {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.1rem;
        }

        .step-completed {
            background-color: #4caf50;
            color: #fff;
        }

        .step-active {
            background-color: #ff7f00;
            color: #fff;
        }

        .step-pending {
            background-color: #444;
            color: #fff;
        }

        .step-title {
            text-align: center;
            margin-bottom: 2rem;
        }

        .step-title h1 {
            color: #ff7f00;
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
        }

        .step-title p {
            color: #ccc;
        }

        .form-card {
            background-color: #2c2c2c;
            padding: 2.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
        }

        .form-card h2 {
            color: #ff7f00;
            font-size: 1.5rem;
            margin-bottom: 2rem;
        }

        #map {
            height: 300px;
            width: 100%;
            border-radius: 8px;
            margin-bottom: 1rem;
            border: 1px solid #444;
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

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #fff;
            font-weight: 500;
        }

        .form-group label .required {
            color: #ff7f00;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #444;
            border-radius: 6px;
            background-color: #333;
            color: #fff;
            font-size: 1rem;
            font-family: Arial, sans-serif;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #ff7f00;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .gps-section {
            border: 2px dashed #4caf50;
            border-radius: 8px;
            padding: 3rem;
            text-align: center;
            background-color: #1a3d1a;
            margin-bottom: 1.5rem;
            cursor: pointer;
        }

        .gps-section:hover {
            background-color: #1f4f1f;
        }

        .gps-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .gps-selected {
            background-color: #1a3d1a;
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1rem;
            color: #4caf50;
        }

        .gps-selected::before {
            content: "✓ ";
            color: #4caf50;
        }

        .vehicle-types {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
            max-width: 500px;
        }

        .vehicle-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 1rem;
            background-color: #333;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .vehicle-item:hover {
            background-color: #3c3c3c;
        }

        .vehicle-item input[type="checkbox"] {
            width: auto;
            margin: 0;
        }

        .vehicle-item label {
            margin: 0;
            cursor: pointer;
            flex: 1;
        }

        .paket-section {
            margin-bottom: 2rem;
        }

        .paket-item {
            background-color: #333;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            position: relative;
        }

        .paket-item-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .paket-item-header h4 {
            color: #ff7f00;
        }

        .paket-item-remove {
            background-color: #ff4444;
            color: #fff;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
        }

        .paket-item-remove:hover {
            background-color: #cc3333;
        }

        .paket-form-row {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .btn-add-paket {
            background-color: #2c2c2c;
            color: #fff;
            border: 2px dashed #666;
            padding: 1rem;
            border-radius: 6px;
            cursor: pointer;
            width: 100%;
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: border-color 0.3s;
        }

        .btn-add-paket:hover {
            border-color: #ff7f00;
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn-back,
        .btn-next {
            flex: 1;
            padding: 1rem;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-back {
            background-color: #2c2c2c;
            color: #fff;
        }

        .btn-back:hover {
            background-color: #3c3c3c;
        }

        .btn-next {
            background-color: #2c2c2c;
            color: #fff;
        }

        .btn-next:hover {
            background-color: #3c3c3c;
        }

        .time-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .error-message {
            color: #ff4444;
            font-size: 0.9rem;
            margin-top: 0.5rem;
        }

        @media (max-width: 768px) {
            .vehicle-types {
                grid-template-columns: 1fr;
            }

            .paket-form-row {
                grid-template-columns: 1fr;
            }

            .time-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@push('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA51CWc7oYPE4uj4r6UsNaWOKutp_e85hY&libraries=places&callback=Function.prototype" async defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize map
            const map = new google.maps.Map(document.getElementById('map'), {
                center: { lat: -6.2088, lng: 106.8456 }, // Default to Jakarta
                zoom: 12
            });

            // Initialize search box
            const searchBox = new google.maps.places.SearchBox(document.getElementById('search-box'));
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(document.getElementById('search-box'));

            // Initialize marker
            let marker = new google.maps.Marker({
                map: map,
                draggable: true,
                animation: google.maps.Animation.DROP,
                position: { lat: -6.2088, lng: 106.8456 }
            });

            // Update form fields when marker is dragged
            marker.addListener('dragend', function() {
                updateLocationFields(marker.getPosition());
            });

            // Update marker position when a place is selected from search
            map.addListener('bounds_changed', function() {
                searchBox.setBounds(map.getBounds());
            });

            // Listen for the event fired when the user selects a prediction and retrieve more details
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

                // Update the map and marker
                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(17);
                }
                
                marker.setPosition(place.geometry.location);
                updateLocationFields(place.geometry.location);
                
                // Update address field
                document.getElementById('lokasi').value = place.formatted_address || '';
            });

            // Update location on map click
            map.addListener('click', function(event) {
                marker.setPosition(event.latLng);
                updateLocationFields(event.latLng);
                
                // Reverse geocode to get address
                const geocoder = new google.maps.Geocoder();
                geocoder.geocode({ location: event.latLng }, (results, status) => {
                    if (status === 'OK' && results[0]) {
                        document.getElementById('lokasi').value = results[0].formatted_address;
                    }
                });
            });

            // Update form fields with coordinates
            function updateLocationFields(latLng) {
                document.getElementById('latitude').value = latLng.lat();
                document.getElementById('longitude').value = latLng.lng();
                
                // If address field is empty, try to get it from reverse geocoding
                if (!document.getElementById('lokasi').value) {
                    const geocoder = new google.maps.Geocoder();
                    geocoder.geocode({ location: latLng }, (results, status) => {
                        if (status === 'OK' && results[0]) {
                            document.getElementById('lokasi').value = results[0].formatted_address;
                        }
                    });
                }
            }
            
            // Initialize with current location if available
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const pos = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };
                        
                        marker.setPosition(pos);
                        map.setCenter(pos);
                        map.setZoom(15);
                        updateLocationFields(pos);
                        
                        // Get address from coordinates
                        const geocoder = new google.maps.Geocoder();
                        geocoder.geocode({ location: pos }, (results, status) => {
                            if (status === 'OK' && results[0]) {
                                document.getElementById('lokasi').value = results[0].formatted_address;
                            }
                        });
                    },
                    () => {
                        // Handle location access denied
                        console.log('Geolocation access denied');
                    }
                );
            }
        });
    </script>
@endpush

@section('content')
    <div class="auth-shell">
    <div class="container">
        <!-- Progress Indicator -->
        <div class="progress-container">
            <div class="progress-step step-completed">1</div>
            <div class="progress-step step-active">2</div>
            <div class="progress-step step-pending">3</div>
        </div>

        <!-- Step Title -->
        <div class="step-title">
            <h1>Data Kursus</h1>
            <p>Isi detail kursus mengemudi</p>
        </div>

        <!-- Form Card -->
        <div class="form-card">
            <h2>Registrasi Kursus Mengemudi</h2>

            @if ($errors->any())
                <div style="background-color: #ff4444; color: #fff; padding: 1rem; border-radius: 6px; margin-bottom: 1.5rem;">
                    <ul style="list-style: none; padding: 0;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register.step2.submit') }}" method="POST" id="step2Form">
                @csrf

                <div class="form-group">
                    <label for="nama_kursus">Nama Kursus/Instansi <span class="required">*</span></label>
                    <input type="text" id="nama_kursus" name="nama_kursus" value="{{ old('nama_kursus') }}" required>
                    @error('nama_kursus')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="lokasi">Alamat Lengkap <span class="required">*</span></label>
                    <div class="map-container">
                        <div class="map-search">
                            <input type="text" id="search-box" placeholder="Cari lokasi...">
                        </div>
                        <div id="map"></div>
                    </div>
                    <div class="location-coordinates">
                        <div class="form-group">
                            <label for="latitude">Latitude <span class="required">*</span></label>
                            <input type="text" id="latitude" name="latitude" required readonly>
                        </div>
                        <div class="form-group">
                            <label for="longitude">Longitude <span class="required">*</span></label>
                            <input type="text" id="longitude" name="longitude" required readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lokasi">Alamat Lengkap <span class="required">*</span></label>
                        <textarea id="lokasi" name="lokasi" required>{{ old('lokasi') }}</textarea>
                    </div>
                </div>
                @error('lokasi')
                    <div class="error-message">{{ $message }}</div>
                @enderror

                <div class="time-row">
                    <div class="form-group">
                        <label for="jam_buka">Jam Buka <span class="required">*</span></label>
                        <input type="time" id="jam_buka" name="jam_buka" value="{{ old('jam_buka') }}" required>
                        @error('jam_buka')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="jam_tutup">Jam Tutup <span class="required">*</span></label>
                        <input type="time" id="jam_tutup" name="jam_tutup" value="{{ old('jam_tutup') }}" required>
                        @error('jam_tutup')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('register.back', 2) }}" class="btn-back">Kembali</a>
                    <button type="submit" class="btn-next">Lanjutkan ke Dokumen</button>
                </div>
            </form>
        </div>
    </div>
    </div>
@endsection

