<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Tkuska\DashboardBundle;


/**
 * Description of WidgetProvider.
 *
 * @author Tomasz Kuśka <tomasz.kuska@gmail.com>
 */
class WidgetProvider
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @var \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage
     */
    protected $security;

    /**
     *
     */
    protected $widgetTypes;
    
    /**
     * 
     * @param \Doctrine\ORM\EntityManager $em
     * @param \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage $security
     */
    public function __construct(\Doctrine\ORM\EntityManager $em, \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage $security, iterable $widget_types)
    {
        $this->em = $em;
        $this->security = $security;
        
        foreach($widget_types[0] as $id => $w_service) {
            //print get_class($w_service);
            //print $id;
            $this->widgetTypes[ $w_service->getType() ] = $w_service;
        }
    }



    /**
     * 
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getWidgetTypes()
    {
        return $this->widgetTypes;
    }

    /**
     * 
     * @param string $widget_type
     * @return Widget\WidgetTypeInterface
     */
    public function getWidgetType($widget_type)
    {
        if ( array_key_exists($widget_type, $this->widgetTypes)) {
            return $this->widgetTypes[$widget_type];
        }
    }

    /**
     * Returns collection of logged user widgets
     */
    public function getMyWidgets()
    {
        $myWidgets = $this->em->getRepository('TkuskaDashboardBundle:Widget')
                ->getMyWidgets($this->security->getToken()->getUser())
                ->getQuery()
                ->getResult();
        $return = array();
        foreach ($myWidgets as $widget) {
            $widgetType = $this->getWidgetType($widget->getType());
            if ($widgetType) {  // the widget could have been deleted
                $widgetType->setParams($widget);
                $return[] = $widgetType;
            }
        }
        return $return;
    }
}
