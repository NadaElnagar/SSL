<?php

namespace Modules\Notification\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Notification\Entities\BodyMail;

class NotificationDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $mail = BodyMail::firstOrNew(['id'=>1,'subject'=>'congratulations As new Admin SSL To Secure']);
        $mail->body = "You are receiving this email because we pleasure to invite you as new admin in SSL To Secure
        <br/> <a href='link'>Dashboard Link </a> <br/> Login With Your Email.<br/>
        Password : ";
        $mail->website_name = " SSL To Secure ";
        $mail->save();


        $mail = BodyMail::firstOrNew(['id'=>2,'subject'=>'Forget Password SSL To Secure']);
        $mail->body = "You are receiving this email because we 
                   received a password reset request for your account.<br/>
                   If you did not request a password reset, no further action is required.<br/>";
         $mail->website_name = " SSL To Secure ";
        $mail->save();

        // $this->call("OthersTableSeeder");
    }
}
