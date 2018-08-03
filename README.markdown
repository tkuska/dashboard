TkuskaDashboardBundle
=============

The TkuskaDashboardBundle allows you to create dashboard and add custom widgets to it.
It's using http://troolee.github.io/gridstack.js/ to manage widgets.

Installation
------------
Step 1: Download using composer
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Require the bundle with composer:

.. code-block:: bash

    $ composer require tkuska/dashoard-bundle "dev-master"


Step 2: Enable the bundle
~~~~~~~~~~~~~~~~~~~~~~~~~

Enable the bundle in the kernel::

    <?php
    // app/AppKernel.php

    public function registerBundles()
    {
        $bundles = array(
            // ...
            new Tkuska\DashboardBundle\TkuskaDashboardBundle(),
            // ...
        );
    }

Step 3: Update database schema
~~~~~~~~~~~~~~~~~~~~~~~~~
    
    php app/console doctrine:schema:update


Usage
------------
This bundle allows to store user's widgets instances in databases, so every logged user can use differend widgets in his dashboard.

To get users widgets just use in your controller:

    $this->get('tkuska_dashboard.widget_provider')->getMyWidgets();

In twig, to render widgets you can use 

    {% for widget in widgets %}
        {{ renderWidget(widget) }}
    {% endfor %}

and '{{ renderWidgetSelector() }}' to render list of available widgets

Creating first widget
------------
By default there is only one widget available (for now) - calendar.
To create your own widget, create service and tag it with `"tkuska_dashboard.widget"`
Example:

        <service id="acme_demo.hello_world.dashboard.widget" class="Acme\DemoBundle\Widgets\HelloWorldWidget">
            <tag name="tkuska_dashboard.widget" alias="acme_hello_world_widget" />
        </service>

Your `Acme\DemoBundle\Widgets\HelloWorldWidget` class needs to implement `Tkuska\DashboardBundle\Widget\WidgetTypeInterface`
You can inject in your widget whatever you need.

Documentation still in progress... :)