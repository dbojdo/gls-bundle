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
use Webit\Bundle\GlsBundle\Account\Account;
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

    public function __construct(
        AuthApi $adeAuthApi,
        ApiFactory $adeApiFactory,
        TrackingApiFactory $trackingApiFactory,
        TrackingUrlProviderFactoryInterface $trackingUrlProviderFactory
    ) {
        $this->adeApiFactory = $adeApiFactory;
        $this->trackingApiFactory = $trackingApiFactory;
        $this->trackingUrlProviderFactory = $trackingUrlProviderFactory;

        $this->api = new ArrayCollection();
        $this->api->set(self::API_ADE_AUTH, $adeAuthApi);
    }

    /**
     *
     * @return AuthApi
     */
    public function getAdeAuthApi()
    {
        return $this->api->get(self::API_ADE_AUTH);
    }

    /**
     *
     * @param Account $account
     * @return MpkApi
     */
    public function getAdeMpkApi(Account $account)
    {
        return $this->getAdeApi(self::API_ADE_MPK, $account);
    }

    /**
     *
     * @param Account $account
     * @return ConsignmentPrepareApi
     */
    public function getAdeConsignmentPrepareApi(Account $account)
    {
        return $this->getAdeApi(self::API_ADE_CONSIGNMENT_PREPARE, $account);
    }

    /**
     *
     * @param Account $account
     * @return ProfileApi
     */
    public function getAdeProfileApi(Account $account)
    {
        return $this->getAdeApi(self::API_ADE_PROFILE, $account);
    }

    /**
     *
     * @param Account $account
     * @return ServiceApi
     */
    public function getAdeServiceApi(Account $account)
    {
        return $this->getAdeApi(self::API_ADE_SERVICE, $account);
    }

    /**
     *
     * @param Account $account
     * @return SenderAddressApi
     */
    public function getAdeSenderAddressApi(Account $account)
    {
        return $this->getAdeApi(self::API_ADE_SENDER_ADDRESS, $account);
    }

    /**
     *
     * @param Account $account
     * @return PickupApi
     */
    public function getAdePickupApi(Account $account)
    {
        return $this->getAdeApi(self::API_ADE_PICKUP, $account);
    }

    /**
     *
     * @param Account $account
     * @return PostCodeApi
     */
    public function getAdePostCodeApi(Account $account)
    {
        return $this->getAdeApi(self::API_ADE_POST_CODE, $account);
    }

    /**
     *
     * @param Account $account
     * @return TrackingApi
     */
    public function getTrackingApi(Account $account)
    {
        $key = sprintf('%s_%s', self::API_TRACKING, $account->getAlias());
        if (! $this->api->containsKey($key)) {
            $this->checkTrackingAccount();
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
     * @param Account $account
     * @return mixed
     */
    public function getTrackingUrlProvider(Account $account)
    {
        $key = sprintf('%s_%s', self::TRACKING_URL_PROVIDER, $account->getAlias());
        if (! $this->api->containsKey($key)) {
            $this->checkTrackingAccount();
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
     * @param Account $account
     * @return mixed
     */
    private function getAdeApi($api, Account $account)
    {
        $key = sprintf('%s_%s', $account->getAlias(), $api);
        if (! $this->api->containsKey($key)) {
            $this->api->set($key, $this->createAdeApi($api, $account));
        }

        return $this->api->get($key);
    }

    /**
     * @param string $api
     * @param Account $account
     * @return mixed
     */
    private function createAdeApi($api, Account $account)
    {
        $this->checkAdeAccount($account);
        $factoryMethod = sprintf('create%sApi', ucfirst(Inflector::camelize($api)));

        return call_user_func_array(
                $this->adeApiFactory,
                $factoryMethod,
                array($this->getAdeAuthApi(), $account->getAdeUsername(), $account->getAdePassword())
        );
    }

    /**
     * @return bool
     */
    private function checkAdeAccount()
    {
        if (! $this->account->getAdeUsername() || ! $this->account->getAdePassword()) {
            throw new \InvalidArgumentException(
                'GLS ADE account has not been configured properly: Missing username and/or password'
            );
        }

        return true;
    }

    /**
     * @return bool
     */
    private function checkTrackingAccount()
    {
        if (! $this->account->getAdeUsername() || ! $this->account->getAdePassword()) {
            throw new \InvalidArgumentException(
                'GLS Track & Trace account has not been configured properly: Missing username and/or password'
            );
        }

        return true;
    }
}
