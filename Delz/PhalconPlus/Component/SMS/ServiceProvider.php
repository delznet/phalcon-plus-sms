<?php

declare(strict_types=1);

namespace Delz\PhalconPlus\Component\SMS;

use Delz\PhalconPlus\ServiceProvider\Provider;
use Delz\PhalconPlus\Config\IConfig;
use Delz\SMS\Provider\Tong3;
use Delz\SMS\Provider\YunPian;
use Delz\SMS\Manager;

/**
 * 短信服务提供者
 *
 * @package Delz\PhalconPlus\Component\SMS
 */
class ServiceProvider extends Provider
{
    /**
     * 服务名称
     *
     * @var string
     */
    protected $serviceName = 'sms';

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $self = $this;
        $this->di->setShared(
            $this->serviceName,
            function () use ($self) {
                /** @var IConfig $config */
                $config = $self->di->getShared('config');
                $smsProvider = strtolower($config->get('sms.provider'));
                switch ($smsProvider) {
                    case 'tong3':
                        return $this->createTong3Service();
                    case 'yunpian':
                        return $this->createYunpianService();
                    default:
                        throw new UnsupportedSmsProviderException($smsProvider);
                }

            }
        );
    }

    /**
     * @return Manager
     */
    protected function createTong3Service()
    {
        /** @var IConfig $config */
        $config = $this->di->getShared('config');
        $account = $config->get('sms.tong3.account');
        $password = $config->get('sms.tong3.password');
        $sign= $config->get('sms.tong3.sign');
        $subCode= $config->get('sms.tong3.subcode');
        $tong3 = new Tong3($account, $password, $sign, $subCode);
        return new Manager($tong3);
    }

    /**
     * @return Manager
     */
    protected function createYunpianService()
    {
        /** @var IConfig $config */
        $config = $this->di->getShared('config');
        $apiKey = $config->get('sms.yunpian.apikey');
        $yunpian = new YunPian($apiKey);
        return new Manager($yunpian);
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return '短信服务';
    }
}