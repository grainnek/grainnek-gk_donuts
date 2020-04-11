<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Login;

class RegisterController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     */
    public function index()
    {
		$request = Request::createFromGlobals();		
		
		$user = $request->request->get('user', 'none');
		$password = $request->request->get('password', 'none');	
		$name = $request->request->get('name', 'none');	
		
		$entityManager = $this->getDoctrine()->getManager();
		
		$customer = new Login();
		
		$customer->setUsername($user);
		$customer->setPassword($password);
		$customer->setName($name);
		$customer->setAcctype("customer");
		
		$entityManager->persist($customer);
		
		$entityManager->flush();
		
        return new Response("Thank you for registering " . $name);
    }
}
?>