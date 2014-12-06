<?php
/**
 * AccountManagerInterface.php
 *
 * @author dbojdo - Daniel Bojdo <daniel.bojdo@web-it.eu>
 * Created on Dec 01, 2014, 13:44
 */
namespace Webit\Bundle\GlsBundle\Account;

use Webit\GlsAde\Model\AdeAccount;
use Webit\GlsTracking\Model\UserCredentials;

/**
 * Interface AccountManagerInterface
 * @package Webit\Bundle\GlsBundle\Account
 */
interface AccountManagerInterface
{
    /**
     * @param string $alias
     * @param AdeAccount $account
     */
    public function registerAdeAccount($alias, AdeAccount $account);

    /**
     * @param string $alias
     * @param UserCredentials $account
     */
    public function registerTrackAccount($alias, UserCredentials $account);

    /**
     * @param string $alias
     * @return AdeAccount
     */
    public function getAdeAccount($alias);

    /**
     * @param string $alias
     * @return UserCredentials
     */
    public function getTrackAccount($alias);
}
