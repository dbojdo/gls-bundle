<?php
/**
 * ApiFactory.php
 *
 * @author dbojdo - Daniel Bojdo <daniel.bojdo@web-it.eu>
 * Created on Dec 01, 2014, 13:17
 */
namespace Webit\Bundle\GlsBundle\Api;

use Webit\Bundle\GlsBundle\Account\Account;
use Webit\GlsAde\Api\AuthApi;
use Webit\GlsAde\Api\Factory\ApiFactory;
use Webit\GlsTracking\Api\Factory\TrackingApiFactory;

/**
 * Class ApiFactory
 * @package Webit\Bundle\GlsBundle\Api
 */
class ApiProviderFactory
{
    /**
     * @var AuthApi
     */
    private $adeAuthApi;

    /**
     * @var ApiFactory
     */
    private $adeApiFactory;

    /**
     * @var TrackingApiFactory
     */
    private $trackingApiFactory;

    /**
     * @param Account $account
     * @return ApiProvider
     */
    public function createApiProvider(Account $account)
    {
        return new ApiProvider($account, $this->adeAuthApi, $this->adeApiFactory, $this->trackingApiFactory);
    }
}
