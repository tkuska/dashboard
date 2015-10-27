<?php

namespace Tkuska\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Tkuska\DashboardBundle\Entity\Widget;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Akcja controller.
 */
class DashboardController extends Controller
{
    /**
     * @Route("/dashboard/add_widget/{alias}", name="add_widget")
     */
    public function addWidgetAction($alias)
    {
        /* @var $security \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage */
        $security = $this->get('security.token_storage');
        $user = $security->getToken()->getUser();
        /* @var $widget \Tkuska\DashboardBundle\Widget\WidgetTypeInterface */
        $widgetType = $this->get('tkuska_dashboard.widget_provider')->getWidgetType($alias);
        /* @var $widgetRepository \Tkuska\DashboardBundle\Entity\Repository\WidgetRepository */
        $widgetRepository = $this->getDoctrine()
                ->getManager()
                ->getRepository('TkuskaDashboardBundle:Widget');
        
        $widget = $widgetRepository->getUserWidget($user, $alias)
                ->getQuery()
                ->getOneOrNullResult();
        
        if (!$widget) {
            $widget = new Widget();
            $widget->importConfig($widgetType);
            $widget->setUzytkownik($user);
        }
        /* @var $em \Doctrine\ORM\EntityManager */
        $em = $this->get('doctrine.orm.entity_manager');
        $em->persist($widget);
        $em->flush();
        
        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/dashboard/remove_widget/{alias}", name="remove_widget")
     */
    public function removeWidgetAction($alias)
    {
        /* @var $security \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage */
        $security = $this->get('security.token_storage');
        $user = $security->getToken()->getUser();
        /* @var $widgetRepository \Tkuska\DashboardBundle\Entity\Repository\WidgetRepository */
        $widgetRepository = $this->getDoctrine()
                ->getManager()
                ->getRepository('TkuskaDashboardBundle:Widget');
        
        $widget = $widgetRepository->getUserWidget($user, $alias)
                ->getQuery()
                ->getOneOrNullResult();
        
        if ($widget) {
            /* @var $em \Doctrine\ORM\EntityManager */
            $em = $this->get('doctrine.orm.entity_manager');
            $em->remove($widget);
            $em->flush();
        }
        
        return new \Symfony\Component\HttpFoundation\JsonResponse(true);
    }
    
    /**
     * Ogólne statystyki akcji.
     *
     * @Route("/", name="homepage")
     * @Method("GET")
     * @Template()
     */
    public function dashboardAction()
    {
        $widgets = $this->get('tkuska_dashboard.widget_provider')->getMyWidgets();
        return array('widgets' => $widgets);
    }
}
