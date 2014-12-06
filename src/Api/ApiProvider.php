<?php
/**
 * ApiProvider.php
 *
 * @author dbojdo - Daniel Bojdo <daniel.bojdo@web-it.eu>
 * Created on Dec 01, 2014, 13:17
 */
namespace Webit\Bundle\GlsBundle\Api;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Inflector\Inflector;
use Webit\GlsAde\Model\AdeAccount;
use Webit\GlsAde\Api\ConsignmentPrepareApi;
use Webit\GlsAde\Api\Factory\ApiFactory;
use Webit\GlsAde\Api\ProfileApi;
use Webit\GlsAde\Api\PickupApi;
use Webit\GlsAde\Api\ServiceApi;
use Webit\GlsAde\Api\AuthApi;
use Webit\GlsAde\Api\MpkApi;
use Webit\GlsAde\Api\SenderAddressApi;
use Webit\GlsAde\Api\PostCodeApi;
use Webit\GlsTracking\Api\Factory\TrackingApiFactory;
use Webit\GlsTracking\Api\TrackingApi;
use Webit\GlsTracking\Model\UserCredentials;
use Webit\GlsTracking\UrlProvider\TrackingUrlProviderFactory;

/**
 * Class ApiProvider
 * @package Webit\Bundle\GlsBundle\Api
 */
class ApiProvider implements ApiProviderInterface
{
    const API_ADE_AUTH = 'ade_auth';
    const API_ADE_MPK = 'mpk';
    const API_ADE_CONSIGNMENT_PREPARE = 'consignment_prepare';
    const API_ADE_PROFILE = 'profile';
    const API_ADE_SERVICE = 'service';
    const API_ADE_SENDER_ADDRESS = 'sender_address';
    const API_ADE_PICKUP = 'pickup';
    const API_ADE_POST_CODE = 'post_code';
    const API_TRACKING = 'tracking';
    const API_TRACKING_URL_PROVIDER = 'tracking_url';

    /**
     * @var ApiFactory
     */
    private $adeApiFactory;

    /**
     * @var TrackingApiFactory
     */
    private $trackingApiFactory;

    /**
     * @var ArrayCollection
     */
    private $api;

    /**
     * @param ApiFactory $adeApiFactory
     * @param TrackingApiFactory $trackingApiFactory
     */
    public function __construct(
        ApiFactory $adeApiFactory,
        TrackingApiFactory $trackingApiFactory
    ) {
        $this->adeApiFactory = $adeApiFactory;
        $this->trackingApiFactory = $trackingApiFactory;

        $this->api = new ArrayCollection();
    }

    /**
     *
     * @param AdeAccount $account
     * @return AuthApi
     */
    public function getAdeAuthApi(AdeAccount $account)
    {
        $key = sprintf('%s_%s', self::API_ADE_AUTH, $account->isTestMode() ? 'test' : 'prod');
        if ($this->api->containsKey($key) == false) {
            $this->api->set($key, $this->adeApiFactory->createAuthApi($account->isTestMode()));
        }

        return $this->api->get($key);
    }

    /**
     *
     * @param AdeAccount $account
     * @return MpkApi
     */
    public function getAdeMpkApi(AdeAccount $account)
    {
        return $this->getAdeApi(self::API_ADE_MPK, $account);
    }

    /**
     *
     * @param AdeAccount $account
     * @return ConsignmentPrepareApi
     */
    public function getAdeConsignmentPrepareApi(AdeAccount $account)
    {
        return $this->getAdeApi(self::API_ADE_CONSIGNMENT_PREPARE, $account);
    }

    /**
     *
     * @param AdeAccount $account
     * @return ProfileApi
     */
    public function getAdeProfileApi(AdeAccount $account)
    {
        return $this->getAdeApi(self::API_ADE_PROFILE, $account);
    }

    /**
     *
     * @param AdeAccount $account
     * @return ServiceApi
     */
    public function getAdeServiceApi(AdeAccount $account)
    {
        return $this->getAdeApi(self::API_ADE_SERVICE, $account);
    }

    /**
     *
     * @param AdeAccount $account
     * @return SenderAddressApi
     */
    public function getAdeSenderAddressApi(AdeAccount $account)
    {
        return $this->getAdeApi(self::API_ADE_SENDER_ADDRESS, $account);
    }

    /**
     *
     * @param AdeAccount $account
     * @return PickupApi
     */
    public function getAdePickupApi(AdeAccount $account)
    {
        return $this->getAdeApi(self::API_ADE_PICKUP, $account);
    }

    /**
     *
     * @param AdeAccount $account
     * @return PostCodeApi
     */
    public function getAdePostCodeApi(AdeAccount $account)
    {
        return $this->getAdeApi(self::API_ADE_POST_CODE, $account);
    }

    /**
     *
     * @param UserCredentials $credentials
     * @return TrackingApi
     */
    public function getTrackingApi(UserCredentials $credentials)
    {
        $key = sprintf('%s_%s', self::API_TRACKING, $credentials->getUsername());
        if (! $this->api->containsKey($key)) {
            $this->api->set(
                $key,
                $this->trackingApiFactory->createTrackingApi(
                    $credentials
                )
            );
        }

        return $this->api->get($key);
    }

    /**
     * @param $api
     * @param AdeAccount $account
     * @return mixed
     */
    private function getAdeApi($api, AdeAccount $account)
    {
        $key = sprintf('%s_%s_%s', $account->getUsername(), $account->isTestMode() ? 'test' : 'prod', $api);
        if (! $this->api->containsKey($key)) {
            $this->api->set($key, $this->createAdeApi($api, $account));
        }

        return $this->api->get($key);
    }

    /**
     * @param string $api
     * @param AdeAccount $account
     * @return mixed
     */
    private function createAdeApi($api, AdeAccount $account)
    {
        $factoryMethod = sprintf('create%sApi', ucfirst(Inflector::camelize($api)));

        return call_user_func_array(
            array($this->adeApiFactory, $factoryMethod),
            array($this->getAdeAuthApi($account), $account)
        );
    }
}
