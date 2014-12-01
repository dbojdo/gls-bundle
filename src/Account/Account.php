<?php
/**
 * Account.php
 *
 * @author dbojdo - Daniel Bojdo <daniel.bojdo@web-it.eu>
 * Created on Dec 01, 2014, 13:04
 */
namespace Webit\Bundle\GlsBundle\Account;

/**
 * Class Account
 * @package Webit\Bundle\GlsBundle\Account
 */
class Account
{
    /**
     * @var string
     */
    private $alias;

    /**
     * @var string
     */
    private $adeUsername;

    /**
     * @var string
     */
    private $adePassword;

    /**
     * @var bool
     */
    private $adeTestMode;

    /**
     * @var string
     */
    private $trackUsername;

    /**
     * @var string
     */
    private $trackPassword;

    function __construct($alias, $adeUsername, $adePassword, $adeTestMode, $trackUsername, $trackPassword)
    {
        $this->alias = $alias;
        $this->adeUsername = $adeUsername;
        $this->adePassword = $adePassword;
        $this->adeTestMode = (bool) $adeTestMode;
        $this->trackUsername = $trackUsername;
        $this->trackPassword = $trackPassword;
        if (empty($this->adeUsername) && empty($this->trackUsername)) {
            throw new \InvalidArgumentException('You have to pass at least one of credentials ("ADE" or "Track & Trace")');
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
    public function getAdePassword()
    {
        return $this->adePassword;
    }

    /**
     * @return boolean
     */
    public function isAdeTestMode()
    {
        return $this->adeTestMode;
    }

    /**
     * @return string
     */
    public function getAdeUsername()
    {
        return $this->adeUsername;
    }

    /**
     * @return string
     */
    public function getTrackPassword()
    {
        return $this->trackPassword;
    }

    /**
     * @return string
     */
    public function getTrackUsername()
    {
        return $this->trackUsername;
    }
}
