@extends('layouts.base', ['title' => 'Registrasi - Data Kursus | LeadDrive', 'hideTopbar' => true])

@push('styles')
    <style>
        .auth-shell {
            min-height: 100vh;
            background: radial-gradient(circle at top right, #2a1b0a 0%, #0f141a 60%);
            padding: 2rem 1rem;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .container {
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
        }

        /* Progress Indicator */
        .progress-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 3rem;
            position: relative;
        }

        .progress-line {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 200px;
            height: 2px;
            background: rgba(255, 255, 255, 0.1);
            z-index: 0;
        }

        .progress-step {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.1rem;
            position: relative;
            z-index: 1;
            transition: all 0.3s ease;
            margin: 0 2rem;
        }

        .step-completed {
            background: #10b981;
            color: white;
            box-shadow: 0 0 15px rgba(16, 185, 129, 0.3);
        }

        .step-active {
            background: linear-gradient(135deg, #ff7f00 0%, #ff5500 100%);
            color: white;
            box-shadow: 0 0 20px rgba(255, 127, 0, 0.4);
            transform: scale(1.1);
        }

        .step-pending {
            background: rgba(30, 37, 48, 0.8);
            color: #64748b;
            border: 2px solid rgba(255, 255, 255, 0.1);
        }

        .step-title {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .step-title h1 {
            color: #ffffff;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            letter-spacing: -0.02em;
        }

        .step-title p {
            color: #94a3b8;
            font-size: 1rem;
        }

        .form-card {
            background: rgba(30, 37, 48, 0.6);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            padding: 2.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-card h2 {
            color: #ffffff;
            font-size: 1.5rem;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        #map {
            height: 350px;
            width: 100%;
            border-radius: 16px;
            margin-bottom: 1rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .map-container {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .map-search {
            position: absolute;
            top: 16px;
            left: 16px;
            z-index: 1000;
            width: calc(100% - 32px);
            max-width: 400px;
        }

        .map-search input {
            width: 100%;
            padding: 14px 16px;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(15, 20, 26, 0.9);
            color: #ffffff;
            font-size: 0.95rem;
            outline: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
        }

        .location-coordinates {
            display: flex;
            gap: 1.5rem;
            margin-top: 1.5rem;
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
            margin-bottom: 0.75rem;
            color: #cbd5e1;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .form-group label .required {
            color: #ff7f00;
            margin-left: 4px;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            background: rgba(15, 20, 26, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: #ffffff;
            font-size: 0.95rem;
            transition: all 0.2s ease;
            font-family: inherit;
        }

        .form-control:focus {
            outline: none;
            border-color: #ff7f00;
            background: rgba(15, 20, 26, 0.8);
            box-shadow: 0 0 0 4px rgba(255, 127, 0, 0.1);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 120px;
        }

        .form-actions {
            display: flex;
            gap: 1.5rem;
            margin-top: 2.5rem;
        }

        .btn-back, .btn-next {
            flex: 1;
            padding: 16px;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.3s ease;
        }
        
        .btn-back {
            background: rgba(255, 255, 255, 0.05);
            color: #cbd5e1;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .btn-back:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
        }
        
        .btn-next {
            background: linear-gradient(135deg, #ff7f00 0%, #ff5500 100%);
            color: white;
            box-shadow: 0 8px 20px rgba(255, 127, 0, 0.25);
        }

        .btn-next:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(255, 127, 0, 0.35);
        }

        .time-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        .error-message {
            color: #f87171;
            font-size: 0.85rem;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        @media (max-width: 768px) {
            .time-row { grid-template-columns: 1fr; }
            .auth-shell { padding: 1rem; }
            .form-card { padding: 1.5rem; }
            .progress-line { width: 150px; }
            .progress-step { width: 40px; height: 40px; font-size: 1rem; margin: 0 1.5rem; }
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Inisialisasi variabel global
        let map;
        let marker;
        let searchBox;

        // Fungsi inisialisasi peta
        function initMap() {
            try {
                const mapElement = document.getElementById('map');
                if (!mapElement) {
                    console.error('Elemen dengan ID "map" tidak ditemukan');
                    return;
                }

                // Inisialisasi peta
                map = new google.maps.Map(mapElement, {
                    center: { lat: -7.755131, lng: 110.421340 }, // Default to Yogyakarta
                    zoom: 12,
                    styles: [
                        { elementType: "geometry", stylers: [{ color: "#242f3e" }] },
                        { elementType: "labels.text.stroke", stylers: [{ color: "#242f3e" }] },
                        { elementType: "labels.text.fill", stylers: [{ color: "#746855" }] },
                        { featureType: "administrative.locality", elementType: "labels.text.fill", stylers: [{ color: "#d59563" }] },
                        { featureType: "poi", elementType: "labels.text.fill", stylers: [{ color: "#d59563" }] },
                        { featureType: "poi.park", elementType: "geometry", stylers: [{ color: "#263c3f" }] },
                        { featureType: "poi.park", elementType: "labels.text.fill", stylers: [{ color: "#6b9a76" }] },
                        { featureType: "road", elementType: "geometry", stylers: [{ color: "#38414e" }] },
                        { featureType: "road", elementType: "geometry.stroke", stylers: [{ color: "#212a37" }] },
                        { featureType: "road", elementType: "labels.text.fill", stylers: [{ color: "#9ca5b3" }] },
                        { featureType: "road.highway", elementType: "geometry", stylers: [{ color: "#746855" }] },
                        { featureType: "road.highway", elementType: "geometry.stroke", stylers: [{ color: "#1f2835" }] },
                        { featureType: "road.highway", elementType: "labels.text.fill", stylers: [{ color: "#f3d19c" }] },
                        { featureType: "transit", elementType: "geometry", stylers: [{ color: "#2f3948" }] },
                        { featureType: "transit.station", elementType: "labels.text.fill", stylers: [{ color: "#d59563" }] },
                        { featureType: "water", elementType: "geometry", stylers: [{ color: "#17263c" }] },
                        { featureType: "water", elementType: "labels.text.fill", stylers: [{ color: "#515c6d" }] },
                        { featureType: "water", elementType: "labels.text.stroke", stylers: [{ color: "#17263c" }] },
                    ],
                });

                // Inisialisasi marker
                marker = new google.maps.Marker({
                    map: map,
                    draggable: true,
                    animation: google.maps.Animation.DROP,
                    position: { lat: -7.755131, lng: 110.421340 }
                });

                // Inisialisasi search box
                const input = document.getElementById('search-box');
                searchBox = new google.maps.places.SearchBox(input);

                // Bias the SearchBox results towards current map's viewport.
                map.addListener('bounds_changed', function() {
                    searchBox.setBounds(map.getBounds());
                });

                // Update marker position when a place is selected from search
                searchBox.addListener('places_changed', function() {
                    const places = searchBox.getPlaces();

                    if (places.length === 0) {
                        return;
                    }

                    const place = places[0];
                    if (!place.geometry || !place.geometry.location) {
                        console.log("Tempat yang dipilih tidak memiliki geometri");
                        return;
                    }

                    // Update marker position
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

                // Update marker when dragged
                marker.addListener('dragend', function() {
                    updateLocationFields(marker.getPosition());
                    
                    // Reverse geocode to get address
                    const geocoder = new google.maps.Geocoder();
                    geocoder.geocode({ location: marker.getPosition() }, (results, status) => {
                        if (status === 'OK' && results[0]) {
                            document.getElementById('lokasi').value = results[0].formatted_address;
                        }
                    });
                });

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
                            updateLocationFields(new google.maps.LatLng(pos.lat, pos.lng));
                            
                            // Get address from coordinates
                            const geocoder = new google.maps.Geocoder();
                            geocoder.geocode({ location: pos }, (results, status) => {
                                if (status === 'OK' && results[0]) {
                                    document.getElementById('lokasi').value = results[0].formatted_address;
                                }
                            });
                        },
                        () => {
                            console.log('Geolocation access denied');
                        }
                    );
                }

                // Update form fields with initial position
                updateLocationFields(marker.getPosition());

            } catch (error) {
                console.error('Error saat menginisialisasi peta:', error);
                const mapElement = document.getElementById('map');
                if (mapElement) {
                    mapElement.innerHTML = '<div style="color: #ff6b6b; padding: 20px; text-align: center;">Terjadi kesalahan saat memuat peta. Silakan muat ulang halaman.</div>';
                }
            }
        }

        // Fungsi untuk memperbarui field latitude dan longitude
        function updateLocationFields(position) {
            if (position) {
                const lat = typeof position.lat === 'function' ? position.lat() : position.lat;
                const lng = typeof position.lng === 'function' ? position.lng() : position.lng;
                
                const latInput = document.getElementById('latitude');
                const lngInput = document.getElementById('longitude');
                
                if (latInput) latInput.value = lat;
                if (lngInput) lngInput.value = lng;
            }
        }

        // Fungsi untuk memuat Google Maps API
        function loadGoogleMaps() {
            // Cek apakah Google Maps API sudah dimuat
            if (typeof google === 'object' && typeof google.maps === 'object') {
                initMap();
                return;
            }

            // Cek apakah script sudah ada di DOM
            if (document.querySelector('script[src*="maps.googleapis.com"]')) {
                return;
            }

            const script = document.createElement('script');
            script.src = 'https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&libraries=places&callback=initMap';
            script.async = true;
            script.defer = true;
            script.onerror = function() {
                console.error('Gagal memuat Google Maps API');
                const mapContainer = document.getElementById('map');
                if (mapContainer) {
                    mapContainer.innerHTML = '<div style="color: #ff6b6b; padding: 20px; text-align: center;">Gagal memuat peta. Pastikan koneksi internet Anda stabil dan coba muat ulang halaman.</div>';
                }
            };
            document.head.appendChild(script);
        }

        // Panggil fungsi loadGoogleMaps saat dokumen selesai dimuat
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', loadGoogleMaps);
        } else {
            loadGoogleMaps();
        }
    </script>
@endpush

@section('content')
    <div class="auth-shell">
        <div class="container">
            <!-- Progress Indicator -->
            <div class="progress-container">
                <div class="progress-line"></div>
                <div class="progress-step step-completed"><i class="fas fa-check"></i></div>
                <div class="progress-step step-active">2</div>
                <div class="progress-step step-pending">3</div>
            </div>

            <!-- Step Title -->
            <div class="step-title">
                <h1>Data Kursus</h1>
                <p>Isi detail kursus mengemudi Anda</p>
            </div>

            <!-- Form Card -->
            <div class="form-card">
                <h2>Registrasi Kursus Mengemudi</h2>

                @if ($errors->any())
                    <div style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2); color: #f87171; padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem;">
                        <ul style="list-style: none; padding: 0; margin: 0;">
                            @foreach ($errors->all() as $error)
                                <li style="margin-bottom: 0.25rem; display: flex; align-items: center; gap: 0.5rem;">
                                    <i class="fas fa-exclamation-circle"></i> {{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('register.step2.submit') }}" method="POST" id="step2Form">
                    @csrf

                    <div class="form-group">
                        <label for="nama_kursus">Nama Kursus/Instansi <span class="required">*</span></label>
                        <input type="text" id="nama_kursus" name="nama_kursus" class="form-control" value="{{ old('nama_kursus') }}" placeholder="Contoh: Kursus Mengemudi Maju Jaya" required>
                        @error('nama_kursus')
                            <div class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="lokasi">Alamat Lengkap <span class="required">*</span></label>
                        <div class="map-container">
                            <div class="map-search">
                                <input type="text" id="search-box" placeholder="Cari lokasi di peta...">
                            </div>
                            <div id="map"></div>
                        </div>
                        
                        <div class="location-coordinates">
                            <div class="form-group">
                                <label for="latitude">Latitude <span class="required">*</span></label>
                                <input type="text" id="latitude" name="latitude" class="form-control" required readonly style="background: rgba(0,0,0,0.3); cursor: not-allowed;">
                            </div>
                            <div class="form-group">
                                <label for="longitude">Longitude <span class="required">*</span></label>
                                <input type="text" id="longitude" name="longitude" class="form-control" required readonly style="background: rgba(0,0,0,0.3); cursor: not-allowed;">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="lokasi">Detail Alamat <span class="required">*</span></label>
                            <textarea id="lokasi" name="lokasi" class="form-control" placeholder="Jalan, Nomor, RT/RW, Kelurahan, Kecamatan..." required>{{ old('lokasi') }}</textarea>
                        </div>
                    </div>
                    @error('lokasi')
                        <div class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror

                    <div class="time-row">
                        <div class="form-group">
                            <label for="jam_buka">Jam Buka <span class="required">*</span></label>
                            <input type="time" id="jam_buka" name="jam_buka" class="form-control" value="{{ old('jam_buka') }}" required>
                            @error('jam_buka')
                                <div class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="jam_tutup">Jam Tutup <span class="required">*</span></label>
                            <input type="time" id="jam_tutup" name="jam_tutup" class="form-control" value="{{ old('jam_tutup') }}" required>
                            @error('jam_tutup')
                                <div class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('register.back', 2) }}" class="btn-back">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn-next">
                            Lanjutkan ke Dokumen <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

