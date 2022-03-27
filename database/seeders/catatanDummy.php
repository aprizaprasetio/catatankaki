<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
|
| Aplikasi Peduli Diri
| Disusun oleh Apriza Prasetio
|
|--------------------------------------------------------------------------
|
| Instagram : @aprizaprasetio
| Youtube : Apriza Prasetio
|
|--------------------------------------------------------------------------
*/

class catatanDummy extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 30; $i++) { 
            // *Menyimpan data formulir isi catatan perjalanan
            $isi_data=[// <-Simpan data formulir dalam bentuk array
                'tanggal'=>Carbon::today()->subDays(rand(0, 365))->format('Y-m-d'),// <-Simpan tanggal
                'jam'=>Carbon::now()->subMinute(rand(0, 3000))->format('H:i'),// <-Simpan waktu jam
                'lokasi'=>Str::random(15),// <-Simpan lokasi perjalanan
                'suhu'=>random_int(3, 15),// <-Simpan suhu tubuh
                'penyimpanan'=>'public/docs/'.'9999'.'.txt',// <-Simpan lokasi/path penyimpanan
            ];
            $isi_data_row=$isi_data['tanggal'].'|'.$isi_data['jam'].'|'.$isi_data['lokasi'].'|'.$isi_data['suhu'];// <-Simpan semua data formulir untuk disimpan pada penyimpanan
    
            // *Mengelola data config dan penyimpanan akun
            if (Storage::size($isi_data['penyimpanan'])==0) {// <-Jika penyimpanan masih kosong
                Storage::put($isi_data['penyimpanan'], $isi_data_row);// <-Timpa/replace dengan data formulir
            } else {// <-Jika tidak/penyimpanan sudah ada isinya
                Storage::prepend($isi_data['penyimpanan'], $isi_data_row);// <-Tambah data formulir pada penyimpanan
            }
        }
    }
}
