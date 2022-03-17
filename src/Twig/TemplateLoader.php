<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Twig;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

final class TemplateLoader extends Environment
{
    public function __construct()
    {
        $loader = new FilesystemLoader(__DIR__ . '/../Resources/views');

        parent::__construct($loader);
    }
}
