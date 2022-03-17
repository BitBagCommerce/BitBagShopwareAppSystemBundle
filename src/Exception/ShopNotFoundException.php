<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Exception;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class ShopNotFoundException extends NotFoundHttpException
{
    public function __construct(string $shopId)
    {
        parent::__construct(\sprintf(
            'Shop with shop id: %s not found.',
            $shopId
        ));
    }
}
