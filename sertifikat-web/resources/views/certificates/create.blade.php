<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Buat Sertifikat | Selara Realti</title>
    <style>
        @font-face {
            font-family: "Great Vibes";
            src: url("{{ asset('fonts/GreatVibes-Regular.ttf') }}") format("truetype");
            font-display: swap;
        }

        :root {
            color-scheme: light;
            --ink: #173d31;
            --muted: #718078;
            --green: #286b54;
            --green-dark: #174c3b;
            --line: #e4ebe6;
            --paper: #fff;
            --canvas: #f3f6f3;
            --danger: #a33c36;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            color: var(--ink);
            background: var(--canvas);
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-height: 76px;
            padding: 0 clamp(20px, 5vw, 72px);
            background: var(--paper);
            border-bottom: 1px solid var(--line);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--green-dark);
            font-family: Georgia, "Times New Roman", serif;
            font-size: 19px;
            font-weight: 700;
            letter-spacing: .035em;
        }

        .brand-mark {
            display: grid;
            width: 38px;
            height: 38px;
            place-items: center;
            color: white;
            background: var(--green);
            border-radius: 12px;
            font-size: 19px;
        }

        .topbar-note {
            color: var(--muted);
            font-size: 13px;
        }

        main {
            width: min(1440px, 100%);
            margin: 0 auto;
            padding: 44px clamp(20px, 5vw, 72px) 64px;
        }

        .intro { margin-bottom: 28px; }

        .eyebrow {
            margin: 0 0 10px;
            color: var(--green);
            font-size: 11px;
            font-weight: 750;
            letter-spacing: .16em;
            text-transform: uppercase;
        }

        h1 {
            margin: 0;
            font-family: Georgia, "Times New Roman", serif;
            font-size: clamp(30px, 4vw, 42px);
            font-weight: 500;
            letter-spacing: -.035em;
        }

        .intro-copy {
            max-width: 560px;
            margin: 12px 0 0;
            color: var(--muted);
            font-size: 15px;
            line-height: 1.65;
        }

        .workspace {
            display: grid;
            grid-template-columns: minmax(310px, 390px) minmax(0, 1fr);
            gap: 24px;
            align-items: start;
        }

        .panel {
            padding: 26px;
            background: var(--paper);
            border: 1px solid var(--line);
            border-radius: 18px;
            box-shadow: 0 10px 30px rgb(24 61 48 / 4%);
        }

        .panel-heading {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
        }

        .panel-subtitle {
            margin: 7px 0 24px;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.5;
        }

        .field { margin-bottom: 19px; }

        label {
            display: block;
            margin-bottom: 8px;
            color: #30483e;
            font-size: 13px;
            font-weight: 650;
        }

        input {
            width: 100%;
            min-height: 46px;
            padding: 0 13px;
            color: var(--ink);
            background: #fcfdfc;
            border: 1px solid #dce5de;
            border-radius: 9px;
            font: inherit;
            font-size: 14px;
            transition: border-color .15s, box-shadow .15s;
        }

        input:focus {
            outline: none;
            border-color: #579477;
            box-shadow: 0 0 0 3px rgb(57 125 94 / 12%);
        }

        .error {
            margin: 7px 0 0;
            color: var(--danger);
            font-size: 12px;
        }

        .signature-note {
            display: flex;
            align-items: center;
            gap: 11px;
            margin: 4px 0 23px;
            padding: 12px;
            color: #4c6257;
            background: #f5f8f5;
            border: 1px solid #e7eee8;
            border-radius: 10px;
            font-size: 12px;
            line-height: 1.45;
        }

        .signature-note img {
            width: 43px;
            height: 33px;
            object-fit: contain;
        }

        .submit-button {
            display: flex;
            width: 100%;
            min-height: 49px;
            align-items: center;
            justify-content: center;
            gap: 9px;
            padding: 0 16px;
            color: white;
            background: var(--green);
            border: 0;
            border-radius: 10px;
            cursor: pointer;
            font: inherit;
            font-size: 14px;
            font-weight: 700;
            transition: background .15s, transform .15s;
        }

        .submit-button:hover {
            background: var(--green-dark);
            transform: translateY(-1px);
        }

        .privacy-note {
            margin: 13px 0 0;
            color: #89958e;
            font-size: 11px;
            line-height: 1.5;
            text-align: center;
        }

        .preview-panel { padding: 22px; }

        .preview-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin: 0 0 17px;
        }

        .preview-heading h2 {
            margin: 0;
            font-size: 14px;
            font-weight: 700;
        }

        .live-tag {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 6px 9px;
            color: var(--green);
            background: #edf6ef;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 700;
        }

        .live-dot {
            width: 6px;
            height: 6px;
            background: #49a16f;
            border-radius: 50%;
        }

        .certificate {
            position: relative;
            overflow: hidden;
            width: 100%;
            aspect-ratio: 842.25 / 595.5;
            container-type: inline-size;
            background: #f3fbf7;
            box-shadow: 0 8px 24px rgb(25 50 39 / 12%);
        }

        .certificate > img.template {
            display: block;
            width: 100%;
            height: 100%;
        }

        .certificate-text {
            position: absolute;
            left: 50%;
            width: 84%;
            margin: 0;
            color: #28604d;
            font-family: Georgia, "Times New Roman", serif;
            text-align: center;
            transform: translateX(-50%);
        }

        .certificate-mask {
            position: absolute;
            left: 50%;
            background: #f6fffb;
            transform: translateX(-50%);
        }

        .certificate-mask-date {
            top: 63%;
            width: 42.1%;
            height: 3.1%;
        }

        .certificate-mask-signer {
            top: 82.9%;
            width: 22.9%;
            height: 5.2%;
        }

        .certificate-recipient {
            top: 42%;
            overflow-wrap: anywhere;
            font-family: "Great Vibes", cursive;
            font-size: clamp(40px, 9cqw, 66px);
            font-weight: 400;
            line-height: 1;
        }

        .certificate-date {
            top: 63%;
            font-size: clamp(7px, 1.25cqw, 10px);
            font-weight: 700;
        }

        .certificate-signature {
            position: absolute;
            top: 71.1%;
            left: 50%;
            width: 13.5%;
            height: 11.6%;
            object-fit: contain;
            transform: translateX(-50%);
        }

        .certificate-signer {
            top: 84.4%;
            font-size: clamp(8px, 1.4cqw, 11px);
            font-weight: 700;
        }

        .preview-caption {
            margin: 14px 2px 0;
            color: var(--muted);
            font-size: 11px;
            line-height: 1.5;
        }

        @media (max-width: 900px) {
            main { padding-top: 34px; }
            .workspace { grid-template-columns: 1fr; }
            .panel { padding: 22px; }
            .preview-panel { grid-row: 1; }
        }

        @media (max-width: 520px) {
            .topbar { min-height: 64px; }
            .topbar-note { display: none; }
            main { padding: 28px 16px 42px; }
            .panel, .preview-panel { padding: 17px; border-radius: 14px; }
            .certificate-recipient { font-size: clamp(12px, 3.2cqw, 17px); }
            .certificate-date { font-size: clamp(6px, 1.15cqw, 8px); }
        }
    </style>
