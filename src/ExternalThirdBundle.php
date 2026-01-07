<?php

namespace Eivorvch\ExternalThirdBundle;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ExternalThirdBundle extends Bundle //v3
{
    /**
     * The build method is used to load the bundle's internal services.
     */
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        // Path logic: assumes ExternalThirdBundle.php is in src/
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../config'));

        try {
            $loader->load('services.yaml');
        } catch (\Exception $e) {
            error_log('___my_err42: ' . $e->getMessage());
        }
    }

    /**
     * Overriding this allows the bundle to be configured via config/packages/*.yaml
     * without a separate DependencyInjection/ExternalThirdExtension.php file.
     */
    public function getContainerExtension(): ?ExtensionInterface
    {
        if (null === $this->extension) {
            $this->extension = $this->createContainerExtension();
        }

        return $this->extension;
    }
}
