<?php

namespace AppBundle\Controller;

use AppBundle\Service\EmailSender;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends Controller
{
    /**
     * @Route("/", name="contact")
     */
    public function index(Request $request, EmailSender $emailSender)
    {
        if ($request->cookies->get('contactForm')) {            
            return $this->redirectToRoute('send_mail_success');
        }

        $form = $this->createForm('AppBundle\Form\ContactType',null,array(
            'method' => 'POST'
        ));        

        $form->handleRequest($request);  

        if($form->isSubmitted() && $form->isValid()){

            $cookieConfiguration = array(
                'name'  => 'contactForm',
                'value' => 'contact',
                'path'  => $this->generateUrl('contact'),
                'time'  => time() + $this->getParameter('contactFormTimeDelay')
            );                
            $cookie = new Cookie($cookieConfiguration['name'], $cookieConfiguration['value'].'|'.$cookieConfiguration['time'], $cookieConfiguration['time'], $cookieConfiguration['path']);
            
            $response = new Response();
            $response->headers->setCookie($cookie);
            $response->send();

            if($emailSender->send($request->request->get('contact'))){
                return $this->redirectToRoute('send_mail_success');
            }else{
                $this->addFlash('danger', 'Wystąpił problem prosze spróbowac ponownie.');
            }
        }

        return $this->render('contact/index.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/wyslano", name="send_mail_success")
     */
    public function sendMailSuccess(Request $request){

        if ($request->cookies->get('contactForm')) {
            list($value, $time) = explode("|", $request->cookies->get('contactForm'));
            $time = date('Y-m-d H:i:s', $time);
            return $this->render('contact/success.html.twig', compact('time'));  
        }
        return $this->redirectToRoute('contact');
    }
}
