<?php
/**
 * AccountManager.php
 *
 * @author dbojdo - Daniel Bojdo <daniel.bojdo@web-it.eu>
 * Created on Dec 01, 2014, 13:08
 */
namespace Webit\Bundle\GlsBundle\Account;

use Doctrine\Common\Collections\ArrayCollection;
use Webit\GlsAde\Model\AdeAccount;
use Webit\GlsTracking\Model\UserCredentials;

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
     * @param mixed $account
     * @param string $key
     */
    private function registerAccount($account, $key)
    {
        $this->accounts->set($key, $account);
    }

    /**
     * @param string $alias
     * @param AdeAccount $account
     */
    public function registerAdeAccount($alias, AdeAccount $account)
    {
        $key = $this->createKey($alias, 'ade');
        $this->registerAccount($account, $key);
    }

    /**
     * @param string $alias
     * @param UserCredentials $account
     */
    public function registerTrackAccount($alias, UserCredentials $account)
    {
        $key = $this->createKey($alias, 'track');
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
