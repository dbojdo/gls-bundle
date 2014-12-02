<?php
/**
 * WebitGlsExtension.php
 *
 * @author dbojdo - Daniel Bojdo <daniel.bojdo@web-it.eu>
 * Created on Dec 01, 2014, 12:46
 */
namespace Webit\Bundle\GlsBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Class WebitGlsExtension
 * @package Webit\Bundle\GlsBundle\DependencyInjection
 */
class WebitGlsExtension extends Extension
{
    /**
     * Loads a specific configuration.
     *
     * @param array $configs
     * @param ContainerBuilder $container A ContainerBuilder instance
     *
     * @internal param array $config An array of configuration values
     * @api
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('account.xml');
        $loader->load('api.xml');

        if ($config['ade_accounts']) {
            $this->loadAdeAccounts($container, $config['ade_accounts']);
        }

        if (isset($config['track_accounts'])) {
            $this->loadTrackAccounts($container, $config['track_accounts']);
        }
    }

    private function loadAdeAccounts(ContainerBuilder $container, array $accounts)
    {
        $manager = $container->getDefinition('webit_gls.account_manager.default');
        foreach ($accounts as $alias => $arAccount) {
            $manager->addMethodCall(
                'registerAdeAccount',
                array(
                    new Definition(
                        'Webit\Bundle\GlsBundle\Account\AdeAccount',
                        array($alias, $arAccount['username'], $arAccount['password'], $arAccount['test_mode'])
                    )
                )
            );
        }
    }

    private function loadTrackAccounts(ContainerBuilder $container, array $accounts)
    {
        $manager = $container->getDefinition('webit_gls.account_manager.default');
        foreach ($accounts as $alias => $arAccount) {
            $manager->addMethodCall(
                'registerTrackAccount',
                array(
                    new Definition(
                        'Webit\Bundle\GlsBundle\Account\TrackAccount',
                        array($alias, $arAccount['username'], $arAccount['password'])
                    )
                )
            );
        }
    }
}
