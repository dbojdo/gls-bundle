<?php
/**
 * AdeAccountTest.php
 *
 * @author dbojdo - Daniel Bojdo <daniel.bojdo@dxi.eu>
 * Created on Dec 04, 2014, 10:13
 * Copyright (C) DXI Ltd
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
}
 