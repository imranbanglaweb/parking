<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Exception;
class registrationMail extends Mailable
{
    use Queueable, SerializesModels;
    private $details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */

    public function build()
    {
        //dd($this->details['name']);
        return $this->from('amirul1313.diu@gmail.com')
            ->subject($this->details['subject'])
            ->view('vendor.mail.html.registration-mail',['details'=>$this->details]);
    }
}
