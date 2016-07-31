<?php

namespace Tkuska\DashboardBundle\Twig;

use Tkuska\DashboardBundle\Widget\WidgetTypeInterface;
use Tkuska\DashboardBundle\WidgetProvider;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Description of DashboardExtension
 *
 * @author Tomasz Kuśka <tomasz.kuska@gmail.com>
 */
class DashboardExtension extends \Twig_Extension
{
    /**
     *
     * @var \Tkuska\DashboardBundle\WidgetProvider
     */
    protected $provider;
    
    /**
     *
     * @var RouterInterface 
     */
    protected $router;
    
    /**
     *
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * 
     * @param WidgetProvider $provider
     * @param Router $router
     */
    public function __construct(WidgetProvider $provider, RouterInterface $router, TranslatorInterface $translator)
    {
        $this->provider = $provider;
        $this->router = $router;
        $this->translator = $translator;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('renderWidgetSelector', array($this, 'renderWidgetSelector'), array('is_safe' => array('all'))),
            new \Twig_SimpleFunction('renderWidget', array($this, 'renderWidget'), array('is_safe' => array('all'))),
        );
    }
    
    public function renderWidgetSelector()
    {
        $widgets = $this->provider->getWidgetTypes();
        $html = '<div class="btn-group pull-right"><button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
        $html .= $this->translator->trans('available_widgets', array(), 'TkuskaDashboardBundle');
        $html .= '<span class="caret"></span></button><ul class="dropdown-menu">';
        /* @var $widgetElemet \Tkuska\DashboardBundle\Widget\WidgetTypeInterface  */
        foreach ($widgets as $widget) {
            $html .= '<li><a href="' . $this->router->generate('add_widget', array('alias' => $widget->getType()))  . '">' . $widget->getName() . '</a></li>';
        }
        $html .= '</ul></div>';

        return $html;
    }
    
    public function renderWidget(WidgetTypeInterface $widget)
    {
        $html = '<div class="grid-stack-item" data-gs-x="'.$widget->getX().'" data-gs-y="'.$widget->getY().'"  data-gs-width="'.$widget->getWidth().'" data-gs-height="'.$widget->getHeight().'" data-widget-type="'.$widget->getType().'">';
        $html.= $widget->render();
        $html.= '</div>';
        
        return $html;
    }

    public function getName()
    {
        return 'tkuska_dashboard_twig_extension';
    }
}
