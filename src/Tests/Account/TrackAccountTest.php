<?php
/**
 * TrackAccountTest.php
 *
 * @author dbojdo - Daniel Bojdo <daniel.bojdo@web-it.eu>
 * Created on Dec 04, 2014, 10:14
 */

namespace Webit\Bundle\GlsBundle\Tests\Account;

use Webit\Bundle\GlsBundle\Account\TrackAccount;

/**
 * Class TrackAccountTest
 * @package Webit\Bundle\GlsBundle\Tests\Account
 */
class TrackAccountTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldBeAwareOfAliasAndUsernameAndPassword()
    {
        $alias = 'alias-1';
        $username = 'username';
        $password = 'password';
        $testEnv = true;

        $account = new TrackAccount($alias, $username, $password);

        $this->assertEquals($alias, $account->getAlias());
        $this->assertEquals($username, $account->getUsername());
        $this->assertEquals($password, $account->getPassword());
    }
}
 