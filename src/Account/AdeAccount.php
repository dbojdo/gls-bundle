<?php
/**
 * File: AdeAccount.php
 * Created at: 2014-12-02 04:22
 */
 
namespace Webit\Bundle\GlsBundle\Account;

/**
 * Class AdeAccount
 * @author Daniel Bojdo <daniel.bojdo@web-it.eu>
 */
class AdeAccount extends AbstractAccount
{
    /**
     * @var bool
     */
    private $testEnvironment = false;

    /**
     * @param string $alias
     * @param string $username
     * @param string $password
     * @param bool $testEnvironment
     */
    public function __construct($alias, $username, $password, $testEnvironment = false)
    {
        parent::__construct($alias, $username, $password);
        $this->testEnvironment = $testEnvironment;
    }

    /**
     * @return bool
     */
    public function isTestEnvironment()
    {
        return $this->testEnvironment;
    }
}
 