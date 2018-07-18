<?php

namespace Tkuska\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;

use Tkuska\DashboardBundle\WidgetProvider;
use Tkuska\DashboardBundle\Entity\Widget;

/**
 * Akcja controller.
 */
class DashboardController extends Controller
{
    /**
     * @Route("/dashboard/add_widget/{type}", name="add_widget")
     */ 

    public function addWidgetAction(WidgetProvider $provider, $type)
    {
        $widgetType = $provider->getWidgetType($type);

        $widget = new Widget();
        $widget->importConfig($widgetType);
        $widget->setUserId($this->getUser()->getId());

        $em = $this->getDoctrine()->getManager();
        $em->persist($widget);
        $em->flush();

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/dashboard/remove_widget/{id}", options={"expose"=true}, name="remove_widget")
     */
    public function removeWidgetAction($id)
    {
        $user = $this->getUser();
        
        $widget = $this->getDoctrine()->getRepository(Widget::class)->find($id);
        
        if ($widget) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($widget);
            $em->flush();
        }
        
        return new JsonResponse(true);
    }
    
    /**
     * @Route("/dashboard/update_widget/{id}/{x}/{y}/{width}/{height}", options={"expose"=true}, name="update_widget")
     */
    public function updateWidgetAction($id, $x, $y, $width, $height)
    {
        $user = $this->getUser();

        $widget = $this->getDoctrine()->getRepository(Widget::class)->find($id);

        if ($widget) {
            $widget
                ->setX($x)
                ->setY($y)
                ->setWidth($width)
                ->setHeight($height)
            ;

            $em = $this->getDoctrine()->getManager();
            $em->flush();
        }

        return new JsonResponse(true);
    }
    
    /**
     *
     * @Route("/", name="homepage")
     * @Method("GET")
     * @Template()
     */
    public function dashboardAction(WidgetProvider $provider)
    {
        $widgets = $provider->getMyWidgets();
        $widget_types = $provider->getWidgetTypes();
        return array('widgets' => $widgets, 'widget_types' => $widget_types);
    }
}
