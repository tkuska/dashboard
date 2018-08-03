<?php

namespace Tkuska\DashboardBundle\Widgets;

use Twig_Environment as Environment;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Lle\EasyAdminPlusBundle\Form\Type\JsonType;

use Tkuska\DashboardBundle\Entity\Widget;
use Tkuska\DashboardBundle\Widget\WidgetTypeInterface;

/**
 * Description of CalendarWidget.
 *
 */
abstract class AbstractWidget implements WidgetTypeInterface
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int x position 
     */
    protected $x = 0;

    /**
     * @var int y position
     */
    protected $y = 1000;

    /**
     * @var int widget width
     */
    protected $width = 4;

    /**
     * @var int widget height
     */
    protected $height = 5;

    /**
     * @var string json config
     */
    private $config;

    /**
     * @var string widget title
     */
    private $title;

    /**
     * @var Environment
     */
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
    public function getConfig($key=null)
    {
        $config = json_decode($this->config, true);
        
        if ($key) {
            return $config[$key] ?? null;
        }
        return $config;
    }

    /**
     * @inheritdoc
     */
    public function getTitle()
    {
        return $this->title;
    }

    public function getJsonSchema()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function setParams(Widget $widget)
    {
        $this->id = $widget->getId();
        $this->x = $widget->getX();
        $this->y = $widget->getY();
        $this->width = $widget->getWidth();
        $this->height = $widget->getHeight();
        $this->config = $widget->getConfig();
        $this->title = $widget->getTitle();

        return $this;
    }

    public function __toString()
    {
        return $this->getName().'('.$this->getType().')';
    }

    public function getConfigForm()
    {
        if ($this->getJsonSchema() != null) {
            $formFactory = Forms::createFormFactory();
            $form = $formFactory->create()
                ->add('Configuration', JsonType::class, array('schema' => $this->getJsonSchema(), 'theme' => 'bootstrap3'))
                ->add('submit', SubmitType::class, array('label' => 'Enregistrer'))
                ->add('id', HiddenType::class, array('data' => $this->getId()));
            
            return $form->createView();
        }
        return null;
    }
}
