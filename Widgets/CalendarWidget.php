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
        return $this->twig->render('TkuskaDashboardBundle:Widget:calendar.html.twig', array(
            "widget" => $this,
        ));
    }
    
    /**
     * @inheritdoc
     */
    public function getName()
    {
        return "Horloge";
    }

    /**
     * @inheritdoc
     */
    public function getJsonSchema()
    {
        return null;
    }
}
