<?php

namespace App\Service;

use \Mailjet\Client;
use \Mailjet\Resources;

class CustomMailSender
{
    public function send($user_mail, $to_mail, $user_name, $to_name, $user_phone, $subject, $content)
    {
        $mj = new Client($_ENV['MJ_APIKEY_PUBLIC'], $_ENV['MJ_APIKEY_PRIVATE'], true, ['version' => 'v3.1']);

        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "mathieu.montjarret@icloud.com",
                        'Name' => "Portfolio"
                    ],
                    'To' => [
                        [
                            'Email' => $to_mail,
                            'Name' => $to_name
                        ]
                    ],
                    'TemplateID' => 5894133,
                    'TemplateLanguage' => true,
                    'Subject' => $subject,
                    'Variables' => [
                        'UserMail' => $user_mail,
                        'UserName' => $user_name,
                        'UserPhone' => $user_phone,
                        'content' => $content

                    ]
                ]
            ]
        ];
        $mj->post(Resources::$Email, ['body' => $body]);
    }
}
