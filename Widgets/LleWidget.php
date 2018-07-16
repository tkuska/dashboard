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
     * @inheritdoc
     */
    public function render()
    {
        return $this->twig->render('TkuskaDashboardBundle:Widget:2le.html.twig');
    }

    /**
     * @inheritdoc
     */
    public function getType()
    {
        return 'tkuska_2le_widget';
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return '2le';
    }

}
