<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Mail;

class MailService
{
    public function sendMail($posts, $email, $name, $title)
    {
        Mail::raw($posts,function($message) use ($email,$name,$title){
            $message->to($email , 'To web dev blog')->subject($title);
            $message->from('2004sasharyzhakov@gmail.com',$name);
        });
    }
}
