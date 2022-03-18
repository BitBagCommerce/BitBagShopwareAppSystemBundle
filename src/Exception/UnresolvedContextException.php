<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Exception;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

final class UnresolvedContextException extends BadRequestHttpException
{
}
