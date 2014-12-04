[![Build Status](https://api.travis-ci.org/dbojdo/gls-bundle.png?branch=master)](https://travis-ci.org/dbojdo/gls-bundle)

# WebitGlsBundle

GLS ADE and GLS Track &amp; Trace API Symfony 2 integration

## Installation
### via Composer

Add the **webit/gls-bundle** into **composer.json**

```json
{
    "require": {
        "php":              ">=5.3.2",
        "webit/gls-bundle": "dev-master"
    },
    "autoload": {
        "psr-0": {
            "Acme": "src/"
        }
    }
}
```

### Register bundle in Kernel
Add following line:

```
// in AppKernel::registerBundles()
$bundles = array(
    // ...
    new Webit\Bundle\GlsBundle\WebitGlsBundle(),
    // ...
);
```

## Configuration
You can define as much accounts as you need (ADE Accounts and Track & Trace as well)

```
webit_gls:
   ade_accounts:
       my-production-account:
           username: my-ade-username
           password: my-ade-password
           test_mode: false
       my-test-account:
           username: my-ade-test-username
           password: my-ade-test-password
           test_mode: true
      track_accounts:
          my-account:
              username: my-track-and-trace-username
              password: my-track-and-trace-password
              test_mode: false
```

## Usage
To use GLS APIs you need ***AccountManager*** and ***ApiProvider***.
You can get them directly from Service Container or inject them to your class.

```
<?php
namespace Acme\Bundle\AcmeBundle\Controller;
 
use Webit\Bundle\GlsBundle\Api\ApiProviderInterface;
use Webit\Bundle\GlsBundle\Account\AccountManagerInterface;
 
class MyController {
 
    /**
     * @var AccountManagerInterface
     */
    private $accountManager;
    
    /**
     * @var ApiProviderInterface
     */
    private $apiProvider;
    
    public function __construct(AccountManagerInterface $accountManager, ApiProviderInterface $apiProvider)
    {
        $this->accountManager = $accountManager;
        $this->apiProvider = $apiProvider;
    }
    
    public function consignmentPrepareAction()
    {
        /** @var \Webit\Bundle\GlsBundle\Account\AdeAccount */
        $account = $this->accountManager->getAdeAccount('my-test-account');
        
        /** @var \Webit\GlsAde\Api\ConsignmentPrepareApi */
        $consignmentPrepareApi = $this->apiProvider->getConsignmentPrepareApi($account);
        
        // do your stuff with API
    }
    
    public function checkParcelStatusAction()
        {
            /** @var \Webit\Bundle\GlsBundle\Account\TrackAccount */
            $account = $this->accountManager->getTrackAccount('my-account');
            
            /** @var \Webit\GlsTracking\Api\TrackingApi */
            $trackingApi = $this->apiProvider->getTrackingApi($account);
            
            // do your stuff with API
        }
}
```
 
To learn how to use GLS APIs see:
*   GLS-ADE: [https://github.com/dbojdo/gls-ade](https://github.com/dbojdo/gls-ade "GLS-ADE API library")
*   GLS Track & Trace: [https://github.com/dbojdo/gls-tracking](https://github.com/dbojdo/gls-tracking "GLS Track & Trace API library")
 