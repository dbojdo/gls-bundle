<?php
/**
 * ApiProviderTest.php
 *
 * @author dbojdo - Daniel Bojdo <daniel.bojdo@web-it.eu>
 * Created on Dec 04, 2014, 10:12
 */

namespace Webit\Bundle\GlsBundle\Tests\Api;

use Webit\GlsAde\Model\AdeAccount;
use Webit\GlsTracking\Model\UserCredentials;
use Webit\Bundle\GlsBundle\Api\ApiProvider;
use Webit\GlsAde\Api\AuthApi;
use Webit\GlsAde\Api\ConsignmentPrepareApi;
use Webit\GlsAde\Api\Factory\ApiFactory;
use Webit\GlsAde\Api\MpkApi;
use Webit\GlsAde\Api\PickupApi;
use Webit\GlsAde\Api\PostCodeApi;
use Webit\GlsAde\Api\ProfileApi;
use Webit\GlsAde\Api\SenderAddressApi;
use Webit\GlsAde\Api\ServiceApi;
use Webit\GlsTracking\Api\Factory\TrackingApiFactory;
use Webit\GlsTracking\Api\TrackingApi;
use Webit\GlsTracking\UrlProvider\TrackingUrlProviderFactory;

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
     * @var TrackingUrlProviderFactory
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
    public function shouldProvideAdeAuthApi()
    {
        $account = $this->createAdeAccount('alias', 'username', 'password');
        $this->adeApiFactory->expects($this->once())
                            ->method('createAuthApi')
                            ->with($this->equalTo($account->isTestMode()))
                            ->willReturn($this->adeAuthApi);



        $api1 = $this->apiProvider->getAdeAuthApi($account);
        $this->assertInstanceOf('Webit\GlsAde\Api\AuthApi', $api1);

        $api2 = $this->apiProvider->getAdeAuthApi($account);
        $this->assertSame($api1, $api2);
    }

    /**
     * @test
     */
    public function shouldProvideAdeMpkApi()
    {
        $account = $this->createAdeAccount('username', 'password');
        $this->adeApiFactory->expects($this->any())
            ->method('createAuthApi')
            ->willReturn($this->adeAuthApi);

        $this->adeApiFactory->expects($this->once())
            ->method('createMpkApi')
            ->with($this->equalTo($this->adeAuthApi), $this->equalTo($account))
            ->willReturn($this->createAdeMpkApi());

        $api1 = $this->apiProvider->getAdeMpkApi($account);
        $this->assertInstanceOf('Webit\GlsAde\Api\MpkApi', $api1);

        $api2 = $this->apiProvider->getAdeMpkApi($account);
        $this->assertSame($api1, $api2);
    }


    /**
     * @test
     */
    public function shouldProvideAdeConsignmentPrepareApi()
    {
        $account = $this->createAdeAccount('username', 'password');
        $this->adeApiFactory->expects($this->any())
            ->method('createAuthApi')
            ->willReturn($this->adeAuthApi);

        $this->adeApiFactory->expects($this->once())
            ->method('createConsignmentPrepareApi')
            ->with($this->equalTo($this->adeAuthApi), $this->equalTo($account))
            ->willReturn($this->createAdeConsignmentPrepareApi());

        $api1 = $this->apiProvider->getAdeConsignmentPrepareApi($account);
        $this->assertInstanceOf('Webit\GlsAde\Api\ConsignmentPrepareApi', $api1);

        $api2 = $this->apiProvider->getAdeConsignmentPrepareApi($account);
        $this->assertSame($api1, $api2);
    }

    /**
     * @test
     */
    public function shouldProvideAdeProfileApi()
    {
        $account = $this->createAdeAccount('username', 'password');
        $this->adeApiFactory->expects($this->any())
            ->method('createAuthApi')
            ->willReturn($this->adeAuthApi);

        $this->adeApiFactory->expects($this->once())
            ->method('createProfileApi')
            ->with($this->equalTo($this->adeAuthApi), $this->equalTo($account))
            ->willReturn($this->createAdeProfileApi());

        $api1 = $this->apiProvider->getAdeProfileApi($account);
        $this->assertInstanceOf('Webit\GlsAde\Api\ProfileApi', $api1);

        $api2 = $this->apiProvider->getAdeProfileApi($account);
        $this->assertSame($api1, $api2);
    }

    /**
     * @test
     */
    public function shouldProvideAdeServiceApi()
    {
        $account = $this->createAdeAccount('username', 'password');
        $this->adeApiFactory->expects($this->any())
            ->method('createAuthApi')
            ->willReturn($this->adeAuthApi);

        $this->adeApiFactory->expects($this->once())
            ->method('createServiceApi')
            ->with($this->equalTo($this->adeAuthApi), $this->equalTo($account))
            ->willReturn($this->createAdeServiceApi());

        $api1 = $this->apiProvider->getAdeServiceApi($account);
        $this->assertInstanceOf('Webit\GlsAde\Api\ServiceApi', $api1);

        $api2 = $this->apiProvider->getAdeServiceApi($account);
        $this->assertSame($api1, $api2);
    }

    /**
     * @test
     */
    public function shouldProvideAdeSenderAddressApi()
    {
        $account = $this->createAdeAccount('username', 'password');
        $this->adeApiFactory->expects($this->any())
            ->method('createAuthApi')
            ->willReturn($this->adeAuthApi);

        $this->adeApiFactory->expects($this->once())
            ->method('createSenderAddressApi')
            ->with($this->equalTo($this->adeAuthApi), $this->equalTo($account))
            ->willReturn($this->createAdeSenderAddressApi());

        $api1 = $this->apiProvider->getAdeSenderAddressApi($account);
        $this->assertInstanceOf('Webit\GlsAde\Api\SenderAddressApi', $api1);

        $api2 = $this->apiProvider->getAdeSenderAddressApi($account);
        $this->assertSame($api1, $api2);
    }

    /**
     * @test
     */
    public function shouldProvideAdePickupApi()
    {
        $account = $this->createAdeAccount('username', 'password');
        $this->adeApiFactory->expects($this->any())
            ->method('createAuthApi')
            ->willReturn($this->adeAuthApi);

        $this->adeApiFactory->expects($this->once())
            ->method('createPickupApi')
            ->with($this->equalTo($this->adeAuthApi), $this->equalTo($account))
            ->willReturn($this->createAdePickupApi());

        $api1 = $this->apiProvider->getAdePickupApi($account);
        $this->assertInstanceOf('Webit\GlsAde\Api\PickupApi', $api1);

        $api2 = $this->apiProvider->getAdePickupApi($account);
        $this->assertSame($api1, $api2);
    }

    /**
     * @test
     */
    public function shouldProvideAdePostCodeApi()
    {
        $account = $this->createAdeAccount('username', 'password');
        $this->adeApiFactory->expects($this->any())
            ->method('createAuthApi')
            ->willReturn($this->adeAuthApi);

        $this->adeApiFactory->expects($this->once())
            ->method('createPostCodeApi')
            ->with($this->equalTo($this->adeAuthApi), $this->equalTo($account))
            ->willReturn($this->createAdePostCodeApi());

        $api1 = $this->apiProvider->getAdePostCodeApi($account);
        $this->assertInstanceOf('Webit\GlsAde\Api\PostCodeApi', $api1);

        $api2 = $this->apiProvider->getAdePostCodeApi($account);
        $this->assertSame($api1, $api2);
    }

    /**
     * @test
     */
    public function shouldProvideTrackingApi()
    {
        $account = $this->createTrackingAccount('username', 'password');

        $this->trackingApiFactory->expects($this->once())
                                ->method('createTrackingApi')
                                ->with($this->equalTo($account))
                                ->willReturn($this->createTrackingApi());

        $api1 = $this->apiProvider->getTrackingApi($account);
        $this->assertInstanceOf('Webit\GlsTracking\Api\TrackingApi', $api1);

        $api2 = $this->apiProvider->getTrackingApi($account);
        $this->assertSame($api1, $api2);
    }

    /**
     * @test
     */
    public function shouldProvideTrackingUrlProvider()
    {
        $account = $this->createTrackingAccount('username', 'password');

        $this->trackingUrlProviderFactory->expects($this->once())
            ->method('createTrackingUrlProvider')
            ->willReturn($this->createTrackingUrlProvider());

        $provider1 = $this->apiProvider->getTrackingUrlProvider($account);
        $this->assertInstanceOf('Webit\GlsTracking\UrlProvider\TrackingUrlProvider', $provider1);

        $provider2 = $this->apiProvider->getTrackingUrlProvider($account);
        $this->assertSame($provider1, $provider2);
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
     * @return \PHPUnit_Framework_MockObject_MockObject|TrackingUrlProviderFactory
     */
    private function createTrackingUrlProviderFactory()
    {
        return $this->getMockBuilder('Webit\GlsTracking\UrlProvider\TrackingUrlProviderFactory')
            ->disableOriginalConstructor()->getMock();
    }

    /**
     * @param $username
     * @param $password
     * @param bool $test
     * @return \PHPUnit_Framework_MockObject_MockObject|AdeAccount
     */
    private function createAdeAccount($username, $password, $test = false)
    {
        $account = $this->getMockBuilder('Webit\GlsAde\Model\AdeAccount')
                        ->disableOriginalConstructor()->getMock();

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

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|MpkApi
     */
    private function createAdeMpkApi()
    {
        return $this->getMockBuilder('Webit\GlsAde\Api\MpkApi')->disableOriginalConstructor()->getMock();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|ConsignmentPrepareApi
     */
    private function createAdeConsignmentPrepareApi()
    {
        return $this->getMockBuilder('Webit\GlsAde\Api\ConsignmentPrepareApi')->disableOriginalConstructor()->getMock();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|ProfileApi
     */
    private function createAdeProfileApi()
    {
        return $this->getMockBuilder('Webit\GlsAde\Api\ProfileApi')->disableOriginalConstructor()->getMock();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|ServiceApi
     */
    private function createAdeServiceApi()
    {
        return $this->getMockBuilder('Webit\GlsAde\Api\ServiceApi')->disableOriginalConstructor()->getMock();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|SenderAddressApi
     */
    private function createAdeSenderAddressApi()
    {
        return $this->getMockBuilder('Webit\GlsAde\Api\SenderAddressApi')->disableOriginalConstructor()->getMock();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|PickupApi
     */
    private function createAdePickupApi()
    {
        return $this->getMockBuilder('Webit\GlsAde\Api\PickupApi')->disableOriginalConstructor()->getMock();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|PostCodeApi
     */
    private function createAdePostCodeApi()
    {
        return $this->getMockBuilder('Webit\GlsAde\Api\PostCodeApi')->disableOriginalConstructor()->getMock();
    }

    /**
     * @param $username
     * @param $password
     * @return \PHPUnit_Framework_MockObject_MockObject|UserCredentials
     */
    private function createTrackingAccount($username, $password)
    {
        $account = $this->getMockBuilder('Webit\GlsTracking\Model\UserCredentials')
            ->disableOriginalConstructor()->getMock();

        $account->expects($this->any())->method('getUsername')->willReturn($username);
        $account->expects($this->any())->method('getPassword')->willReturn($password);

        return $account;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|TrackingApi
     */
    private function createTrackingApi()
    {
        return $this->getMockBuilder('Webit\GlsTracking\Api\TrackingApi')->disableOriginalConstructor()->getMock();
    }

    private function createTrackingUrlProvider()
    {
        return $this->getMockBuilder('Webit\GlsTracking\UrlProvider\TrackingUrlProvider')->disableOriginalConstructor()->getMock();
    }
}
