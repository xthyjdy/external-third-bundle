<?php

namespace Eivorvch\ExternalThirdBundle;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ExternalThirdBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../config'));
        try {
            $loader->load('services.yaml');
        } catch (\Exception $e) {
            // Log the error if the configuration fails to load.
            error_log('___my_err42: ' . $e->getMessage());
        }
    }
}