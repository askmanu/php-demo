<?php

/**
* The Mail service class provides email sending functionality for the La Boot'ique e-commerce platform using the Mailjet API. 
* 
* It encapsulates the email transmission process through a single method that accepts recipient details, subject, and content parameters. 
* The service configures emails with a consistent sender identity and utilizes a predefined Mailjet template for standardized formatting. 
* 
* This class serves as the central component for all transactional and notification emails sent by the application, abstracting the complexities of the underlying email delivery system from the rest of the codebase.
*/

namespace App\Service;

use Mailjet\Client;
use Mailjet\Resources;

class Mail 
{
    private $api_key = "54abf7bd7c959b059abdee6778722a2c";
    private $api_key_secret = "89a12b1d1e22e0c08167316926b02e1e";

    /**
    * Sends an email using the Mailjet API with a predefined template. The email is sent from La Boot'ique's address to the specified recipient with the given subject and content.
    * 
    * @param string toEmail Email address of the recipient
    * @param string toName Name of the recipient
    * @param string subject Subject line of the email
    * @param string content Content to be included in the email template
    */
    public function send($toEmail, $toName, $subject, $content)
    {
        $mj = new Client($this->api_key, $this->api_key_secret,true,['version' => 'v3.1']);
        $body = 
        [
            'Messages' => 
            [
                [
                    'From' => 
                    [
                        'Email' => "bonnal.tristan@hotmail.fr",
                        'Name' => "La Boot'ique"
                    ],
                    'To' => 
                    [
                        [
                            'Email' => $toEmail,
                            'Name' => $toName
                        ]
                    ],
                    'TemplateID' => 3732103,
                    'TemplateLanguage' => true,
                    'Subject' => $subject,
                    'Variables' => ['content' => $content]
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
    }
}