<?php

namespace Tkuska\DashboardBundle\Widget;

use Symfony\Component\HttpFoundation\Response;

/**
 * Description of WidgetInterface
 *
 * @author Tomasz Kuśka <tomasz.kuska@gmail.com>
 */
interface WidgetTypeInterface
{
    /**
     * @return string return widgets HTML source
     */
    public function render();

    /**
     * @return integer returns widget height
     */
    public function getHeight();

    /**
     * @return integer returns widget width
     */
    public function getWidth();

    /**
     * @return integer returns widget X position
     */
    public function getX();

    /**
     * @return integer returns widget Y position
     */
    public function getY();
    
    /**
     * @return string returns widget type
     */
    public function getType();
    
    /**
     * @return string returns widget name
     */
    public function getName();

    /**
     * @return json schema for config
     */
    public function getJsonSchema();

    /**
     * @return string returns widget title
     */
    public function getTitle();
    
    /**
     * @param \Tkuska\DashboardBundle\Entity\Widget $widget
     */
    public function setParams(\Tkuska\DashboardBundle\Entity\Widget $widget);

    /**
     * @return bool
     *
     * Is the widget supported ?
     */
    public function support(): bool;

    /**
     * @return bool
     *
     * Should the widget be asynchronously loaded ?
     */
    public function supportsAjax(): bool;

    /**
     * @param Response $response
     * @return Response
     * @throws \Psr\Cache\InvalidArgumentException
     *
     * The Response that represents this widget passes through this function,
     * so you can edit your Response.
     * By default, it caches the widget for 300 seconds. Make sure to not cache editable widgets, such as post-its.
     */
    public function transformResponse(Response $response): Response;
}
