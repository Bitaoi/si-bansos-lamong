<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pemberitahuan Penyaluran Bansos</title>
    <style>
        /* Gaya font disesuaikan dengan surat resmi PT Pos (mirip Arial/Helvetica) */
        body { 
            font-family: Arial, Helvetica, sans-serif; 
            font-size: 10.5pt; 
            line-height: 1.3; 
            margin: 10px 20px; 
            color: #000; 
        }
        
        /* HEADER (LOGOS) */
        .header-logos { width: 100%; margin-bottom: 20px; border-bottom: 2px solid transparent; }
        .header-logos td { vertical-align: middle; }
        
        /* INFO SURAT (PEMBERITAHUAN & KEPADA) */
        .info-table { width: 100%; margin-bottom: 25px; }
        .info-table td { vertical-align: top; }
        .title-left { font-weight: bold; font-size: 12pt; margin-bottom: 5px; letter-spacing: 1px; }
        .title-right { font-weight: bold; font-size: 11pt; margin-bottom: 5px; letter-spacing: 1px; }
        
        /* KONTEN UTAMA */
        .content-text { text-align: justify; margin-bottom: 10px; line-height: 1.4; }
        .rules-list { margin-top: 10px; padding-left: 20px; text-align: justify; line-height: 1.4; }
        .rules-list li { margin-bottom: 10px; }
        
        /* KOTAK TABEL UTAMA (BARCODE & NOMINAL) */
        .box-tabel { width: 100%; border-collapse: collapse; margin-top: 15px; margin-bottom: 10px; }
        .box-tabel td { border: 1px solid #000; padding: 12px; vertical-align: middle; }
        .col-tahap { width: 18%; text-align: center; font-weight: bold; font-size: 10pt;}
        .col-data { width: 57%; font-family: 'Courier New', Courier, monospace; font-size: 12pt; line-height: 1.5;}
        .col-qr { width: 25%; text-align: center; }
        
        /* SIMULASI BARCODE LINEAR */
        .barcode-fake { 
            font-family: 'Courier New', Courier, monospace; 
            font-weight: bold; 
            letter-spacing: -2px; 
            font-size: 16pt; 
            margin-bottom: 5px; 
            display: block;
        }

        /* TANDA TANGAN */
        .footer-note { font-size: 10pt; margin-bottom: 20px; }
        .sign-table { width: 100%; margin-top: 10px; }
        .sign-table td { vertical-align: bottom; }
        .ttd-box { border-collapse: collapse; width: 100%; text-align: center; }
        .ttd-box td { border: 1px solid #000; height: 90px; vertical-align: top; padding: 5px; font-size: 10pt; }
        .nama-penerima { margin-top: 45px; text-transform: uppercase; font-size: 9pt; }
    </style>
</head>
<body>

    <!-- 1. BAGIAN LOGO -->
    <!-- Catatan: Jika ada gambar logo asli, ganti teks di bawah dengan tag <img src="..."> -->
    <table class="header-logos">
        <tr>
            <td width="33%" style="text-align: left;">
                <strong style="font-size: 18pt; font-family: 'Arial Black', sans-serif; letter-spacing: -1px;">POS <br> IND</strong><br>
                <span style="font-size: 7pt; font-style: italic;">Logistik Indonesia</span>
            </td>
            <td width="33%" style="text-align: center;">
                <strong style="font-size: 14pt;">[ GARUDA ]</strong>
            </td>
            <td width="33%" style="text-align: right;">
                <strong style="font-size: 12pt; color: #555;">[ KEMENSOS RI ]</strong>
            </td>
        </tr>
    </table>

    <!-- 2. BAGIAN INFORMASI SURAT -->
    <table class="info-table">
        <tr>
            <td width="60%">
                <div class="title-left">PEMBERITAHUAN</div>
                Nomor Danom : 64200/{{ $pengajuan->warga->nik }}/14<br>
                BATCH (MA-A02) / {{ \Carbon\Carbon::now()->format('Y-m-d') }}
            </td>
            <td width="40%">
                <div class="title-right">KEPADA :</div>
                <div style="text-transform: uppercase;">
                    {{ $pengajuan->warga->nama_lengkap }}<br>
                    {{ $pengajuan->warga->alamat }}<br>
                    RT/RW: {{ $pengajuan->pengusul->wilayah_rt_rw ?? '-' }}<br>
                    DESA LAMONG, KEC. ...
                </div>
            </td>
        </tr>
    </table>

    <!-- 3. KONTEN TEKS & ATURAN -->
    <div class="content-text">
        Dengan Hormat,
        <br><br>
        Berdasarkan Keputusan Pemerintah Republik Indonesia c.q. Kementerian Sosial Republik Indonesia, Bapak/Ibu/Sdr/i dinyatakan berhak memperoleh dana Bantuan Sosial Tahun {{ date('Y') }} dari Kementerian Sosial RI dengan rincian dana bantuan sesuai tabel di bawah. Harap menjadi perhatian Bapak/Ibu penerima Bantuan Sosial:
    </div>

    <ol class="rules-list">
        <li>Persyaratan pengambilan/penerimaan Bantuan Sosial Tahun {{ date('Y') }} dengan menunjukan KTP-el dan/atau Kartu Keluarga asli. Bila pengurus adalah laki-laki maka dihimbau yang melakukan pengambilan adalah wanita dalam 1 KK;</li>
        <li>Penggunaan dana Bantuan Sosial Tahun {{ date('Y') }} tidak diperkenankan untuk membeli rokok, minuman keras dan narkotika;</li>
        <li>Penyaluran dana Bantuan Sosial Tahun {{ date('Y') }} diberikan tanpa ada potongan apapun dan oleh pihak manapun. Jika ada pemotongan dana Bantuan Sosial Tahun {{ date('Y') }} oleh Petugas Kantorpos silahkan laporkan dengan menghubungi nomor WA 0812-3364-7686 (PT Pos Indonesia) atau Command Center 171 (Kemensos RI) dengan melampirkan bukti terkait.</li>
    </ol>

    <div class="content-text" style="margin-top: 15px;">
        Berikut adalah alokasi pembayaran Bantuan Sosial untuk Bapak/Ibu/Sdr/i:
    </div>

    <!-- 4. KOTAK DATA & BARCODE -->
    <table class="box-tabel">
        <tr>
            <td class="col-tahap">
                TAHAP I<br>
                JAN - MAR
            </td>
            <td class="col-data">
                <!-- Simulasi Barcode Linear -->
                <span class="barcode-fake">|| |||| || | ||| | || || ||</span>
                
                NIK : {{ $pengajuan->warga->nik }}<br>
                PSP{{ $pengajuan->warga->nik }}B<br>
                <strong>Rp. {{ $pengajuan->jenisBansos->nominal }}</strong><br>
                <span style="font-size: 10pt;">{{ strtoupper($pengajuan->jenisBansos->nama_bansos) }} : {{ $pengajuan->jenisBansos->nominal }}</span>
            </td>
            <td class="col-qr">
                <!-- QR Code Validasi yang asli dari sistem kita -->
                <img src="data:image/svg+xml;base64,{{ $qrcode }}" width="90">
            </td>
        </tr>
    </table>

    <div class="footer-note">
        Harap surat pemberitahuan ini disimpan dengan baik, karena akan digunakan untuk bukti pembayaran.
    </div>

    <!-- 5. TANDA TANGAN -->
    <table class="sign-table">
        <tr>
            <td width="55%">
                Hormat Kami,<br><br><br><br><br>
                PT Pos Indonesia (Persero)
            </td>
            <td width="45%">
                <table class="ttd-box">
                    <tr>
                        <td width="60%">
                            Tanda Tangan Penerima
                            <div class="nama-penerima">{{ $pengajuan->warga->nama_lengkap }}</div>
                        </td>
                        <td width="40%">
                            Paraf Petugas
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</body>
</html>