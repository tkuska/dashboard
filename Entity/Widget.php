<?php

namespace Tkuska\DashboardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="widgets")
 * @ORM\Entity(repositoryClass="Tkuska\DashboardBundle\Entity\Repository\WidgetRepository")
 */

class Widget
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="x", type="integer", nullable=true)
     */
    protected $x = 0;

    /**
     * @ORM\Column(name="y", type="integer", nullable=true)
     */
    protected $y = 0;

    /**
     * @ORM\Column(name="width", type="integer", nullable=true)
     */
    protected $width;

    /**
     * @ORM\Column(name="height", type="integer", nullable=true)
     */
    protected $height;
    
    /**
     * @ORM\Column(name="type", type="string", length=100, nullable=true)
     */
    private $type;
    
    /**
     * @ORM\Column(name="user_id", type="integer", nullable=true)
     */
    private $user_id;
    
    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set x.
     *
     * @param int $x
     *
     * @return Widget
     */
    public function setX($x)
    {
        $this->x = $x;

        return $this;
    }

    /**
     * Get x.
     *
     * @return int
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * Set y.
     *
     * @param int $y
     *
     * @return Widget
     */
    public function setY($y)
    {
        $this->y = $y;

        return $this;
    }

    /**
     * Get y.
     *
     * @return int
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * Set width.
     *
     * @param int $width
     *
     * @return Widget
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get width.
     *
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set height.
     *
     * @param int $height
     *
     * @return Widget
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get height.
     *
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }
   
    /**
     * Set type
     *
     * @param string $type
     * @return Widget
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }
    
    /**
     * 
     */
    public function importConfig(\Tkuska\DashboardBundle\Widget\WidgetTypeInterface $widgetType)
    {
        $this->type = $widgetType->getType();
        $this->width = $widgetType->getWidth();
        $this->height = $widgetType->getHeight();
        $this->x = $widgetType->getX();
        $this->y = $widgetType->getY();
        
        return $this;
    }

    /**
     * Set userId
     *
     * @param int $userId
     *
     * @return Widget
     */
    public function setUserId($userId)
    {
        $this->user_id = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->user_id;
    }
}
