<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ClearCachedRoutesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:clear-cached-routes')
            ->setDescription('Clears route cache files.')
            ->setHelp('This command allows you to remove symfony 3 app route cacheds for different environments');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Clearing routes cache files');

        $router = $this->getContainer()->get('router');
        $filesystem = $this->getContainer()->get('filesystem');
        $kernel = $this->getContainer()->get('kernel');
        $cacheDir = $kernel->getCacheDir();

        foreach (array('matcher_cache_class', 'generator_cache_class') as $option) {
            $className = $router->getOption($option);
            $cacheFile = $cacheDir . DIRECTORY_SEPARATOR . $className . '.php';
            $filesystem->remove($cacheFile);
        }

        $output->writeln('OK');
    }
}
