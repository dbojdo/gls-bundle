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
     * @var string
     */
    private $hash;

    private $configMerge = array();

    public function __construct($environment, $debug)
    {
        parent::__construct($environment, $debug);
        $this->hash = md5(microtime().mt_rand(0, 1000000));
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
            new FrameworkBundle(),
            new JMSSerializerBundle(),
            new WebitSoapApiBundle(),
            new WebitGlsBundle()
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
        $config = file_get_contents(__DIR__.'/config/config.yml');
        if ($this->configMerge) {
            $config = Yaml::parse($config);
            foreach ($this->configMerge as $configToMerge) {
                $config = array_replace($config, Yaml::parse($configToMerge));
            }
            $config = Yaml::dump($config);
        }

        file_put_contents($this->getCacheDir() .'/config.yml', $config);

        $loader->load($this->getCacheDir() .'/config.yml');
    }

    /**
     * @return string
     */
    public function getCacheDir()
    {
        $dir = sys_get_temp_dir() . '/' . $this->hash . '/cache';
        @mkdir($dir, 755, true);

        return $dir;
    }

    /**
     * {@inheritdoc}
     *
     * @api
     */
    public function getLogDir()
    {
        return $this->getCacheDir().'/logs';
    }

    public function mergeConfig($configYml)
    {
        $this->configMerge[] = $configYml;
    }

    /**
     * Gets the container class.
     *
     * @return string The container class
     */
    protected function getContainerClass()
    {
        return $this->name.ucfirst($this->environment).($this->debug ? 'Debug' : '').$this->hash.'ProjectContainer';
    }
}
