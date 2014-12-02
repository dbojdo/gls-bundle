<?php
/**
 * AccountPass.php
 *
 * @author dbojdo - Daniel Bojdo <daniel.bojdo@dxi.eu>
 * Created on Dec 02, 2014, 12:51
 * Copyright (C) DXI Ltd
 */

namespace Webit\Bundle\GlsBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * Class AccountPass
 * @package Webit\Bundle\GlsBundle\DependencyInjection\Compiler
 */
class AccountPass implements CompilerPassInterface
{
    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     *
     * @api
     */
    public function process(ContainerBuilder $container)
    {
////        $manager = $container->getDefinition('webit_gls.account_manager.default');
//        $accounts = $container->getParameter('webit_gls.ade_accounts');
////        var_dump(count($accounts));
////        $a = array_shift($accounts);
//        foreach ($accounts as $alias => $row) {
//            var_dump($alias);
//            $manager = $container->getDefinition('webit_gls.account_manager.default');
//            $manager->addMethodCall(
//                'registerAdeAccount',
//                array(
//                    new Definition(
//                        'Webit\Bundle\GlsBundle\Account\AdeAccount',
//                        array($alias, $row['username'], $row['password'], $row['test_mode'])
//                    )
//                )
//            );
//        }
//        foreach ($accounts as $alias => $row) {
////            var_dump($alias);
//
//            $manager->addMethodCall(
//                'registerAdeAccount',
//                array(
//                    new Definition(
//                        'Webit\Bundle\GlsBundle\Account\AdeAccount',
//                        array('alias-1', 'dupa', 'cycki', true)
//                    )
//                )
//            );
//            var_dump('add');
//            break;
//        }

//        $manager->addMethodCall(
//            'registerAdeAccount',
//            array(
//                new Definition(
//                    'Webit\Bundle\GlsBundle\Account\AdeAccount',
//                    array('alias-1', 'dupa', 'cycki', true)
//                )
//            )
//        );

//        $accounts = $container->getParameter('webit_gls.track_accounts');
//        foreach ($accounts as $alias => $row) {
//            $manager->addMethodCall(
//                'registerTrackAccount',
//                array(
//                    new Definition(
//                        'Webit\Bundle\GlsBundle\Account\TrackAccount',
//                        array($alias, $row['username'], $row['password'])
//                    )
//                )
//            );
//        }
    }
}
