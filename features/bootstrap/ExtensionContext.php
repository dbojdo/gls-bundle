<?php
namespace Webit\Bundle\GlsBundle\Features;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Symfony\Component\Debug\Debug;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use PHPUnit_Framework_Assert as Assert;
use Symfony\Component\Yaml\Yaml;
use Webit\Bundle\GlsBundle\Account\AccountManagerInterface;
use Webit\Bundle\GlsBundle\Features\App\AppKernel;

/**
 * Defines application features from the specific context.
 */
class ExtensionContext implements Context, SnippetAcceptingContext
{
    /**
     * @var AppKernel
     */
    private $app;

    /**
     * @BeforeScenario
     */
    public function createApp()
    {
        $this->app = new AppKernel('test', true);
    }

    /**
     * @return \Symfony\Component\DependencyInjection\ContainerInterface
     */
    private function getContainer()
    {
        $this->app->boot();
        return $this->app->getContainer();
    }

    /**
     * @When application config contains:
     * @param PyStringNode $string
     * @throws PendingException
     */
    public function applicationConfigContains(PyStringNode $string)
    {
        $this->app->mergeConfig($string->getRaw());
    }

    /**
     * @When application is up
     */
    public function applicationIsUp()
    {
        $this->app->boot();
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
}
