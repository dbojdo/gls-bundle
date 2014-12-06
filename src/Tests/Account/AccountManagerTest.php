<?php
/**
 * AccountManagerTest.php
 *
 * @author dbojdo - Daniel Bojdo <daniel.bojdo@web-it.eu>
 * Created on Dec 04, 2014, 10:14
 */

namespace Webit\Bundle\GlsBundle\Tests\Account;

use Webit\Bundle\GlsBundle\Account\AccountManager;
use Webit\GlsAde\Model\AdeAccount;
use Webit\GlsTracking\Model\UserCredentials;

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
        $account1 = $this->createAdeAccount('user-1');
        $account2 = $this->createAdeAccount('user-2');

        $this->manager->registerAdeAccount('alias-1', $account1);
        $this->manager->registerAdeAccount('alias-2', $account2);

        $this->assertSame($account1, $this->manager->getAdeAccount('alias-1'));
        $this->assertSame($account2, $this->manager->getAdeAccount('alias-2'));
    }

    /**
     * @test
     */
    public function shouldManageTrackAccounts()
    {
        $account1 = $this->createTrackAccount('user-1');
        $account2 = $this->createTrackAccount('user-2');

        $this->manager->registerTrackAccount('alias-1', $account1);
        $this->manager->registerTrackAccount('alias-2', $account2);

        $this->assertSame($account1, $this->manager->getTrackAccount('alias-1'));
        $this->assertSame($account2, $this->manager->getTrackAccount('alias-2'));
    }

    /**
     * @param string $username
     * @return \PHPUnit_Framework_MockObject_MockObject|UserCredentials
     */
    private function createTrackAccount($username)
    {
        $account = $this->getMockBuilder('Webit\GlsTracking\Model\UserCredentials')
                        ->disableOriginalConstructor()->getMock();

        $account->expects($this->any())->method('getAlias')->willReturn($username);

        return $account;
    }

    /**
     * @param string $username
     * @return \PHPUnit_Framework_MockObject_MockObject|AdeAccount
     */
    private function createAdeAccount($username)
    {
        $account = $this->getMockBuilder('Webit\GlsAde\Model\AdeAccount')
                        ->disableOriginalConstructor()->getMock();

        $account->expects($this->any())->method('getUsername')->willReturn($username);

        return $account;
    }
}
 