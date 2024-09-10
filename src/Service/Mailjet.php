<?php

namespace App\Service;

use Mailjet\Client;
use Mailjet\Resources;

class Mailjet
{

    private $api_key = 'e9825437f180fbfab2a630eab2a20485';
    private $api_key_secret = '660e697bb5567e7a7791ddea9475bc01';

    private $mailjet;

    public function __construct()
    {
        $this->mailjet = new Client($this->api_key, $this->api_key_secret, true,['version' => 'v3.1']);
    }

    public function sendEmail($fromEmail, $fromName, $subject, $content)
    {
        $contentHtml = nl2br($content);

        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => $fromEmail,
                        'Name'  => $fromName,
                    ],
                    'To' => [
                        [
                            'Email' => "justincornu@gmail.com",
                            'Name'  => "Justin Cornu",
                        ]
                    ],
                    'TemplateID' => 5641547,
                        'TemplateLanguage' => true,
                        'Subject' => $subject,
                        'Variables' => [
                            'content' => $contentHtml
                        ]     
                ]
            ]
        ];

        $response = $this->mailjet->post(Resources::$Email, ['body' => $body]);
        $response->success();
    }
}
