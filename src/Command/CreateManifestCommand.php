<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Command;

use BitBag\ShopwareAppSystemBundle\Twig\TemplateLoader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class CreateManifestCommand extends Command
{
    protected static $defaultName = 'app-system:create-manifest';

    /** @var array<string, string> */
    private static array $consoleArguments = [
        'Label' => 'BitBag Shopware app',
        'Description' => 'BitBag Shopware app',
        'Author' => 'BitBag',
        'Copyright' => '(c) by BitBag',
        'Version' => '1.0.0',
        'License' => 'MIT',
    ];

    public function __construct(
        private TemplateLoader $twig,
        private string $appName,
        private string $appSecret,
        private string $appUrlBackend,
        private string $appUrlClient
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Creates a manifest.xml for the current setup.')
            ->addOption(
                'destination',
                'd',
                InputOption::VALUE_OPTIONAL,
                'Define the destination for the manifest.xml.'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $destinationOption = $input->getOption('destination');
        $destinationOption = $destinationOption ?: 'build/dev/manifest.xml';
        $destination = $this->getDestinationPath($destinationOption);

        if (\file_exists($destination)) {
            if (!$io->confirm(
                \sprintf('File "%s" already exists. Do you want to override the existing file?', $destination),
                false
            )) {
                return 0;
            }
        }

        $envArguments = $this->getEnvArguments();
        $consoleArguments = $this->getConsoleArguments($io);
        $arguments = \array_merge($envArguments, $consoleArguments);

        $manifest = $this->twig->render('manifest-template.xml.twig', $arguments);

        if (!file_put_contents($destination, $manifest)) {
            $io->error(\sprintf('Unable to write "%s".', $destination));

            return 1;
        }

        return 0;
    }

    private function getDestinationPath(string $input): string
    {
        $pathInfo = \pathinfo($input);
        $this->createDestinationDir($pathInfo);

        if (\array_key_exists('extension', $pathInfo)) {
            return \sprintf(
                '%s%s%s',
                $pathInfo['dirname'],
                \DIRECTORY_SEPARATOR,
                $pathInfo['basename']
            );
        }

        return \sprintf(
            '%s%s%s%s%s',
            $pathInfo['dirname'],
            \DIRECTORY_SEPARATOR,
            $pathInfo['basename'],
            \DIRECTORY_SEPARATOR,
            'manifest.xml'
        );
    }

    /**
     * @param array<string, string> $pathInfo
     */
    private function createDestinationDir(array $pathInfo): void
    {
        if ((\array_key_exists('extension', $pathInfo) && \is_dir($pathInfo['dirname'])) || (!\array_key_exists('extension', $pathInfo) && \is_dir($pathInfo['dirname'] . \DIRECTORY_SEPARATOR . $pathInfo['filename']))) {
            return;
        }

        if (\array_key_exists('extension', $pathInfo)) {
            \mkdir($pathInfo['dirname'], 0777, true);
        } else {
            $pathName = \sprintf(
                '%s%s%s',
                $pathInfo['dirname'],
                \DIRECTORY_SEPARATOR,
                $pathInfo['filename']
            );

            \mkdir($pathName, 0777, true);
        }
    }

    private function getEnvArguments(): array
    {
        return [
            'APP_NAME' => $this->appName,
            'APP_SECRET' => $this->appSecret,
            'APP_URL_CLIENT' => $this->appUrlClient,
            'APP_URL_BACKEND' => $this->appUrlBackend,
        ];
    }

    private function getConsoleArguments(SymfonyStyle $io): array
    {
        $consoleArguments = [];

        foreach (self::$consoleArguments as $questionLabel => $defaultValue) {
            /** @var string $answer */
            $answer = $io->ask($questionLabel, $defaultValue);

            $consoleArguments[\strtoupper($questionLabel)] = $answer;
        }

        return $consoleArguments;
    }
}
