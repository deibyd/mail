<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TestMailController extends AbstractController
{
    /**
     * @Route("/test/mail", name="test_mail")
     */
    public function index(Request $request, \Swift_Mailer $mailer, 
        LoggerInterface $logger)
    {
        $logger->info('I just got the logger');
        $logger->error('An error occurred');
        
        $name = $request->query->get('name');

        $message = new \Swift_Message('Test email');
        $message->setFrom('from@example.com');
        $message->setTo('to@example.com');
        $message->setBody(
            $this->renderView(
                'home/index.html.twig',
                ['name' => $name]
            ),
            'text/html'
        );

        $mailer->send($message);

        $logger->info('email sent');
        $this->addFlash('notice', 'Email sent');

        return $this->redirectToRoute('home');
    }
}