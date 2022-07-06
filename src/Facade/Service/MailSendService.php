<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Facade\Service;

use Vin\ShopwareSdk\Data\Context;
use Vin\ShopwareSdk\Data\Mail\Mail;
use Vin\ShopwareSdk\Service\ApiResponse;
use Vin\ShopwareSdk\Service\MailSendService as SdkMailSendService;

final class MailSendService implements MailSendServiceInterface
{
    public function __construct(private SdkMailSendService $mailSendService)
    {
    }

    public function send(Mail $mail, Context $context): ApiResponse
    {
        $this->mailSendService->setContext($context);

        return $this->mailSendService->send($mail);
    }

    public function build(
        string $content,
        array $templateData,
        Context $context
    ): ApiResponse {
        $this->mailSendService->setContext($context);

        return $this->mailSendService->build($content, $templateData);
    }
}
