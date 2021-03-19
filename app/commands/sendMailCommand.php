<?php


namespace app\commands;


use http\Message;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class sendMailCommand extends Command
{

    protected static $defaultName = 'app:send-mail';


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $pendingMessage = Message::where('send', false)->first();
        if($pendingMessage){
            $transport = (new Swift_SmtpTransport(getenv('SMTP_HOST'), getenv('SMTP_PORT')))
                ->setUsername(getenv('SMTP_USER'))
                ->setPassword(getenv('SMTP_PASS'))
            ;

// Create the Mailer using your created Transport
            $mailer = new Swift_Mailer($transport);

// Create a message
            $message = (new Swift_Message('Wonderful Subject'))
                ->setFrom(['contact@mail.com' => 'Contact Form'])
                ->setTo(['a@mail.com', 'other@domain.org' => 'A name'])
                ->setBody('Here is the message itself. name: ' . $pendingMessage->name
                    . ' email: ' . $pendingMessage->email . ' message ' . $pendingMessage->message
                )
            ;

// Send the message
            $result = $mailer->send($message);
            $pendingMessage->sent = true;
            $pendingMessage->save();
        }

    }

}