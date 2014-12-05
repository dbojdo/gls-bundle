<?php
/**
 * AdeAccountTest.php
 *
 * @author dbojdo - Daniel Bojdo <daniel.bojdo@web-it.eu>
 * Created on Dec 04, 2014, 10:13
 */

namespace Webit\Bundle\GlsBundle\Tests\Account;

use Webit\Bundle\GlsBundle\Account\AdeAccount;

/**
 * Class AdeAccountTest
 * @package Webit\Bundle\GlsBundle\Tests\Account
 */
class AdeAccountTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldBeAwareOfAliasAndUsernameAndPasswordAndTestEnv()
    {
        $alias = 'alias-1';
        $username = 'username';
        $password = 'password';
        $testEnv = true;

        $account = new AdeAccount($alias, $username, $password, $testEnv);

        $this->assertEquals($alias, $account->getAlias());
        $this->assertEquals($username, $account->getUsername());
        $this->assertEquals($password, $account->getPassword());
        $this->assertEquals($testEnv, $account->isTestEnvironment());
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     * @dataProvider getAccountData
     *
     * @param $alias
     * @param $username
     * @param $password
     */
    public function shouldThrowExceptionWithAnyEmptyValue($alias, $username, $password)
    {
        new AdeAccount($alias, $username, $password);
    }

    /**
     * @return array
     */
    public function getAccountData()
    {
        return array(
            array(null, 'user', 'pass'),
            array('alias', null, 'pass'),
            array('alias', 'user', null)
        );
    }
}
 