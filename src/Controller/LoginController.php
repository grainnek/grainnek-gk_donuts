<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Login;
use App\Entity\Ordertable;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class LoginController extends AbstractController
{
	 // add in the session bit
	private $session;
		
	public function __construct(SessionInterface $session) {
		$this->session = $session;
	}
		
    /**
     * @Route("/login", name="login")
     */
    public function index(SessionInterface $session)
    {
		$request = Request::createFromGlobals();
		//get variables
		$username = $request->request->get('username', 'none');
		$password = $request->request->get('password', 'none');
	
		$result = $this->getDoctrine()->getRepository(Login::class);
			
		$user = $result->findOneBy(['username' => $username, 'password' => $password]);
		
		if($user) //if the user is found
		{		
		    $id = $user->getId();
		    $name = $user->getName();
		    $account = $user->getAcctype();
		
		    $session->set('user', $id);
		    $session->set('name', $name);		
		
		    return new Response($account);		
		}
		
		else 
		{
			return new Response('error');
		}
    }
	
	/**
     * @Route("/session", name="session")
     */
    public function session(SessionInterface $session) //test function to verify sessions is working
    {		
		$user = $session->get('user');
		$name = $session->get('name');
		
		$test = $user." - ".$name;
		
		return new Response($test);
    }
	
	/**
     * @Route("/orders", name="orders")
     */
	public function customer_orders(SessionInterface $session)
	{
		$repository = $this->getDoctrine()->getRepository(Ordertable::class);
		
		$name = $session->get('name');
		
		$orders = $repository->findBy(['name' => $name]);
		
		$data = "<h3>Order History:</h3><hr>";
		
		if($orders) //if orders are found in the db
		{
			foreach($orders as $order)
			{			
				$data .= "<p>Order ID: ".$order->getId()."</p>";
				//$data .= "<p>Ordered on: ".date."</p>";
				$data .= "<p>".$order->getDetails()."</p>";
				$data .= "<p>Total: €".$order->getPrice()."</p>";
				$data .= "<p>Order status: ".$order->getStatus()."</p>";
				$data .= "<hr>";
			}
		}
		else
		{
			$data .= "<p>You have no previous orders.</p><hr>";
		}
		return new Response($data);		
		
	}
	
	/**
     * @Route("/allorders", name="allorders")
     */
	public function manager_orders()
	{
		$repository = $this->getDoctrine()->getRepository(Ordertable::class);		
		
		$orders = $repository->findAll();
		
		$revenue = 0; //to calculate revenue from orders
		$total = 0; //to calculate number of orders
		$data = "<h3>Orders:</h3><hr>";		
		
		$data .= "<table><thead><tr><th>Order ID</th><th>Customer</th><th>Details</th><th>Address</th><th>Price</th><th>Status</th>";
			foreach($orders as $order)
			{	
				if($order->getStatus() != "cancelled")
				{
				    $revenue += $order->getPrice();
				    $total += 1;
				}
				
				$data .= "<tr>";
				$data .= "<td>".$order->getId()."</td>";
				$data .= "<td>".$order->getName()."</td>";
				$data .= "<td>".$order->getDetails()."</td>";
				$data .= "<td>".$order->getAddress()."</td>";
				$data .= "<td>€".$order->getPrice()."</td>";
				$data .= "<td>".$order->getStatus()."</td>";
				$data .= "</tr>";
			}
			
		$data .= "</table>";
		
		$data.= "<p>Revenue = €".$revenue."</p>";
		$data.= "<p>Number of orders placed: ".$total."</p>";
		$data.= "<p>*Figures do not include cancelled orders.</p>";
		
		return new Response($data);		
		
	}
	/**
     * @Route("/driverorders", name="driverorders")
     */
	public function driver_orders()
	{
		$repository = $this->getDoctrine()->getRepository(Ordertable::class);		
		
		$status = "getting ready";
		
		$orders = $repository->findBy(['status' => $status]);
		
		$data = "<h3>Orders:</h3><hr>";		
		
		$data .= "<table><thead><tr><th>Order ID</th><th>Customer</th><th>Details</th><th>Address</th><th>Contact Number</th><th>Price</th><th>Status</th>";
			foreach($orders as $order)
			{				
				$data .= "<tr>";
				$data .= "<td>".$order->getId()."</td>";
				$data .= "<td>".$order->getName()."</td>";
				$data .= "<td>".$order->getDetails()."</td>";
				$data .= "<td>".$order->getAddress()."</td>";
				$data .= "<td>".$order->getContact()."</td>";
				$data .= "<td>€".$order->getPrice()."</td>";
				$data .= "<td>".$order->getStatus()."</td>";
				$data .= "</tr>";
			}
			
		$data .= "</table>";		
		
		return new Response($data);		
		
	}
	
	/**
     * @Route("/placeorder", name="placeorder")
     */
    public function place_order(SessionInterface $session)
    {
		$request = Request::createFromGlobals();		
		
		$details = $request->request->get('details', 'none');
		$price = $request->request->get('total', 'none');
		$address = $request->request->get('address', 'none');
		$contact = $request->request->get('contact', 'none');
		$name = $session->get('name');
		
		
		$entityManager = $this->getDoctrine()->getManager();
		
		$order = new Ordertable();
		
		$order->setName($name);
		$order->setDetails($details);
		$order->setAddress($address);
		$order->setContact($contact);		
		$order->setPrice($price);
		$order->setStatus("getting ready");
		
		$entityManager->persist($order);
		
		$entityManager->flush();
		
        return new Response("Order placed successfully!");
    }
	
	/**
     * @Route("/update", name="update")
     */
    public function update()
    {
		$request = Request::createFromGlobals();
		//get variables
		$id = $request->request->get('id', 'none');		
	
		$result = $this->getDoctrine()->getRepository(Ordertable::class);
		$entityManager = $this->getDoctrine()->getManager();
			
		$delivery = $result->findOneBy(['id' => $id]);
		
		if($delivery) //if the delivery is found
		{		
		    $delivery->setStatus("delivered");		    
			
			$entityManager->flush();
		
		    return new Response("Delivery #".$id." marked as delivered.");		
		}
		
		else 
		{
			return new Response('No delivery matching that ID');
		}
    }
	
	/**
     * @Route("/cancel", name="cancel")
     */
    public function cancel()
    {
		$request = Request::createFromGlobals();
		//get variables
		$id = $request->request->get('id', 'none');		
	
		$result = $this->getDoctrine()->getRepository(Ordertable::class);
		$entityManager = $this->getDoctrine()->getManager();
			
		$delivery = $result->findOneBy(['id' => $id]);
		
		if($delivery) //if the delivery is found
		{		
		    $delivery->setStatus("cancelled");		    
			
			$entityManager->flush();
		
		    return new Response("Delivery #".$id." marked as cancelled.");		
		}
		
		else 
		{
			return new Response('No delivery matching that ID');
		}
    }
	
}
