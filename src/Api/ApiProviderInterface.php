<?php
/**
 * ApiProviderInterface.php
 *
 * @author dbojdo - Daniel Bojdo <daniel.bojdo@web-it.eu>
 * Created on Dec 01, 2014, 13:18
 */
namespace Webit\Bundle\GlsBundle\Api;

use Webit\Bundle\GlsBundle\Account\Account;
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
     * @return AuthApi
     */
    public function getAdeAuthApi();

    /**
     *
     * @param Account $account
     * @return MpkApi
     */
    public function getAdeMpkApi(Account $account);

    /**
     *
     * @param Account $account
     * @return ConsignmentPrepareApi
     */
    public function getAdeConsignmentPrepareApi(Account $account);

    /**
     *
     * @param Account $account
     * @return ProfileApi
     */
    public function getAdeProfileApi(Account $account);

    /**
     *
     * @param Account $account
     * @return ServiceApi
     */
    public function getAdeServiceApi(Account $account);

    /**
     *
     * @param Account $account
     * @return SenderAddressApi
     */
    public function getAdeSenderAddressApi(Account $account);

    /**
     *
     * @param Account $account
     * @return PickupApi
     */
    public function getAdePickupApi(Account $account);

    /**
     *
     * @param Account $account
     * @return PostCodeApi
     */
    public function getAdePostCodeApi(Account $account);

    /**
     *
     * @param Account $account
     * @return TrackingApi
     */
    public function getTrackingApi(Account $account);

    /**
     * @param Account $account
     * @return TrackingUrlProvider
     */
    public function getTrackingUrlProvider(Account $account);
}
