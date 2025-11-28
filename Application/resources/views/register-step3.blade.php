@extends('layouts.base', ['title' => 'Registrasi - Upload Dokumen | LeadDrive', 'hideTopbar' => true])

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
            max-width: 900px;
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

        .info-box {
            background: rgba(15, 20, 26, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .info-box h4 {
            color: #ff7f00;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1rem;
        }

        .info-box ul {
            list-style: none;
            padding-left: 0;
            color: #cbd5e1;
            margin: 0;
        }

        .info-box li {
            margin-bottom: 0.5rem;
            padding-left: 1.5rem;
            position: relative;
            font-size: 0.95rem;
        }

        .info-box li::before {
            content: "•";
            position: absolute;
            left: 0;
            color: #ff7f00;
            font-weight: bold;
        }

        .upload-section {
            margin-bottom: 2rem;
        }

        .upload-section label {
            display: block;
            margin-bottom: 0.75rem;
            color: #cbd5e1;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .upload-section label .required {
            color: #ff7f00;
            margin-left: 4px;
        }

        .upload-section label .optional {
            color: #64748b;
            font-size: 0.85rem;
            margin-left: 4px;
            font-weight: 400;
        }

        .upload-area {
            border: 2px dashed rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 2.5rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: rgba(15, 20, 26, 0.3);
            position: relative;
            overflow: hidden;
        }

        .upload-area:hover {
            border-color: #ff7f00;
            background: rgba(15, 20, 26, 0.5);
            transform: translateY(-2px);
        }

        .upload-area.dragover {
            border-color: #ff7f00;
            background: rgba(255, 127, 0, 0.05);
        }

        .upload-icon {
            font-size: 2.5rem;
            color: #ff7f00;
            margin-bottom: 1rem;
            opacity: 0.8;
            transition: transform 0.3s ease;
        }

        .upload-area:hover .upload-icon {
            transform: scale(1.1);
            opacity: 1;
        }

        .upload-text {
            color: #ffffff;
            font-size: 1.05rem;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .upload-format {
            color: #64748b;
            font-size: 0.85rem;
        }

        .upload-input {
            display: none;
        }

        .file-preview {
            margin-top: 1rem;
            display: none;
        }

        .file-preview.show {
            display: block;
            animation: fadeIn 0.3s ease;
        }

        .file-preview-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem;
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.2);
            border-radius: 12px;
            margin-bottom: 0.5rem;
        }

        .file-name {
            color: #34d399;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .file-remove {
            background: rgba(239, 68, 68, 0.1);
            color: #f87171;
            border: 1px solid rgba(239, 68, 68, 0.2);
            padding: 0.4rem 0.8rem;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.85rem;
            transition: all 0.2s;
        }

        .file-remove:hover {
            background: rgba(239, 68, 68, 0.2);
            transform: scale(1.05);
        }

        .form-actions {
            display: flex;
            gap: 1.5rem;
            margin-top: 2.5rem;
        }

        .btn-back, .btn-submit {
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
        
        .btn-submit {
            background: linear-gradient(135deg, #ff7f00 0%, #ff5500 100%);
            color: white;
            box-shadow: 0 8px 20px rgba(255, 127, 0, 0.25);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(255, 127, 0, 0.35);
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
            .form-actions { flex-direction: column; }
            .auth-shell { padding: 1rem; }
            .form-card { padding: 1.5rem; }
            .progress-line { width: 150px; }
            .progress-step { width: 40px; height: 40px; font-size: 1rem; margin: 0 1.5rem; }
        }
    </style>
@endpush

@section('content')
    <div class="auth-shell">
        <div class="container">
            <!-- Progress Indicator -->
            <div class="progress-container">
                <div class="progress-line"></div>
                <div class="progress-step step-completed"><i class="fas fa-check"></i></div>
                <div class="progress-step step-completed"><i class="fas fa-check"></i></div>
                <div class="progress-step step-active">3</div>
            </div>

            <!-- Step Title -->
            <div class="step-title">
                <h1>Upload Dokumen</h1>
                <p>Upload dokumen pendukung untuk verifikasi</p>
            </div>

            <!-- Form Card -->
            <div class="form-card">
                <h2>Upload Dokumen Pendukung</h2>

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

                <div class="info-box">
                    <h4><i class="fas fa-info-circle"></i> Dokumen yang Diperlukan:</h4>
                    <ul>
                        <li>KTP pemilik kursus (wajib)</li>
                        <li>Izin usaha/SIUP (wajib)</li>
                        <li>Sertifikat instruktur (opsional)</li>
                        <li>Dokumen legal lainnya (opsional)</li>
                    </ul>
                </div>

                <form action="{{ route('register.step3.submit') }}" method="POST" enctype="multipart/form-data" id="step3Form">
                    @csrf

                    <!-- KTP Upload -->
                    <div class="upload-section">
                        <label for="ktp">
                            KTP Pemilik Kursus <span class="required">*</span>
                        </label>
                        <div class="upload-area" onclick="document.getElementById('ktp').click()" 
                             ondrop="handleDrop(event, 'ktp')" 
                             ondragover="handleDragOver(event)" 
                             ondragleave="handleDragLeave(event)">
                            <div class="upload-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                            <div class="upload-text">Klik atau tarik file KTP ke sini</div>
                            <div class="upload-format">Format: JPG, PNG, PDF (Max 5MB)</div>
                        </div>
                        <input type="file" id="ktp" name="ktp" class="upload-input" accept=".jpg,.jpeg,.png,.pdf" required onchange="handleFileSelect(this, 'ktp')">
                        <div id="ktp-preview" class="file-preview"></div>
                        @error('ktp')
                            <div class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Izin Usaha Upload -->
                    <div class="upload-section">
                        <label for="izin_usaha">
                            Izin Usaha/SIUP <span class="required">*</span>
                        </label>
                        <div class="upload-area" onclick="document.getElementById('izin_usaha').click()" 
                             ondrop="handleDrop(event, 'izin_usaha')" 
                             ondragover="handleDragOver(event)" 
                             ondragleave="handleDragLeave(event)">
                            <div class="upload-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                            <div class="upload-text">Klik atau tarik file Izin Usaha ke sini</div>
                            <div class="upload-format">Format: JPG, PNG, PDF (Max 5MB)</div>
                        </div>
                        <input type="file" id="izin_usaha" name="izin_usaha" class="upload-input" accept=".jpg,.jpeg,.png,.pdf" required onchange="handleFileSelect(this, 'izin_usaha')">
                        <div id="izin_usaha-preview" class="file-preview"></div>
                        @error('izin_usaha')
                            <div class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Sertifikat Instruktur Upload -->
                    <div class="upload-section">
                        <label for="sertif_instruktur">
                            Sertifikat Instruktur <span class="optional">(Opsional)</span>
                        </label>
                        <div class="upload-area" onclick="document.getElementById('sertif_instruktur').click()" 
                             ondrop="handleDrop(event, 'sertif_instruktur')" 
                             ondragover="handleDragOver(event)" 
                             ondragleave="handleDragLeave(event)">
                            <div class="upload-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                            <div class="upload-text">Klik atau tarik file Sertifikat ke sini</div>
                            <div class="upload-format">Format: JPG, PNG, PDF (Max 5MB)</div>
                        </div>
                        <input type="file" id="sertif_instruktur" name="sertif_instruktur" class="upload-input" accept=".jpg,.jpeg,.png,.pdf" onchange="handleFileSelect(this, 'sertif_instruktur')">
                        <div id="sertif_instruktur-preview" class="file-preview"></div>
                        @error('sertif_instruktur')
                            <div class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Dokumen Legal Upload -->
                    <div class="upload-section">
                        <label for="dokumen_legal">
                            Dokumen Legal Lainnya <span class="optional">(Opsional)</span>
                        </label>
                        <div class="upload-area" onclick="document.getElementById('dokumen_legal').click()" 
                             ondrop="handleDrop(event, 'dokumen_legal')" 
                             ondragover="handleDragOver(event)" 
                             ondragleave="handleDragLeave(event)">
                            <div class="upload-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                            <div class="upload-text">Klik atau tarik file Dokumen Lain ke sini</div>
                            <div class="upload-format">Format: JPG, PNG, PDF (Max 5MB per file)</div>
                        </div>
                        <input type="file" id="dokumen_legal" name="dokumen_legal" class="upload-input" accept=".jpg,.jpeg,.png,.pdf" onchange="handleFileSelect(this, 'dokumen_legal')">
                        <div id="dokumen_legal-preview" class="file-preview"></div>
                        @error('dokumen_legal')
                            <div class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('register.back', 3) }}" class="btn-back">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn-submit">
                            <span>Kirim Registrasi</span> <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function handleFileSelect(input, fieldName) {
            const file = input.files[0];
            if (file) {
                // Validate file size (5MB)
                if (file.size > 5 * 1024 * 1024) {
                    alert('File terlalu besar. Maksimal 5MB.');
                    input.value = '';
                    return;
                }

                // Validate file type
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Format file tidak didukung. Gunakan JPG, PNG, atau PDF.');
                    input.value = '';
                    return;
                }

                showFilePreview(file, fieldName);
            }
        }

        function showFilePreview(file, fieldName) {
            const preview = document.getElementById(fieldName + '-preview');
            preview.innerHTML = `
                <div class="file-preview-item">
                    <span class="file-name"><i class="fas fa-file-alt"></i> ${file.name}</span>
                    <button type="button" class="file-remove" onclick="removeFile('${fieldName}')">
                        <i class="fas fa-times"></i> Hapus
                    </button>
                </div>
            `;
            preview.classList.add('show');
        }

        function removeFile(fieldName) {
            const input = document.getElementById(fieldName);
            const preview = document.getElementById(fieldName + '-preview');
            input.value = '';
            preview.classList.remove('show');
            setTimeout(() => {
                preview.innerHTML = '';
            }, 300);
        }

        function handleDragOver(e) {
            e.preventDefault();
            e.stopPropagation();
            e.currentTarget.classList.add('dragover');
        }

        function handleDragLeave(e) {
            e.preventDefault();
            e.stopPropagation();
            e.currentTarget.classList.remove('dragover');
        }

        function handleDrop(e, fieldName) {
            e.preventDefault();
            e.stopPropagation();
            e.currentTarget.classList.remove('dragover');

            const files = e.dataTransfer.files;
            if (files.length > 0) {
                const input = document.getElementById(fieldName);
                input.files = files;
                handleFileSelect(input, fieldName);
            }
        }
    </script>
@endsection
