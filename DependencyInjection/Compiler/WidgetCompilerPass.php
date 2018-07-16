<?php

namespace Tkuska\DashboardBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Description of WidgetCompilerPass
 *
 * @author Tomasz Kuśka <tomasz.kuska@gmail.com>
 */
class WidgetCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('tkuska_dashboard.widget_provider')) {
            return;
        }

        $definition = $container->findDefinition(
                'tkuska_dashboard.widget_provider'
        );

        $taggedServices = $container->findTaggedServiceIds(
                'tkuska_dashboard.widget'
        );
        foreach ($taggedServices as $id => $tags) {
            $widget = new Reference($id);
            $definition->addMethodCall(
                    'addWidgetType', array($widget, $widget->getType())
            );
        }
    }
}
