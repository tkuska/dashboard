<?php

namespace Tkuska\DashboardBundle\Widgets;

use Twig_Environment as Environment;

/**
 * Description of CalendarWidget.
 *
 * @author Tomasz Kuśka <tomasz.kuska@gmail.com>
 */
class CalendarWidget extends AbstractWidget
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
        return $this->twig->render('TkuskaDashboardBundle:Widget:calendar.html.twig');
    }
    
    /**
     * @inheritdoc
     */
    public function getName()
    {
        return "Horloge";
    }
}
