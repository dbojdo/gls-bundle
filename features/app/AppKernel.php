<?php
/**
 * AppKernel.php
 *
 * @author dbojdo - Daniel Bojdo <daniel.bojdo@dxi.eu>
 * Created on Dec 02, 2014, 11:05
 * Copyright (C) DXI Ltd
 */

namespace Webit\Bundle\GlsBundle\Features\App;

use JMS\SerializerBundle\JMSSerializerBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Yaml\Yaml;
use Webit\Bundle\GlsBundle\WebitGlsBundle;
use Webit\Bundle\SoapApiBundle\WebitSoapApiBundle;

/**
 * Class AppKernel
 * @package Webit\Bundle\GlsBundle\Features\App
 */
class AppKernel extends Kernel
{
    /**
     * @var bool
     */
    private $configPrepared = false;

    public function __construct($environment, $debug)
    {
        parent::__construct($environment, $debug);
    }

    /**
     * Returns an array of bundles to register.
     *
     * @return BundleInterface[] An array of bundle instances.
     *
     * @api
     */
    public function registerBundles()
    {
        $bundles = array(
            new WebitSoapApiBundle(),
            new WebitGlsBundle(),
            new FrameworkBundle(),
            new JMSSerializerBundle(),

        );

        return $bundles;
    }

    /**
     * Loads the container configuration.
     *
     * @param LoaderInterface $loader A LoaderInterface instance
     *
     * @api
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        if ($this->configPrepared == false) {
            copy(__DIR__.'/config/config.yml', $this->getCacheDir() .'/config.yml');
            $this->configPrepared = true;
        }

        $loader->load($this->getCacheDir() .'/config.yml');
    }

    /**
     * @return string
     */
    public function getCacheDir()
    {
        return sys_get_temp_dir().'/WebitGlsBundle/cache';
    }

    public function mergeConfig($configYml)
    {
        $baseConfig = Yaml::parse(file_get_contents(__DIR__.'/config/config.yml'));
        $arConfig = Yaml::parse($configYml);

        $config = array_replace($baseConfig, $arConfig);

        file_put_contents($this->getCacheDir().'/config.yml', Yaml::dump($config));
        $this->configPrepared = true;
    }
}
