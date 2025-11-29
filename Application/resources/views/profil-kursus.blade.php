@extends('layouts.base', ['title' => 'Profil Kursus - LeadDrive'])

@push('styles')
<style>
    :root {
        --glass-bg: rgba(30, 37, 48, 0.5);
        --glass-border: rgba(255, 255, 255, 0.08);
        --glass-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        --primary-gradient: linear-gradient(135deg, #ff7f00 0%, #ff5500 100%);
    }

    .page-container {
        padding: 1.5rem;
        min-height: calc(100vh - 70px);
        background: radial-gradient(circle at top right, #1f1508 0%, #0f141a 60%);
        font-family: 'Inter', sans-serif;
    }

    /* Profile Header Card */
    .profile-header-card {
        background: var(--glass-bg);
        border: 1px solid var(--glass-border);
        border-radius: 20px;
        padding: 2rem;
        backdrop-filter: blur(12px);
        display: flex;
        align-items: center;
        gap: 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .profile-header-card::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 300px;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 127, 0, 0.05));
        pointer-events: none;
    }

    .header-avatar-section {
        position: relative;
        flex-shrink: 0;
    }

    .header-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    }

    .header-avatar-btn {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 32px;
        height: 32px;
        background: var(--primary-gradient);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        cursor: pointer;
        border: 2px solid #1e2530;
        transition: transform 0.2s;
        font-size: 0.8rem;
    }

    .header-avatar-btn:hover {
        transform: scale(1.1);
    }

    .header-info {
        flex: 1;
    }

    .header-name {
        font-size: 1.75rem;
        font-weight: 800;
        color: #fff;
        margin-bottom: 0.25rem;
        line-height: 1.2;
    }

    .header-role {
        color: #ffb255;
        font-size: 0.9rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 1rem;
        display: block;
    }

    .header-meta {
        display: flex;
        gap: 1.5rem;
        flex-wrap: wrap;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #94a3b8;
        font-size: 0.9rem;
        background: rgba(255, 255, 255, 0.03);
        padding: 0.5rem 1rem;
        border-radius: 8px;
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .meta-item i {
        color: #cbd5e1;
    }

    /* Content Grid */
    .content-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 1.5rem;
    }

    .content-card {
        background: var(--glass-bg);
        border: 1px solid var(--glass-border);
        border-radius: 20px;
        padding: 1.75rem;
        backdrop-filter: blur(12px);
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .card-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #fff;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .card-title i {
        color: #ff7f00;
        background: rgba(255, 127, 0, 0.1);
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        font-size: 0.9rem;
    }

    /* Forms */
    .form-group {
        margin-bottom: 1.25rem;
    }

    .form-label {
        display: block;
        color: #cbd5e1;
        font-size: 0.85rem;
        font-weight: 500;
        margin-bottom: 0.5rem;
        margin-left: 0.25rem;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        background: rgba(15, 20, 26, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        color: #fff;
        font-size: 0.95rem;
        transition: all 0.2s;
        outline: none;
    }

    .form-control:focus {
        border-color: #ff7f00;
        background: rgba(15, 20, 26, 0.8);
        box-shadow: 0 0 0 3px rgba(255, 127, 0, 0.1);
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    /* Map */
    .map-wrapper {
        height: 250px;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.1);
        position: relative;
        margin-bottom: 1.25rem;
    }

    #map { width: 100%; height: 100%; }

    .map-search {
        position: absolute;
        top: 10px;
        left: 10px;
        right: 10px;
        z-index: 5;
    }

    .map-search input {
        width: 100%;
        padding: 0.6rem 1rem 0.6rem 2.5rem;
        border-radius: 8px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        background: rgba(20, 25, 35, 0.95);
        color: white;
        font-size: 0.85rem;
        backdrop-filter: blur(4px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }

    .map-search i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 0.8rem;
    }

    /* Action Bar */
    .action-bar {
        margin-top: 2rem;
        display: flex;
        justify-content: flex-end;
        padding-top: 1.5rem;
        border-top: 1px solid rgba(255, 255, 255, 0.05);
    }

    .btn-save {
        background: var(--primary-gradient);
        color: white;
        padding: 0.85rem 2.5rem;
        border-radius: 10px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 1rem;
        box-shadow: 0 4px 15px rgba(255, 127, 0, 0.2);
    }

    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(255, 127, 0, 0.3);
    }

    @media (max-width: 768px) {
        .profile-header-card {
            flex-direction: column;
            text-align: center;
            padding: 1.5rem;
        }
        .header-meta {
            justify-content: center;
        }
        .content-grid {
            grid-template-columns: 1fr;
        }
        .form-row {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="page-container">
    <div class="container mx-auto">
        
        @if (session('success'))
            <div style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); color: #34d399; padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Header Card -->
            <div class="profile-header-card">
                <div class="header-avatar-section">
                    @php $pf = $kursus->foto_profil ?? null; @endphp
                    <img src="{{ $pf ?: asset('images/logo.jpg') }}" alt="Logo" class="header-avatar" id="avatar-preview">
                    <label for="foto_profil" class="header-avatar-btn" title="Ganti Foto">
                        <i class="fas fa-camera"></i>
                    </label>
                    <input type="file" id="foto_profil" name="foto_profil" accept="image/*" style="display: none;" onchange="previewImage(this)">
                </div>
                <div class="header-info">
                    <h1 class="header-name">{{ $kursus->nama_kursus }}</h1>
                    <span class="header-role">Pemilik Kursus</span>
                    <div class="header-meta">
                        <div class="meta-item">
                            <i class="fas fa-envelope"></i> {{ $kursus->email }}
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-phone"></i> {{ $kursus->telepon ?: 'Belum ada telepon' }}
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-clock"></i> {{ substr($kursus->jam_buka, 0, 5) }} - {{ substr($kursus->jam_tutup, 0, 5) }} WIB
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-grid">
                <!-- Basic Info -->
                <div class="content-card">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="fas fa-info"></i> Informasi Dasar
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Nama Kursus</label>
                        <input type="text" name="nama_kursus" class="form-control" value="{{ old('nama_kursus', $kursus->nama_kursus) }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nama Pemilik</label>
                        <input type="text" name="nama_pemilik" class="form-control" value="{{ old('nama_pemilik', $kursus->nama_pemilik) }}">
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $kursus->email) }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Telepon</label>
                            <input type="text" name="telepon" class="form-control" value="{{ old('telepon', $kursus->telepon) }}">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Jam Buka</label>
                            <input type="time" name="jam_buka" class="form-control" value="{{ old('jam_buka', $kursus->jam_buka) }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Jam Tutup</label>
                            <input type="time" name="jam_tutup" class="form-control" value="{{ old('jam_tutup', $kursus->jam_tutup) }}">
                        </div>
                    </div>
                </div>

                <!-- Location -->
                <div class="content-card">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="fas fa-map-marker-alt"></i> Lokasi & Peta
                        </div>
                    </div>

                    <div class="map-wrapper">
                        <div class="map-search">
                            <i class="fas fa-search"></i>
                            <input type="text" id="search-box" placeholder="Cari lokasi...">
                        </div>
                        <div id="map-loading" style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; background: rgba(30, 37, 48, 0.8); z-index: 2;">
                            <div class="loading-spinner"></div>
                        </div>
                        <div id="map"></div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Alamat Lengkap</label>
                        <textarea name="lokasi" class="form-control" rows="3" required placeholder="Masukkan alamat lengkap...">{{ old('lokasi', $kursus->lokasi) }}</textarea>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Latitude</label>
                            <input type="text" id="latitude" name="latitude" class="form-control" value="{{ old('latitude', $kursus->latitude) }}" readonly style="opacity: 0.7; cursor: default;">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Longitude</label>
                            <input type="text" id="longitude" name="longitude" class="form-control" value="{{ old('longitude', $kursus->longitude) }}" readonly style="opacity: 0.7; cursor: default;">
                        </div>
                    </div>
                </div>
            </div>

            <div class="action-bar">
                <button type="submit" class="btn-save">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>

        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatar-preview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Make initMap globally accessible
    window.initMap = function() {
        if (!document.getElementById('map')) return;
        
        const initialLat = parseFloat('{{ old('latitude', $kursus->latitude) }}') || -6.2088;
        const initialLng = parseFloat('{{ old('longitude', $kursus->longitude) }}') || 106.8456;
        const initialZoom = {{ $kursus->latitude && $kursus->longitude ? 15 : 12 }};
        
        const map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: initialLat, lng: initialLng },
            zoom: initialZoom,
            mapTypeId: 'roadmap',
            disableDefaultUI: true,
            zoomControl: true,
            styles: [
                { "elementType": "geometry", "stylers": [{ "color": "#242f3e" }] },
                { "elementType": "labels.text.stroke", "stylers": [{ "color": "#242f3e" }] },
                { "elementType": "labels.text.fill", "stylers": [{ "color": "#746855" }] },
                { "featureType": "road", "elementType": "geometry", "stylers": [{ "color": "#38414e" }] },
                { "featureType": "road", "elementType": "geometry.stroke", "stylers": [{ "color": "#212a37" }] },
                { "featureType": "road", "elementType": "labels.text.fill", "stylers": [{ "color": "#9ca5b3" }] },
                { "featureType": "water", "elementType": "geometry", "stylers": [{ "color": "#17263c" }] }
            ]
        });

        // Hide loading spinner when map is idle (loaded)
        google.maps.event.addListenerOnce(map, 'idle', function() {
            const loader = document.getElementById('map-loading');
            if (loader) {
                loader.style.opacity = '0';
                setTimeout(() => loader.remove(), 300);
            }
        });

        const input = document.getElementById('search-box');
        const searchBox = new google.maps.places.SearchBox(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener("bounds_changed", () => {
            searchBox.setBounds(map.getBounds());
        });

        let marker = new google.maps.Marker({
            map: map,
            draggable: true,
            animation: google.maps.Animation.DROP,
            position: { lat: initialLat, lng: initialLng }
        });

        // Initialize hidden fields if empty
        if (!document.getElementById('latitude').value) {
            document.getElementById('latitude').value = initialLat.toFixed(6);
            document.getElementById('longitude').value = initialLng.toFixed(6);
        }

        function updateLocationFields(location) {
            document.getElementById('latitude').value = location.lat().toFixed(6);
            document.getElementById('longitude').value = location.lng().toFixed(6);
            
            const geocoder = new google.maps.Geocoder();
            geocoder.geocode({ location: location }, (results, status) => {
                if (status === 'OK' && results[0]) {
                    document.querySelector('textarea[name="lokasi"]').value = results[0].formatted_address;
                }
            });
        }

        marker.addListener('dragend', function() { updateLocationFields(marker.getPosition()); });

        searchBox.addListener('places_changed', function() {
            const places = searchBox.getPlaces();
            if (places.length === 0) return;
            const place = places[0];
            if (!place.geometry || !place.geometry.location) return;

            marker.setPosition(place.geometry.location);
            updateLocationFields(place.geometry.location);

            if (place.geometry.viewport) map.fitBounds(place.geometry.viewport);
            else {
                map.setCenter(place.geometry.location);
                map.setZoom(17);
            }
        });

        map.addListener('click', function(event) {
            marker.setPosition(event.latLng);
            updateLocationFields(event.latLng);
        });
    }

    function loadGoogleMaps() {
        // Check if script is already loaded
        if (document.querySelector('script[src*="maps.googleapis.com"]')) {
            if (window.google && window.google.maps) {
                initMap();
            }
            return;
        }

        const script = document.createElement('script');
        script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyA51CWc7oYPE4uj4r6UsNaWOKutp_e85hY&libraries=places&callback=initMap';
        script.async = true;
        script.defer = true;
        document.head.appendChild(script);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', loadGoogleMaps);
    } else {
        loadGoogleMaps();
    }
</script>
@endpush
