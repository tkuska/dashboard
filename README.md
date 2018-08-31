This bundle provides a dashboard with customizable widgets.

Note that the docs are still in work, and that the bundle will probably be rebranded.

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
php bin/console doctrine:schema:update
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

You *must* implement the render() method.

This method returns simple HTML. You can use $twig->render("template.html.twig", array(...)).
Your templates should extend the base widget template, because it has some interactions. Otherwise, make sure you implement those interactions.
```twig
{% extends '@TkuskaDashboard/widget/base_widget.html.twig' %}
```

This method renders the widget that is shown. All your logic should be in there.