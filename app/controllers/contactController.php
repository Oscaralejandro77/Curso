<?php


namespace app\controllers;


use app\Models\message;
use Laminas\Diactoros\Response\RedirectResponse;
use Laminas\Diactoros\ServerRequest;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class contactController extends baseController
{
    public function index() {
        return $this->renderHTML('contacts/index.twig');
    }

    public function send(ServerRequest $request){
        $requestData = $request->getParsedBody();
        $message = new message();
        $message->name = $requestData['name'];
        $message->email = $requestData['email'];
        $message->message = $requestData['message'];
        $message->sent = false;
        $message->save();

        /*$transport = (new Swift_SmtpTransport(getenv('SMTP_HOST'), getenv('SMTP_PORT')))
            ->setUsername(getenv('SMTP_USER'))
            ->setPassword(getenv('SMTP_PASS'))
        ;

// Create the Mailer using your created Transport
        $mailer = new Swift_Mailer($transport);

// Create a message
        $message = (new Swift_Message('Wonderful Subject'))
            ->setFrom(['contact@mail.com' => 'Contact Form'])
            ->setTo(['a@mail.com', 'other@domain.org' => 'A name'])
            ->setBody('Here is the message itself. name: ' . $requestData['name']
                . ' email: ' . $requestData['email'] . ' message ' . $requestData['message']
            )
        ;

// Send the message
        $result = $mailer->send($message);*/
        return new RedirectResponse('/contact');
    }

}