<?php

namespace Schroedt\ContaoServerBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\PhpExecutableFinder;


class ServerCommand extends ContainerAwareCommand
{
	/**
	 * @var string
	 */
	private $rootDir;

	/**
	 * @var string
	 */
	private $webDir;

	/**
	 * @var string
	 */
	private $script;

	/**
	 * Constructor
	 *
	 * @param string $rootDir
	 * @param string $webDir
	 */
	public function __construct($rootDir, $webDir)
	{
		$this->rootDir = $rootDir;
		$this->webDir = $webDir;
		$this->script = realpath(__DIR__ . '/../Resources/script/server.php');

		parent::__construct();
	}

	/**
	 * {@inheritdoc}
	 */
	protected function configure()
	{
		$this
			->setName('serve')
			->setDefinition([
				new InputOption('host', null, InputOption::VALUE_OPTIONAL, 'Host', '127.0.0.1'),
				new InputOption('port', null, InputOption::VALUE_OPTIONAL, 'Port', '8000'),
			])
			->setDescription('Starts a development server')
		;
	}

	/**
	 * {@inheritdoc}
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$output->writeln(sprintf('<info>Contao development server started:</info> <http://%s:%s>',
			$input->getOption('host'),
			$input->getOption('port')
		));

		passthru(sprintf('%s -S %s:%s -t %s %s',
			(new PhpExecutableFinder)->find(false),
			$input->getOption('host'),
			$input->getOption('port'),
			$this->webDir,
			$this->script
		), $status);

		return $status;
	}
}
