<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Facade\Service;

use Vin\ShopwareSdk\Data\Context;
use Vin\ShopwareSdk\Data\Mail\Mail;
use Vin\ShopwareSdk\Service\ApiResponse;

interface MailSendServiceInterface
{
    public function send(Mail $mail, Context $context): ApiResponse;

    public function build(
        string $content,
        array $templateData,
        Context $context
    ): ApiResponse;
}
