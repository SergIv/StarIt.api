<?php

namespace Cody\Bundle\InterfaceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Cody\Bundle\InterfaceBundle\Form\Type\FeedbackType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    protected $get_result=array();
    
    
    protected  function getJson()
    {
        //$this->get_result = array();
        $ch = curl_init();
        
        curl_setopt_array(
        $ch, array( 
            CURLOPT_URL => 'http://localhost:8001/app_dev.php/points.json',
            CURLOPT_RETURNTRANSFER => true
        ));

        $output = curl_exec($ch);
        $big_array = json_decode($output, true);
        $this->get_result = $big_array;
    }
    public function indexAction()
    {
        if(empty($this->get_result))
        {
            $this->getJson();
        }
        $big_array = $this->get_result;
        $chain_array = array();
        foreach ($big_array as $key => $value) {
            $chain_array[$key] = $value['name'];
        }
        
        $points_array = array();
        
        foreach ($big_array[3]['points'] as $key => $value) {
            $points_array[$value['idpoint']] = $value['name'];
        }
        
        return $this->render('CodyInterfaceBundle:Default:index.html.twig', array('array' => var_dump($big_array)));
    }
    
    public function formAction(Request $request)
    {
        if(empty($this->get_result))
        {
            $this->getJson();
        }
        
        $form = $this->createForm(new FeedbackType($this->get_result));
        
        $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                //add browser name
                //add user ip
                //add "application"="web-client"
                $responce = array();
                $responce['idPoint'] = $data['point'];
                $responce['rating'] = $data['rating'];
                $responce['comment'] = $data['comment'];
                $responce['idForm'] = 1;
                $responce['idCustomer'] = 1;
                $current_date = new \DateTime("now");
                $responce['created'] = $current_date->format('d-m-Y H:i:s');
                $browser = $request->headers->get('User-Agent') ;
                $responce['deviceName'] = $browser;
                $responce['deviceId'] = $request->getClientIp();
                $responce['application'] = "web_browser";
                //return $this->render('CodyInterfaceBundle:Default:index.html.twig', array('array' => var_dump($responce)));
                //return $this->render('CodyInterfaceBundle:Default:success.html.twig');
                //return new Response('<html><body>Hello !</body></html>');
                //$this->redirect($this->generateUrl('task_success'));
                return $this->forward('CodyInterfaceBundle:Default:success');
                //return $this->renderView('CodyInterfaceBundle:Default:success.html.twig');
            }
            
            
              
        return $this->render('CodyInterfaceBundle:Default:form.html.twig', 
                array('form' => $form->createView()));
    }
    
    public function pointsByChainAction(Request $request)
    {
        $chain = $request->request->get('chain');
        
        if(empty($this->get_result))
        {
            $this->getJson();
        }
        $big_array = $this->get_result;
        
        $points_array = array();
        
        if(is_numeric((int)$chain))
        {
            foreach ($big_array[(int)$chain]['points'] as $key => $value) {
                $points_array[$value['idpoint']] = $value['name'];
            }
        }
        
        
        $response = new JsonResponse();
        $response->setData($points_array);

        return $response;
    }
    
    public function successAction()
    {
        return $this->render('CodyInterfaceBundle:Default:success.html.twig');
    }
    
}
