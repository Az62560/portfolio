<?php

namespace App\Service;

use Mailjet\Client;
use Mailjet\Resources;

class Mailjet
{

    private $apiKey;
    private $apiSecret;

    public function __construct()
    {
        $this->apiKey = $_ENV['MAILJET_API_KEY'];
        $this->apiSecret = $_ENV['MAILJET_API_SECRET'];
    }

    public function sendEmail($fromEmail, $fromName, $subject, $content)
    {
        $mailjet = new Client($this->apiKey, $this->apiSecret, true,['version' => 'v3.1']);

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
                    'TemplateID' => 6277862,
                        'TemplateLanguage' => true,
                        'Subject' => $subject,
                        'Variables' => [
                            'content' => $contentHtml
                        ]     
                ]
            ]
        ];

        $response = $mailjet->post(Resources::$Email, ['body' => $body]);
        $response->success();
    }
}
