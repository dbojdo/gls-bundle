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
use Webit\Bundle\GlsBundle\Account\AdeAccount;
use Webit\Bundle\GlsBundle\Account\TrackAccount;
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
use Webit\GlsTracking\UrlProvider\TrackingUrlProviderFactoryInterface;

/**
 * Class ApiProvider
 * @package Webit\Bundle\GlsBundle\Api
 */
class ApiProvider implements ApiProviderInterface
{
    const API_ADE_AUTH = 'ade_auth';
    const API_ADE_MPK = 'mpk';
    const API_ADE_CONSIGNMENT_PREPARE = 'consignment_prepare_api';
    const API_ADE_PROFILE = 'profile';
    const API_ADE_SERVICE = 'service';
    const API_ADE_SENDER_ADDRESS = 'sender_address';
    const API_ADE_PICKUP = 'pickup';
    const API_ADE_POST_CODE = 'post_code';
    const API_TRACKING = 'tracking';
    const API_TRACKING_URL_PROVIDER = 'trackingUrl';

    /**
     * @var ApiFactory
     */
    private $adeApiFactory;

    /**
     * @var TrackingApiFactory
     */
    private $trackingApiFactory;

    /**
     * @var TrackingUrlProviderFactoryInterface
     */
    private $trackingUrlProviderFactory;

    /**
     * @var ArrayCollection
     */
    private $api;

    /**
     * @param ApiFactory $adeApiFactory
     * @param TrackingApiFactory $trackingApiFactory
     * @param TrackingUrlProviderFactoryInterface $trackingUrlProviderFactory
     */
    public function __construct(
        ApiFactory $adeApiFactory,
        TrackingApiFactory $trackingApiFactory,
        TrackingUrlProviderFactoryInterface $trackingUrlProviderFactory
    ) {
        $this->adeApiFactory = $adeApiFactory;
        $this->trackingApiFactory = $trackingApiFactory;
        $this->trackingUrlProviderFactory = $trackingUrlProviderFactory;

        $this->api = new ArrayCollection();
    }

    /**
     *
     * @param AdeAccount $account
     * @return AuthApi
     */
    public function getAdeAuthApi(AdeAccount $account)
    {
        $key = sprintf('%s_%s', self::API_ADE_AUTH, $account->isTestEnvironment() ? 'test' : 'prod');
        if ($this->api->containsKey($key) == false) {
            $this->api->set($key, $this->adeApiFactory->createAuthApi($account->isTestEnvironment()));
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
     * @param TrackAccount $account
     * @return TrackingApi
     */
    public function getTrackingApi(TrackAccount $account)
    {
        $key = sprintf('%s_%s', self::API_TRACKING, $account->getAlias());
        if (! $this->api->containsKey($key)) {
            $this->checkTrackingAccount($account);
            $this->api->set(
                $key,
                $this->trackingApiFactory->createTrackingApi(
                    $account->getTrackUsername(), $account->getTrackPassword()
                )
            );
        }

        return $this->api->get($key);
    }

    /**
     * @param TrackAccount $account
     * @return mixed
     */
    public function getTrackingUrlProvider(TrackAccount $account)
    {
        $key = sprintf('%s_%s', self::TRACKING_URL_PROVIDER, $account->getAlias());
        if (! $this->api->containsKey($key)) {
            $this->checkTrackingAccount($account);
            $this->api->set(
                $key,
                $this->trackingApiFactory->createTrackingApi(
                    $account->getTrackUsername(), $account->getTrackPassword()
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
        $key = sprintf('%s_%s', $account->getAlias(), $api);
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
        $this->checkAdeAccount($account);
        $factoryMethod = sprintf('create%sApi', ucfirst(Inflector::camelize($api)));

        return call_user_func_array(
            $this->adeApiFactory,
            $factoryMethod,
            array($this->getAdeAuthApi($account), $account->getAdeUsername(), $account->getAdePassword())
        );
    }

    /**
     * @param AdeAccount $account
     * @return bool
     */
    private function checkAdeAccount(AdeAccount $account)
    {
        if (! $account->getUsername() || ! $account->getPassword()) {
            throw new \InvalidArgumentException(
                'GLS ADE account has not been configured properly: Missing username and/or password'
            );
        }

        return true;
    }

    /**
     * @param TrackAccount $account
     * @return bool
     */
    private function checkTrackingAccount(TrackAccount $account)
    {
        if (! $account->getUsername() || ! $account->getPassword()) {
            throw new \InvalidArgumentException(
                'GLS Track & Trace account has not been configured properly: Missing username and/or password'
            );
        }

        return true;
    }
}