</head>
<body>
    <header class="topbar">
        <div class="brand">
            <span class="brand-mark" aria-hidden="true">S</span>
            <span>SELARA REALTI</span>
        </div>
        <span class="topbar-note">Generator sertifikat penghargaan</span>
    </header>

    <main>
        <section class="intro" aria-labelledby="page-title">
            <p class="eyebrow">Dokumen penghargaan</p>
            <h1 id="page-title">Buat sertifikat</h1>
            <p class="intro-copy">Isi informasi penerima dan penanda tangan. Sertifikat akan dibuat dari template resmi dan siap diunduh sebagai PDF.</p>
        </section>

        <div class="workspace">
            <section class="panel" aria-labelledby="form-title">
                <h2 class="panel-heading" id="form-title">Informasi sertifikat</h2>
                <p class="panel-subtitle">Lengkapi data berikut untuk melihat pratinjau dan membuat sertifikat.</p>

                <form method="POST" action="{{ route('certificates.generate') }}">
                    @csrf

                    <div class="field">
                        <label for="recipient_name">Nama penerima</label>
                        <input
                            id="recipient_name"
                            name="recipient_name"
                            type="text"
                            maxlength="100"
                            autocomplete="name"
                            placeholder="Contoh: Adrian Prasetya"
                            value="{{ old('recipient_name') }}"
                            required
                        >
                        @error('recipient_name')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="issued_at">Tanggal diberikan</label>
                        <input
                            id="issued_at"
                            name="issued_at"
                            type="date"
                            value="{{ old('issued_at', now()->toDateString()) }}"
                            required
                        >
                        @error('issued_at')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="signer_name">Nama penanda tangan</label>
                        <input
                            id="signer_name"
                            name="signer_name"
                            type="text"
                            maxlength="100"
                            autocomplete="off"
                            value="{{ old('signer_name', 'Brenda Soetjipto') }}"
                            required
                        >
                        @error('signer_name')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="signature-note">
                        <img src="{{ asset('images/signature.png') }}" alt="">
                        <span>Tanda tangan digital yang disertakan akan tampil di atas nama penanda tangan.</span>
                    </div>

                    <button class="submit-button" type="submit">
                        <span aria-hidden="true">↓</span>
                        Buat dan unduh PDF
                    </button>
                    <p class="privacy-note">Data yang diisi hanya digunakan untuk membuat sertifikat ini.</p>
                </form>
            </section>

            <section class="panel preview-panel" aria-labelledby="preview-title">
                <div class="preview-heading">
                    <h2 id="preview-title">Pratinjau sertifikat</h2>
                    <span class="live-tag"><span class="live-dot"></span> LANGSUNG</span>
                </div>
                <div class="certificate" aria-label="Pratinjau sertifikat">
                    <img class="template" src="{{ asset('images/certificate-template.png') }}" alt="">
                    <span class="certificate-mask certificate-mask-date" aria-hidden="true"></span>
                    <span class="certificate-mask certificate-mask-signer" aria-hidden="true"></span>
                    <p class="certificate-text certificate-recipient" id="preview-recipient" aria-live="polite">Nama penerima</p>
                    <p class="certificate-text certificate-date" id="preview-date"></p>
                    <img class="certificate-signature" src="{{ asset('images/signature.png') }}" alt="">
                    <p class="certificate-text certificate-signer" id="preview-signer"></p>
                </div>
                <p class="preview-caption">Pratinjau ini mengikuti template sertifikat. Hasil unduhan berupa PDF A4 landscape.</p>
            </section>
        </div>
    </main>

    <script>
        const recipientInput = document.querySelector('#recipient_name');
        const dateInput = document.querySelector('#issued_at');
        const signerInput = document.querySelector('#signer_name');
        const recipientPreview = document.querySelector('#preview-recipient');
        const datePreview = document.querySelector('#preview-date');
        const signerPreview = document.querySelector('#preview-signer');

        function updatePreview() {
            recipientPreview.textContent = recipientInput.value.trim() || 'Nama penerima';
            signerPreview.textContent = signerInput.value.trim();

            if (dateInput.value) {
                const [year, month, day] = dateInput.value.split('-').map(Number);
                datePreview.textContent = `Diberikan pada ${new Intl.DateTimeFormat('id-ID', {
                    day: '2-digit',
                    month: 'long',
                    year: 'numeric',
                    timeZone: 'UTC',
                }).format(new Date(Date.UTC(year, month - 1, day)))}.`;
            } else {
                datePreview.textContent = 'Pilih tanggal pemberian';
            }
        }

        [recipientInput, dateInput, signerInput].forEach((input) => {
            input.addEventListener('input', updatePreview);
            input.addEventListener('change', updatePreview);
        });

        updatePreview();
    </script>
</body>
</html>
