<?php

namespace Tkuska\DashboardBundle\Widgets;

use Tkuska\DashboardBundle\Widget\WidgetTypeInterface;
use Twig_Environment as Environment;

/**
 *
 */
class LleWidget extends AbstractWidget
{

    /**
     * @var Environment
     */
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @inheritdoc
     */
    public function render()
    {
        return $this->twig->render('TkuskaDashboardBundle:widget:2le.html.twig', array(
            "widget" => $this,
        ));
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return "2le";
    }

    /**
     * @inheritdoc
     */
    public function getJsonSchema()
    {
        return null;
    }
}
