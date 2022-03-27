<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Storage;
use Closure;
use Illuminate\Http\Request;

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
        if(session()->missing('akun.nik')){return redirect('/masuk');}// <-Jika tidak ada sesi/session NIK maka kembali ke masuk/login
        // *Menyimpan data sesi/session akun
        $sesiAkun=[session()->get('akun.nik'),session()->get('akun.nama')];// <-Simpan NIK dan Nama
        
        // *Membandingkan data data sesi/session akun dengan setiap baris/row data config
        $config_temp=Storage::get('public/docs/config.txt');// <-Ambil semua data config
        $config_rows=explode("\n",$config_temp);// <-Bagi setiap baris/row data config
        foreach ($config_rows as $config_row) {// <-Bandingkan dari baris/row pertama pada data config
            $config_row_value=explode('|',$config_row);// <-Memilah baris/row tersebut menjadi NIK dan Nama
            if ($config_row_value==$sesiAkun){// <-Periksa data formulir tersebut jika ada yang sama pada data config
                return $next($request);// <-Lanjut ke halaman yang dituju
            }
        }

        // *Ketahuan memakai sesi/session palsu/hack
        session()->flush();// <-Hapus semua sesi/session yang tersimpan
        return redirect('/masuk');// <-Pergi ke halaman masuk/login
    }
}
