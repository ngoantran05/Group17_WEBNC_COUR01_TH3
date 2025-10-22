<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data; // Biến này sẽ chứa dữ liệu từ form

    /**
     * Create a new message instance.
     * @param array $data Dữ liệu từ form (name, email, subject, message)
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        // Email sẽ được gửi TỪ người điền form
        return $this->from($this->data['email'], $this->data['name'])
                    ->subject('Tin nhắn liên hệ mới: ' . $this->data['subject'])
                    ->view('emails.contact'); // Trỏ đến file view ở bước 3
    }
}
