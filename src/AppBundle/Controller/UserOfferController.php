<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserOfferController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
}