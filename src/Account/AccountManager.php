<?php
/**
 * AccountManager.php
 *
 * @author dbojdo - Daniel Bojdo <daniel.bojdo@web-it.eu>
 * Created on Dec 01, 2014, 13:08
 */
namespace Webit\Bundle\GlsBundle\Account;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class AccountManager
 * @package Webit\Bundle\GlsBundle\Account
 */
class AccountManager implements AccountManagerInterface
{
    /**
     * @var ArrayCollection
     */
    private $accounts;

    public function __construct()
    {
        $this->accounts = new ArrayCollection();
    }

    /**
     * @param Account $account
     */
    public function registerAccount(Account $account)
    {
        $this->accounts->set($account->getAlias(), $account);
    }

    /**
     * @param string $alias
     * @return Account
     */
    public function getAccount($alias)
    {
        return $this->accounts->get($alias);
    }
}
