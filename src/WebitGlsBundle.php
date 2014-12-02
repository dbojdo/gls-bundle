<?php
/**
 * WebitGlsBundle.php
 *
 * @author dbojdo - Daniel Bojdo <daniel.bojdo@web-it.eu>
 * Created on Dec 01, 2014, 12:45
 */
namespace Webit\Bundle\GlsBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Webit\Bundle\GlsBundle\DependencyInjection\Compiler\AccountPass;

/**
 * Class WebitGlsBundle
 * @package Webit\Bundle\GlsBundle
 */
class WebitGlsBundle extends Bundle
{
    public function build(ContainerBuilder $builder)
    {
        $builder->addCompilerPass(new AccountPass());
    }
}
