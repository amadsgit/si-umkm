<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class JadwalKonsultasiMail extends Mailable
{
    use Queueable, SerializesModels;

    public $jadwal;
    public $role; // 'umkm' atau 'konsultan'

    public function __construct($jadwal, $role)
    {
        $this->jadwal = $jadwal;
        $this->role = $role;
    }

    public function build()
    {
        return $this->subject('Jadwal Konsultasi Anda')
                    ->markdown('emails.jadwal_konsultasi');
    }
}
