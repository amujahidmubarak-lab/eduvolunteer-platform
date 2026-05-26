<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Sertifikat - {{ $user->name }}</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Montserrat:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,400&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@0.460.0"></script>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f3f4f6;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100-screen;
            padding: 20px;
        }

        /* Certificate Container */
        .certificate-container {
            width: 297mm;
            height: 210mm;
            background-color: #ffffff;
            position: relative;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 50px;
            /* If template is uploaded, set it as background */
            @if($templatePath)
                background-image: url('{{ url($templatePath) }}');
                background-size: cover;
                background-position: center;
            @else
                /* Default Fallback Background Design */
                border: 20px solid #1e3a8a; /* Deep Navy Navy */
                background: radial-gradient(circle, #ffffff 60%, #f0fdf4 100%);
            @endif
        }

        /* Default fallback borders/accents if no template */
        @if(!$templatePath)
        .certificate-border-inner {
            position: absolute;
            top: 15px;
            left: 15px;
            right: 15px;
            bottom: 15px;
            border: 2px solid #d97706; /* Gold */
            pointer-events: none;
        }
        .certificate-corner-tl {
            position: absolute;
            top: 25px;
            left: 25px;
            width: 80px;
            height: 80px;
            border-top: 5px solid #d97706;
            border-left: 5px solid #d97706;
        }
        .certificate-corner-br {
            position: absolute;
            bottom: 25px;
            right: 25px;
            width: 80px;
            height: 80px;
            border-bottom: 5px solid #d97706;
            border-right: 5px solid #d97706;
        }
        @endif

        /* Certificate Content overlay */
        .certificate-content {
            position: relative;
            z-index: 10;
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            height: 100%;
            justify-content: space-between;
            padding: 40px 60px;
        }

        .header-logo {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 16px;
            color: #1e3a8a;
            letter-spacing: 3px;
            text-transform: uppercase;
        }

        .cert-title {
            font-family: 'Playfair Display', serif;
            font-size: 44px;
            font-weight: 700;
            color: #1e3a8a;
            margin-top: 10px;
            letter-spacing: 2px;
        }

        .cert-subtitle {
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 4px;
            color: #d97706;
            font-weight: 600;
            margin-top: 5px;
        }

        .presented-to {
            font-size: 14px;
            font-style: italic;
            color: #6b7280;
            margin-top: 20px;
        }

        .recipient-name {
            font-family: 'Great Vibes', cursive;
            font-size: 56px;
            color: #1e3a8a;
            margin-top: 10px;
            border-bottom: 2px solid #d97706;
            padding-bottom: 5px;
            min-width: 400px;
        }

        .cert-text {
            font-size: 13px;
            line-height: 1.8;
            color: #4b5563;
            max-width: 750px;
            margin-top: 20px;
        }

        /* Signatures & Verification */
        .footer-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            width: 100%;
            margin-top: auto;
        }

        .signature-block {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 200px;
        }

        .signature-line {
            width: 100%;
            border-bottom: 1px solid #9ca3af;
            margin-bottom: 8px;
        }

        .signature-title {
            font-size: 10px;
            font-weight: 600;
            color: #4b5563;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .signature-dept {
            font-size: 9px;
            color: #9ca3af;
            text-transform: uppercase;
        }

        .verification-block {
            display: flex;
            align-items: center;
            gap: 12px;
            background-color: rgba(255, 255, 255, 0.8);
            padding: 8px 12px;
            border-radius: 12px;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .qr-code {
            width: 65px;
            height: 65px;
            border: 1px solid #e5e7eb;
        }

        .verification-text {
            text-align: left;
            font-size: 9px;
            color: #6b7280;
            max-width: 140px;
            line-height: 1.4;
        }

        /* Action floating bar */
        .action-bar {
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background-color: #2563eb;
            color: #ffffff;
            font-weight: 600;
            font-size: 13px;
            padding: 10px 20px;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(37, 99, 235, 0.2);
            transition: all 0.2s;
            text-decoration: none;
        }

        .btn:hover {
            background-color: #1d4ed8;
            transform: translateY(-1px);
        }

        .btn-secondary {
            background-color: #ffffff;
            color: #374151;
            border: 1px solid #d1d5db;
            box-shadow: none;
        }

        .btn-secondary:hover {
            background-color: #f9fafb;
            color: #111827;
        }

        /* Print Media Styles */
        @media print {
            body {
                background-color: #ffffff;
                padding: 0;
                margin: 0;
            }

            .action-bar {
                display: none !important;
            }

            .certificate-container {
                box-shadow: none !important;
                border: none !important;
                width: 297mm;
                height: 210mm;
                page-break-inside: avoid;
            }
        }

        @page {
            size: A4 landscape;
            margin: 0;
        }
    </style>
</head>
<body>

    <!-- Action Bar -->
    <div class="action-bar no-print">
        <a href="{{ route('volunteer.profile') }}" class="btn btn-secondary">
            <i data-lucide="arrow-left" style="width: 16px; height: 16px;"></i>
            <span>Kembali ke Profil</span>
        </a>
        <button onclick="window.print()" class="btn">
            <i data-lucide="printer" style="width: 16px; height: 16px;"></i>
            <span>Cetak / Simpan PDF</span>
        </button>
    </div>

    <!-- Certificate Box -->
    <div class="certificate-container">
        @if(!$templatePath)
            <!-- Elegant Corner Frames (Only if no custom template) -->
            <div class="certificate-border-inner"></div>
            <div class="certificate-corner-tl"></div>
            <div class="certificate-corner-br"></div>
        @endif

        <div class="certificate-content">
            <!-- Header Logo (only shown if no template background to keep it clean) -->
            @if(!$templatePath)
                <div class="header-logo">
                    MALANG MENGAJAR
                </div>
            @else
                <!-- Spacer to push content down if background template is used -->
                <div style="height: 30px;"></div>
            @endif

            <div>
                @if(!$templatePath)
                    <div class="cert-title">SERTIFIKAT PENGHARGAAN</div>
                    <div class="cert-subtitle">Certificate of Appreciation</div>
                @else
                    <!-- Spacer if template has title -->
                    <div style="height: 40px;"></div>
                @endif
                
                <div class="presented-to">Diberikan kepada:</div>
                <div class="recipient-name">{{ $user->name }}</div>
            </div>

            <div class="cert-text">
                Atas dedikasi, kontribusi, dan partisipasi aktifnya sebagai **Relawan Pengajar (Volunteer)** dalam program peningkatan mutu pendidikan literasi dan numerasi dasar sekolah dasar se-Malang Raya yang diselenggarakan oleh Gerakan Mahasiswa **Malang Mengajar {{ \App\Models\Setting::getValue('current_batch', 'Batch 5') }}**.
            </div>

            <div class="footer-row">
                <!-- Signature left -->
                <div class="signature-block">
                    <div style="height: 50px;"></div> <!-- Spacer for signature -->
                    <div class="signature-line"></div>
                    <div class="signature-title">Ketua Malang Mengajar</div>
                    <div class="signature-dept">Batch V</div>
                </div>

                <!-- QR Code Verification -->
                <div class="verification-block">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode($verificationUrl) }}" alt="Verification QR" class="qr-code">
                    <div class="verification-text">
                        <strong>Verifikasi Sertifikat Resmi:</strong><br>
                        Pindai kode QR untuk memvalidasi keaslian sertifikat ini di portal Malang Mengajar.
                    </div>
                </div>

                <!-- Signature right -->
                <div class="signature-block">
                    <div style="height: 50px;"></div> <!-- Spacer for signature -->
                    <div class="signature-line"></div>
                    <div class="signature-title">Ketua Divisi Sosma</div>
                    <div class="signature-dept">Malang Mengajar</div>
                </div>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
