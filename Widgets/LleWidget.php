<?php

namespace Tkuska\DashboardBundle\Widgets;

use Tkuska\DashboardBundle\Widget\WidgetTypeInterface;
use Twig_Environment as Environment;

/**
 * Description of CalendarWidget.
 *
 * @author Tomasz Kuśka <tomasz.kuska@gmail.com>
 */
class LleWidget implements WidgetTypeInterface
{
    /**
     * @var int x position 
     */
    protected $x = 0;

    /**
     * @var int y position
     */
    protected $y = 0;

    /**
     * @var int widget width
     */
    protected $width = 4;

    /**
     * @var int widget height
     */
    protected $height = 5;

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
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @inheritdoc
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @inheritdoc
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * @inheritdoc
     */
    public function getY()
    {
        return $this->y;
    }

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

    /**
     * @inheritdoc
     */
    public function setParams(\Tkuska\DashboardBundle\Entity\Widget $widget)
    {
        $this->x = $widget->getX();
        $this->y = $widget->getY();
        $this->width = $widget->getWidth();
        $this->height = $widget->getHeight();
    }
}
