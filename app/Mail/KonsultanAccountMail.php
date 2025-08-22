<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class KonsultanAccountMail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $username;
    public $password;

    public function __construct($email, $username, $password)
    {
        $this->email = $email;
        $this->username = $username;
        $this->password = $password;
    }

    public function build()
    {
        return $this->subject('Akun Konsultan Anda')
                    ->view('emails.konsultan_account');
    }
}
