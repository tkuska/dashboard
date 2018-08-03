<?php

namespace Tkuska\DashboardBundle;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

use Tkuska\DashboardBundle\Entity\Widget;


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
    public function __construct(EntityManagerInterface $em, TokenStorage $security, iterable $widget_types)
    {
        $this->em = $em;
        $this->security = $security;
        
        foreach($widget_types[0] as $id => $w_service) {
            $this->widgetTypes[$w_service->getType()] = $w_service;
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
        if (array_key_exists($widget_type, $this->widgetTypes)) {
            return clone $this->widgetTypes[$widget_type];
        }
    }

    /**
     * Returns collection of logged user widgets
     */
    public function getMyWidgets()
    {
        // Get user.
        $user = $this->security->getToken()->getUser();
        if ($user === "anon.") {
            return [];
        }

        // Get user's widgets.
        $myWidgets = $this->em->getRepository(Widget::class)
                ->getMyWidgets($user)
                ->getQuery()
                ->getResult();
        
        // Initialize actual widgets.
        $return = [];
        foreach ($myWidgets as $widget) {

            $widgetType = $this->getWidgetType($widget->getType());
            if ($widgetType) {  // the widget could have been deleted
                $return[] = $widgetType->setParams($widget);
            }
            
        }
        return $return;
    }
}
