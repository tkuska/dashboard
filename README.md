This bundle provides a dashboard with customizable widgets.

## Install

`composer require 2lenet/dashboard-bundle`

## Setting up the bundle

Add this to services.yaml
```yaml
App\Widgets\:
        resource: '../src/Widgets'
        tags: ['tkuska_dashboard.widget']
```

Add this to routes.yaml
```yaml
dashboard_widgets:
    resource: "@TkuskaDashboardBundle/Resources/config/routes.yaml"
```

You also need to update your database to have widget table.
```
php bin/console make:migration
php bin/console doc:mi:mi
```

## Making widgets

All your widget classes will lie in src/Widgets/.

They must extend AbstractWidget.
```php
use Tkuska\DashboardBundle\Widgets\AbstractWidget;
```

Existing methods that can be overriden:
- __construct: the constructor for usual services injection. You need at least a Twig_Environment ($twig)
- getName: must return general name of the widget
- getJsonSchema: must return an array (that will be json encoded) that represents an Json Schema, for the widget configuration. (see also https://github.com/json-editor/json-editor)
- getConfigForm: makes the configuration form. You shouldn't need to modify it, but it can happen in some cases (ex: bootstrap version)
- support: returns true if widget is supported. If not, user won't be able to add such widget nor render it
- supportsAjax: returns true if widget should be loaded asynchronously. If not, it will be loaded directly with the dashboard
- transformResponse: takes Response representing the widget as argument and returns response. By default, it caches widgets for 300 seconds.

You *must* implement the render() method.

This method returns simple HTML. You can use $twig->render("template.html.twig", array(...)).
Your templates should extend the base widget template, because it has some interactions. Otherwise, make sure you implement those interactions.
```twig
{% extends '@TkuskaDashboard/widget/base_widget.html.twig' %}
```

Note that base template uses Bootstrap panels, which means it is better to put your widget body in a ```<div class="panel-body">```.

If you use the widget configuration (getJsonSchema) you must pass the form to the template with getConfigForm as 'form'.

This method renders the widget that is shown. All your logic should be in there.


# cache

by default the cache is enable, you can change timeout and key with

```php
public function getCacheKey():string{
    return $this->getId() . "_".md5($this->config);
}

public function getCacheTimeout():int {
    return 300;
}
```

above you see the default return.

If you want disable the cache for a widget getCacheTimeout have to return 0.
