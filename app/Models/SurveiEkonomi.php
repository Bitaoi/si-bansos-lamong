<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SurveiEkonomi extends Model 
{
    // Mengizinkan semua kolom untuk diisi secara massal
    protected $guarded = [];

    public function pengajuan() {
        return $this->belongsTo(Pengajuan::class);
    }

    // Accessor agar saat diakses, JSON string otomatis berubah menjadi array
    public function getFotoLantaiAttribute($value) { return json_decode($value, true) ?? []; }
    public function getFotoDindingAttribute($value) { return json_decode($value, true) ?? []; }
    public function getFotoSumberAirAttribute($value) { return json_decode($value, true) ?? []; }
    
    // PERBAIKAN: Penamaan disesuaikan dengan kolom 'foto_wc_air'
    public function getFotoWcAirAttribute($value) { return json_decode($value, true) ?? []; }
    
    public function getFotoListrikAttribute($value) { return json_decode($value, true) ?? []; }
    public function getFotoKendaraanAttribute($value) { return json_decode($value, true) ?? []; }
    public function getFotoElektronikAttribute($value) { return json_decode($value, true) ?? []; }
    public function getFotoTernakAttribute($value) { return json_decode($value, true) ?? []; }

    /**
     * Algoritma Perhitungan Desil (Metode Ambang Batas / Skor Real-time)
     */
    public static function kalkulasiDesil($data)
    {
        $skor = 0;

        // A. KONDISI TEMPAT TINGGAL
        $skor += ($data['luas_lantai'] == '< 8 m² per orang') ? 0 : 10;
        
        if ($data['jenis_lantai'] == 'Tanah / Bambu') $skor += 0;
        elseif ($data['jenis_lantai'] == 'Semen / Plester') $skor += 5;
        elseif ($data['jenis_lantai'] == 'Keramik / Marmer') $skor += 15;

        if ($data['jenis_dinding'] == 'Bilik Bambu / Kayu Murah') $skor += 0;
        elseif ($data['jenis_dinding'] == 'Tembok Tanpa Plester') $skor += 5;
        elseif ($data['jenis_dinding'] == 'Tembok Bagus / Semen') $skor += 10;

        if ($data['sumber_air'] == 'Sungai / Mata Air') $skor += 0;
        elseif ($data['sumber_air'] == 'Sumur / Pompa') $skor += 5;
        elseif ($data['sumber_air'] == 'PDAM') $skor += 10;

        if ($data['daya_listrik'] == '450 Watt (Subsidi)') $skor += 0;
        elseif ($data['daya_listrik'] == '900 Watt (Subsidi)') $skor += 5;
        elseif ($data['daya_listrik'] == '900 Watt (Non-Subsidi) / 1300+') $skor += 20;

        // B. KEPEMILIKAN ASET
        if ($data['kendaraan'] == 'Tidak punya') $skor += 0;
        elseif ($data['kendaraan'] == 'Sepeda / 1 Motor Butut') $skor += 5;
        elseif ($data['kendaraan'] == '1 Motor Baru (Kredit/Lunas)') $skor += 15;
        elseif ($data['kendaraan'] == 'Mobil') $skor += 50; // Langsung tinggi

        if ($data['elektronik'] == 'Tidak ada Kulkas/TV') $skor += 0;
        elseif ($data['elektronik'] == 'Ada Kulkas / TV Tabung') $skor += 5;
        elseif ($data['elektronik'] == 'Ada AC / TV Layar Datar Besar') $skor += 15;

        if ($data['ternak_lahan'] == 'Tidak punya') $skor += 0;
        elseif ($data['ternak_lahan'] == 'Punya ternak kambing/sapi') $skor += 10;

        // C. SOSIAL EKONOMI KK
        if ($data['pendidikan_kk'] == 'SD / Tidak Sekolah') $skor += 0;
        elseif ($data['pendidikan_kk'] == 'SMP/SMA') $skor += 5;
        elseif ($data['pendidikan_kk'] == 'Kuliah (D3/S1)') $skor += 15;

        if ($data['pekerjaan'] == 'Buruh Tani / Serabutan') $skor += 0;
        elseif ($data['pekerjaan'] == 'Karyawan Swasta / Pedagang Kecil') $skor += 10;
        elseif ($data['pekerjaan'] == 'PNS / TNI / POLRI') $skor += 50;

        if ($data['jml_tanggungan'] == 'Banyak (> 3 anak/lansia)') $skor -= 5;
        elseif ($data['jml_tanggungan'] == 'Sedikit (1-2 orang)') $skor += 0;

        // PENENTUAN DESIL (Cara B: Ambang Batas Nilai)
        if ($skor <= 25) {
            $desil = 1; // Sangat Miskin
        } elseif ($skor <= 40) {
            $desil = 2; // Miskin
        } elseif ($skor <= 55) {
            $desil = 3; // Hampir Miskin
        } elseif ($skor <= 70) {
            $desil = 4; // Rentan Miskin
        } else {
            $desil = 5; // Desil 5 ke atas (Mampu / Tidak Layak)
        }

        return [
            'total_skor' => $skor,
            'desil' => $desil
        ];
    }
}