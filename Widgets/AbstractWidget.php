<?php

namespace Tkuska\DashboardBundle\Widgets;

use Tkuska\DashboardBundle\Widget\WidgetTypeInterface;
use Twig_Environment as Environment;

/**
 * Description of CalendarWidget.
 *
 */
abstract class AbstractWidget implements WidgetTypeInterface
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
        return 'you should implement the render method in '. get_class($this);
    }

    /**
     * @inheritdoc
     */
    public function getType()
    {
        return str_replace('\\','_', get_class($this)).'_widget';
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return get_class($this);
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

    public function __toString()
    {
        return $this->getName().'('.$this->getType().')';
    }
}
