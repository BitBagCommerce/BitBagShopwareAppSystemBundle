<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Exception;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

final class UnresolvedRequestDataException extends BadRequestHttpException
{
    public function __construct(string $valueName)
    {
        parent::__construct(\sprintf(
            'Request does not contain required value: %s',
            $valueName
        ));
    }
}
