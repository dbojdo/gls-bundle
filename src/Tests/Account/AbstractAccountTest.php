<?php
/**
 * AbstractAccountTest.php
 *
 * @author dbojdo - Daniel Bojdo <daniel.bojdo@dxi.eu>
 * Created on Dec 04, 2014, 10:13
 * Copyright (C) DXI Ltd
 */

namespace Webit\Bundle\GlsBundle\Tests\Account;

use Webit\Bundle\GlsBundle\Account\AbstractAccount;

/**
 * Class AbstractAccountTest
 * @package Webit\Bundle\GlsBundle\Tests\Account
 */
class AbstractAccountTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldBeAwareOfAliasAndUsernameAndPassword()
    {
        $alias = 'alias-1';
        $username = 'username';
        $password = 'password';

        /** @var AbstractAccount $account */
        $account = $this->getMockForAbstractClass('Webit\Bundle\GlsBundle\Account\AbstractAccount', array($alias, $username, $password));
        $this->assertEquals($alias, $account->getAlias());
        $this->assertEquals($username, $account->getUsername());
        $this->assertEquals($password, $account->getPassword());
    }
}
