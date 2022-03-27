<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Storage;
use Closure;
use Illuminate\Http\Request;

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

class autentikasiMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {   
        if (session()->missing('akun')) { return redirect('/masuk'); }// <-Jika tidak ada sesi/session NIK maka kembali ke masuk/login
        // *Menyimpan data sesi/session akun
        $sesiAkun=[session()->get('akun.nik'),session()->get('akun.nama')];// <-Simpan NIK dan Nama

        // *Memeriksa akun/account palsu/hack
        $penyimpanan='public/docs/'.$sesiAkun[0].'.txt';// <-Simpan lokasi/path penyimpanan
        if (Storage::missing($penyimpanan)) {// <<-Jika penyimpanan tidak ada
            session()->flush();// <-Hapus semua sesi/session
            return redirect('/masuk')->with('gagal','Akun anda terdaftar secara ilegal!');// <-Kembali ke halaman sebelumnya/masuk/login
        }

        // *Membandingkan data sesi/session akun dengan setiap baris/row data config
        $config_temp=Storage::get('public/docs/config.txt');// <-Ambil semua data config
        $config_rows=explode(PHP_EOL,$config_temp);// <-Bagi setiap baris/row data config
        foreach ($config_rows as $config_row) {// <-Bandingkan dari baris/row pertama pada data config
            $config_row_value=explode('|',$config_row);// <-Memilah baris/row tersebut menjadi NIK dan Nama
            if ($config_row_value==$sesiAkun){// <-Periksa data formulir tersebut jika ada yang sama pada data config
                return $next($request);// <-Lanjut ke halaman yang dituju
            }
        }

        // *Ketahuan memakai sesi/session palsu/hack
        if (session()->has('akun')) { session()->flush(); }// <-Jika ada sesi/session NIK maka semua sesi/session terhapus
        return redirect('/masuk')->with('gagal','Akun anda tidak terdaftar!');// <-Pergi ke halaman masuk/login
    }
}
