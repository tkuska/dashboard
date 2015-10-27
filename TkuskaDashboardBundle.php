<?php

namespace Tkuska\DashboardBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Tkuska\DashboardBundle\DependencyInjection\Compiler\WidgetCompilerPass;

class TkuskaDashboardBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new WidgetCompilerPass());
    }
}
