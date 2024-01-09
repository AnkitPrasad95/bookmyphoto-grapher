<?php
namespace App\Http\Controllers\User;
use App\Helpers\helper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Models\Notification;
use App\Models\Setting;

class TestMailController extends Controller
{
    public function sendTestMail()
    {
        $getlogo = Setting::select('logo')->where('id', 1)->first();
        $data = [
            'title' => "Email verification",
            'email' => 'ak981993@gmail.com',
            'otp' => '445566',
            'logo' => asset('storage/app/public/images/' . $getlogo->logo)
        ];
        
        echo "<pre>";
        print_r($data);
        echo "</pre>";

        $apiKey = '7e06c8d7e930a8f3b04b61d51ef6a7a9';
        $apiSecret = 'f90734310a9017e2f88b8e99665ae1f8';
        $recipientEmail = 'ak981993@gmail.com';
        $senderEmail = 'bookmyphotografer@gmail.com';
        $senderName = 'Bookmyohotografer';
        $subject = 'Test Email';
        $messageText = 'Hello, this is a test email!';
        
        $url = 'https://api.mailjet.com/v3.1/send';
        
        $data = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => $senderEmail,
                        'Name' => $senderName,
                    ],
                    'To' => [
                        [
                            'Email' => $recipientEmail,
                        ],
                    ],
                    'Subject' => $subject,
                    'TextPart' => $messageText,
                ],
            ],
        ];
        
        $jsonData = json_encode($data);
        
        $ch = curl_init($url);
        
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
        ]);
        
        // Set up basic authentication
        curl_setopt($ch, CURLOPT_USERPWD, "$apiKey:$apiSecret");
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        curl_close($ch);
        
        if ($httpCode == 200) {
            echo "Email sent successfully!";
        } else {
            echo "Error: " . $response;
        }
    }


   
}
