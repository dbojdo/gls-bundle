<?php
/**
 * ApiProviderTest.php
 *
 * @author dbojdo - Daniel Bojdo <daniel.bojdo@dxi.eu>
 * Created on Dec 04, 2014, 10:12
 * Copyright (C) DXI Ltd
 */

namespace Webit\Bundle\GlsBundle\Tests\Api;

use Webit\Bundle\GlsBundle\Account\AdeAccount;
use Webit\Bundle\GlsBundle\Api\ApiProvider;
use Webit\GlsAde\Api\AuthApi;
use Webit\GlsAde\Api\Factory\ApiFactory;
use Webit\GlsTracking\Api\Factory\TrackingApiFactory;
use Webit\GlsTracking\UrlProvider\TrackingUrlProviderFactoryInterface;

/**
 * Class ApiProviderTest
 * @package Webit\Bundle\GlsBundle\Tests\Api
 */
class ApiProviderTest extends \PHPUnit_Framework_TestCase
{
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
     * @var ApiProvider
     */
    private $apiProvider;

    /**
     * @var AuthApi
     */
    private $adeAuthApi;

    public function setUp()
    {
        $this->adeApiFactory = $this->createAdeApiFactory();
        $this->trackingApiFactory = $this->createTrackingApiFactory();
        $this->trackingUrlProviderFactory = $this->createTrackingUrlProviderFactory();
        $this->adeAuthApi = $this->createAdeAuthApi();

        $this->apiProvider = new ApiProvider(
            $this->adeApiFactory,
            $this->trackingApiFactory,
            $this->trackingUrlProviderFactory
        );
    }

    /**
     * @test
     */
    public function shouldReturnAdeAuthApi()
    {
        $account = $this->createAdeAccount('alias', 'username', 'password');
        $this->adeApiFactory->expects($this->once())
                            ->method('createAuthApi')
                            ->with($this->equalTo($account->isTestEnvironment()))
                            ->willReturn($this->adeAuthApi);

        $api1 = $this->apiProvider->getAdeAuthApi($account);
        $this->assertInstanceOf('Webit\GlsAde\Api\AuthApi', $api1);

        $api2 = $this->apiProvider->getAdeAuthApi($account);
        $this->assertSame($api1, $api2);
    }

    /**
     * @test
     */
    public function shouldReturnAdeMpkApi()
    {
        $account = $this->createAdeAccount('alias', 'username', 'password');
        $this->adeApiFactory->expects($this->once())
            ->method('createMpkApi')
            ->with($this->equalTo($account->isTestEnvironment()))
            ->willReturn($this->createAdeAuthApi());

        $api1 = $this->apiProvider->getAdeMpkApi($account);
        $this->assertInstanceOf('Webit\GlsAde\Api\MpkApi', $api1);

        $api2 = $this->apiProvider->getAdeMpkApi($account);
        $this->assertSame($api1, $api2);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|ApiFactory
     */
    private function createAdeApiFactory()
    {
        return $this->getMockBuilder('Webit\GlsAde\Api\Factory\ApiFactory')->disableOriginalConstructor()->getMock();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|TrackingApiFactory
     */
    private function createTrackingApiFactory()
    {
        return $this->getMockBuilder('Webit\GlsTracking\Api\Factory\TrackingApiFactory')
                    ->disableOriginalConstructor()->getMock();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|TrackingUrlProviderFactoryInterface
     */
    private function createTrackingUrlProviderFactory()
    {
        return $this->getMockBuilder('Webit\GlsTracking\UrlProvider\TrackingUrlProviderFactoryInterface')
            ->disableOriginalConstructor()->getMock();
    }

    /**
     * @param $alias
     * @param $username
     * @param $password
     * @param bool $test
     * @return \PHPUnit_Framework_MockObject_MockObject|AdeAccount
     */
    private function createAdeAccount($alias, $username, $password, $test = false)
    {
        $account = $this->getMockBuilder('Webit\Bundle\GlsBundle\Account\AdeAccount')
                        ->disableOriginalConstructor()->getMock();

        $account->expects($this->any())->method('getAlias')->willReturn($alias);
        $account->expects($this->any())->method('getUsername')->willReturn($username);
        $account->expects($this->any())->method('getPassword')->willReturn($password);
        $account->expects($this->any())->method('isTestEnvironment')->willReturn($test);

        return $account;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|AuthApi
     */
    private function createAdeAuthApi()
    {
        return $this->getMockBuilder('Webit\GlsAde\Api\AuthApi')->disableOriginalConstructor()->getMock();
    }
}
