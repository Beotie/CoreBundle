<?php

namespace Beotie\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('BeotieCoreBundle:Default:index.html.twig');
    }
}
