<?php
/**
 * AbstractAccount.php
 *
 * @author dbojdo - Daniel Bojdo <daniel.bojdo@web-it.eu>
 * Created on Dec 01, 2014, 13:04
 */
namespace Webit\Bundle\GlsBundle\Account;

/**
 * Class AbstractAccount
 * @package Webit\Bundle\GlsBundle\Account
 */
abstract class AbstractAccount
{
    /**
     * @var string
     */
    private $alias;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    function __construct($alias, $username, $password)
    {
        $this->alias = $alias;
        $this->username = $username;
        $this->password = $password;

        if (empty($this->alias)) {
            throw new \InvalidArgumentException('You have to pass non empty alias.');
        }

        if (empty($this->username)) {
            throw new \InvalidArgumentException('You have to pass non empty username.');
        }

        if (empty($this->password)) {
            throw new \InvalidArgumentException('You have to pass non empty password.');
        }
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
}
