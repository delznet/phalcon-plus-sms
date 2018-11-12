<?php

declare(strict_types = 1);

namespace Delz\PhalconPlus\Component\SMS;

use Delz\PhalconPlus\Exception\InternalServerErrorException;

/**
 * 不支持的短信服务异常
 *
 * @package Delz\PhalconPlus\Component\SMS
 */
class UnsupportedSmsProviderException extends InternalServerErrorException
{
    public function __construct($providerName)
    {
        parent::__construct(
            sprintf('Unsupported sms provider: %s', $providerName)
        );
    }
}