<?php
/**
 * ApiProviderInterface.php
 *
 * @author dbojdo - Daniel Bojdo <daniel.bojdo@web-it.eu>
 * Created on Dec 01, 2014, 13:18
 */
namespace Webit\Bundle\GlsBundle\Api;

use Webit\Bundle\GlsBundle\Account\AdeAccount;
use Webit\Bundle\GlsBundle\Account\TrackAccount;
use Webit\GlsAde\Api\AuthApi;
use Webit\GlsAde\Api\ConsignmentPrepareApi;
use Webit\GlsAde\Api\MpkApi;
use Webit\GlsAde\Api\PickupApi;
use Webit\GlsAde\Api\PostCodeApi;
use Webit\GlsAde\Api\ProfileApi;
use Webit\GlsAde\Api\SenderAddressApi;
use Webit\GlsAde\Api\ServiceApi;
use Webit\GlsTracking\Api\TrackingApi;
use Webit\GlsTracking\UrlProvider\TrackingUrlProvider;

/**
 * Interface ApiProviderInterface
 * @package Webit\Bundle\GlsBundle\Api
 */
interface ApiProviderInterface
{
    /**
     *
     * @param AdeAccount $account
     * @return AuthApi
     */
    public function getAdeAuthApi(AdeAccount $account);

    /**
     *
     * @param AdeAccount $account
     * @return MpkApi
     */
    public function getAdeMpkApi(AdeAccount $account);

    /**
     *
     * @param AdeAccount $account
     * @return ConsignmentPrepareApi
     */
    public function getAdeConsignmentPrepareApi(AdeAccount $account);

    /**
     *
     * @param AdeAccount $account
     * @return ProfileApi
     */
    public function getAdeProfileApi(AdeAccount $account);

    /**
     *
     * @param AdeAccount $account
     * @return ServiceApi
     */
    public function getAdeServiceApi(AdeAccount $account);

    /**
     *
     * @param AdeAccount $account
     * @return SenderAddressApi
     */
    public function getAdeSenderAddressApi(AdeAccount $account);

    /**
     *
     * @param AdeAccount $account
     * @return PickupApi
     */
    public function getAdePickupApi(AdeAccount $account);

    /**
     *
     * @param AdeAccount $account
     * @return PostCodeApi
     */
    public function getAdePostCodeApi(AdeAccount $account);

    /**
     *
     * @param TrackAccount $account
     * @return TrackingApi
     */
    public function getTrackingApi(TrackAccount $account);

    /**
     * @param TrackAccount $account
     * @return TrackingUrlProvider
     */
    public function getTrackingUrlProvider(TrackAccount $account);
}
