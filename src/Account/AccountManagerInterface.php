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
     * @param AdeAccount $account
     */
    public function registerAdeAccount(AdeAccount $account);

    /**
     * @param TrackAccount $account
     */
    public function registerTrackAccount(TrackAccount $account);

    /**
     * @param string $alias
     * @return AdeAccount
     */
    public function getAdeAccount($alias);

    /**
     * @param string $alias
     * @return TrackAccount
     */
    public function getTrackAccount($alias);
}
