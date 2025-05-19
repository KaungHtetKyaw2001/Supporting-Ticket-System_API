<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SMSNotification extends Controller
{
    public function sendSmsNotificatiion()
    {
        $basic  = new \Vonage\Client\Credentials\Basic("67507085", "xAAd8YDv9WkgAsqA");
        $client = new \Vonage\Client($basic);

        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS("959254134083", 'Support Ticket', 'Ticket is created')
        );
        
        $message = $response->current();
        
        if ($message->getStatus() == 0) {
            echo "The message was sent successfully\n";
        } else {
            echo "The message failed with status: " . $message->getStatus() . "\n";
        }
    }

    public function TicketCreatesendSmsNotificatiion()
    {
        $basic  = new \Vonage\Client\Credentials\Basic("67507085", "xAAd8YDv9WkgAsqA");
        $client = new \Vonage\Client($basic);

        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS("959254134083", 'Support Ticket', 'Ticket is created')
        );
        
        $message = $response->current();
        
        if ($message->getStatus() == 0) {
            echo "The message was sent successfully\n";
        } else {
            echo "The message failed with status: " . $message->getStatus() . "\n";
        }
    }

    public function TicketUpdateSmsNotificatiion()
    {
        $basic  = new \Vonage\Client\Credentials\Basic("67507085", "xAAd8YDv9WkgAsqA");
        $client = new \Vonage\Client($basic);

        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS("959254134083", 'Support Ticket', 'Ticket is updated')
        );
        
        $message = $response->current();
        
        if ($message->getStatus() == 0) {
            echo "The message was sent successfully\n";
        } else {
            echo "The message failed with status: " . $message->getStatus() . "\n";
        }
    }

    public function TicketDeletesendSmsNotificatiion()
    {
        $basic  = new \Vonage\Client\Credentials\Basic("67507085", "xAAd8YDv9WkgAsqA");
        $client = new \Vonage\Client($basic);

        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS("959254134083", 'Support Ticket', 'Ticket is deleted')
        );
        
        $message = $response->current();
        
        if ($message->getStatus() == 0) {
            echo "The message was sent successfully\n";
        } else {
            echo "The message failed with status: " . $message->getStatus() . "\n";
        }
    }

    public function TicketStatusDefinesendSmsNotificatiion()
    {
        $basic  = new \Vonage\Client\Credentials\Basic("67507085", "xAAd8YDv9WkgAsqA");
        $client = new \Vonage\Client($basic);

        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS("959254134083", 'Support Ticket', 'Ticket\'s status is defined')
        );
        
        $message = $response->current();
        
        if ($message->getStatus() == 0) {
            echo "The message was sent successfully\n";
        } else {
            echo "The message failed with status: " . $message->getStatus() . "\n";
        }
    }

    public function TicketPriorityDefinesendSmsNotificatiion()
    {
        $basic  = new \Vonage\Client\Credentials\Basic("67507085", "xAAd8YDv9WkgAsqA");
        $client = new \Vonage\Client($basic);

        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS("959254134083", 'Support Ticket', 'Ticket\'s priority is defined')
        );
        
        $message = $response->current();
        
        if ($message->getStatus() == 0) {
            echo "The message was sent successfully\n";
        } else {
            echo "The message failed with status: " . $message->getStatus() . "\n";
        }
    }

    public function TicketPermissionAssignendSmsNotificatiion()
    {
        $basic  = new \Vonage\Client\Credentials\Basic("67507085", "xAAd8YDv9WkgAsqA");
        $client = new \Vonage\Client($basic);

        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS("959254134083", 'Support Ticket', 'Ticket\'s permission is defined')
        );
        
        $message = $response->current();
        
        if ($message->getStatus() == 0) {
            echo "The message was sent successfully\n";
        } else {
            echo "The message failed with status: " . $message->getStatus() . "\n";
        }
    }
}
