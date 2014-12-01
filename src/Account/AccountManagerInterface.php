<?php
/**
 * AccountManagerInterface.php
 *
 * @author dbojdo - Daniel Bojdo <daniel.bojdo@web-it.eu>
 * Created on Dec 01, 2014, 13:44
 */
namespace Webit\Bundle\GlsBundle\Account;

/**
 * Interface AccountManagerInterface
 * @package Webit\Bundle\GlsBundle\Account
 */
interface AccountManagerInterface
{
    /**
     * @param Account $account
     */
    public function registerAccount(Account $account);

    /**
     * @param string $alias
     * @return Account
     */
    public function getAccount($alias);
}
