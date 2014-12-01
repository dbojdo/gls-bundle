<?php
/**
 * ApiProviderFactoryInterface.php
 *
 * @author dbojdo - Daniel Bojdo <daniel.bojdo@web-it.eu>
 * Created on Dec 01, 2014, 13:17
 */
namespace Webit\Bundle\GlsBundle\Api;

use Webit\Bundle\GlsBundle\Account\Account;

/**
 * Interface ApiProviderFactoryInterface
 * @package Webit\Bundle\GlsBundle\Api
 */
interface ApiProviderFactoryInterface
{
    /**
     * @param Account $account
     * @return mixed
     */
    public function createApiProvider(Account $account);
}
 