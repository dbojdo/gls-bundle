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
     * @param AbstractAccount $account
     * @param string $key
     */
    private function registerAccount(AbstractAccount $account, $key)
    {
        $this->accounts->set($key, $account);
    }

    /**
     * @param AdeAccount $account
     */
    public function registerAdeAccount(AdeAccount $account)
    {
        $key = $this->createKey($account->getAlias(), 'ade');
        $this->registerAccount($account, $key);
    }

    /**
     * @param TrackAccount $account
     */
    public function registerTrackAccount(TrackAccount $account)
    {
        $key = $this->createKey($account->getAlias(), 'track');
        $this->registerAccount($account, $key);
    }

    /**
     * @param string $alias
     * @return AdeAccount
     */
    public function getAdeAccount($alias)
    {
        $key = $this->createKey($alias, 'ade');
        return $this->accounts->get($key);
    }

    /**
     * @param string $alias
     * @return TrackAccount
     */
    public function getTrackAccount($alias)
    {
        $key = $this->createKey($alias, 'track');
        return $this->accounts->get($key);
    }

    /**
     * @param string $alias
     * @param string $type
     * @return string
     */
    private function createKey($alias, $type)
    {
        return sprintf('%s_%s', $type, $alias);
    }
}
