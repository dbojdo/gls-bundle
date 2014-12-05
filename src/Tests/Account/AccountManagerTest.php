<?php
/**
 * AccountManagerTest.php
 *
 * @author dbojdo - Daniel Bojdo <daniel.bojdo@dxi.eu>
 * Created on Dec 04, 2014, 10:14
 * Copyright (C) DXI Ltd
 */

namespace Webit\Bundle\GlsBundle\Tests\Account;

use Webit\Bundle\GlsBundle\Account\AccountManager;
use Webit\Bundle\GlsBundle\Account\AdeAccount;
use Webit\Bundle\GlsBundle\Account\TrackAccount;

/**
 * Class AccountManagerTest
 * @package Webit\Bundle\GlsBundle\Tests\Account
 */
class AccountManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AccountManager
     */
    private $manager;

    public function setUp()
    {
        $this->manager = new AccountManager();
    }

    /**
     * @test
     */
    public function shouldManageAdeAccounts()
    {
        $account1 = $this->createAdeAccount('alias-1');
        $account2 = $this->createAdeAccount('alias-2');

        $this->manager->registerAdeAccount($account1);
        $this->manager->registerAdeAccount($account2);

        $this->assertSame($account1, $this->manager->getAdeAccount('alias-1'));
        $this->assertSame($account2, $this->manager->getAdeAccount('alias-2'));
    }

    /**
     * @test
     */
    public function shouldManageTrackAccounts()
    {
        $account1 = $this->createTrackAccount('alias-1');
        $account2 = $this->createTrackAccount('alias-2');

        $this->manager->registerTrackAccount($account1);
        $this->manager->registerTrackAccount($account2);

        $this->assertSame($account1, $this->manager->getTrackAccount('alias-1'));
        $this->assertSame($account2, $this->manager->getTrackAccount('alias-2'));
    }

    /**
     * @param string $alias
     * @return \PHPUnit_Framework_MockObject_MockObject|TrackAccount
     */
    private function createTrackAccount($alias)
    {
        $account = $this->getMockBuilder('Webit\Bundle\GlsBundle\Account\TrackAccount')
                        ->disableOriginalConstructor()->getMock();

        $account->expects($this->any())->method('getAlias')->willReturn($alias);

        return $account;
    }

    /**
     * @param string $alias
     * @return \PHPUnit_Framework_MockObject_MockObject|AdeAccount
     */
    private function createAdeAccount($alias)
    {
        $account = $this->getMockBuilder('Webit\Bundle\GlsBundle\Account\AdeAccount')
                        ->disableOriginalConstructor()->getMock();

        $account->expects($this->any())->method('getAlias')->willReturn($alias);

        return $account;
    }
}
 