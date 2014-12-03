<?php
/**
 * FeatureContext.php
 *
 * @author dbojdo - Daniel Bojdo <daniel.bojdo@dxi.eu>
 * Created on Dec 03, 2014, 12:13
 * Copyright (C) DXI Ltd
 */

namespace Webit\Bundle\GlsBundle\Features\Context;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use PHPUnit_Framework_Assert as Assert;
use Symfony\Component\HttpKernel\KernelInterface;
use Webit\Bundle\GlsBundle\Account\AccountManagerInterface;

/**
 * Class FeatureContext
 * @package Webit\Bundle\GlsBundle\Features\Context
 */
class FeatureContext implements Context, SnippetAcceptingContext, KernelAwareContext
{
    /**
     * @var AppKernel
     */
    private $kernel;

    /**
     * @return \Symfony\Component\DependencyInjection\ContainerInterface
     */
    private function getContainer()
    {
        $this->kernel->boot();
        return $this->kernel->getContainer();
    }

    /**
     * @When application config contains:
     * @param PyStringNode $string
     * @throws PendingException
     */
    public function applicationConfigContains(PyStringNode $string)
    {
        $this->kernel = clone($this->kernel);
        $this->kernel->mergeConfig($string->getRaw());
    }

    /**
     * @When application is up
     */
    public function applicationIsUp()
    {
        $this->kernel->boot();
    }

    /**
     * @Then There should be following services in container:
     * @param PyStringNode $string
     */
    public function thereShouldBeFollowingServicesInContainer(PyStringNode $string)
    {
        foreach ($string->getStrings() as $line) {
            $arServices = explode(',', $line);
            foreach ($arServices as $serviceName) {
                $serviceName = trim($serviceName);
                if (empty($serviceName)) {continue;}
                Assert::assertTrue(
                    $this->getContainer()->has($serviceName),
                    sprintf('Required service "%s" has not been registered in Container', $serviceName)
                );

                $this->getContainer()->get($serviceName);
            }
        }
    }

    /**
     * @Then there should be following Accounts in AccountManager:
     * @param TableNode $table
     */
    public function thereShouldBeFollowingAccountsInAccountManager(TableNode $table)
    {
        /** @var AccountManagerInterface $accountManager */
        $accountManager = $this->getContainer()->get('webit_gls.account_manager');
        foreach ($table as $row) {
            if ($row['type'] == 'ade') {
                $account = $accountManager->getAdeAccount($row['alias']);
                Assert::assertNotEmpty($account, sprintf('Expected account with alias "%s" has not been registered', $row['alias']));
                Assert::assertEquals($row['username'], $account->getUsername());
                Assert::assertEquals($row['password'], $account->getPassword());
                Assert::assertEquals($row['test'] == 'true', $account->isTestEnvironment());
            }

            if ($row['type'] == 'track') {
                $account = $accountManager->getTrackAccount($row['alias']);
                Assert::assertNotEmpty($account, sprintf('Expected account with alias "%s" has not been registered', $row['alias']));
                Assert::assertEquals($row['username'], $account->getUsername());
                Assert::assertEquals($row['password'], $account->getPassword());
            }
        }
    }

    /**
     * Sets Kernel instance.
     *
     * @param KernelInterface $kernel
     */
    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }
}
