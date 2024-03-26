<?php
\defined('_JEXEC') or die;

use Joomla\CMS\Extension\PluginInterface;
use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\Database\DatabaseInterface;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use Joomla\Event\DispatcherInterface;
use GHSVS\Plugin\System\RedirectTamGhsvs\Extension\RedirectTamGhsvs;

return new class () implements ServiceProviderInterface {
		/**
		 * Registers the service provider with a DI container.
		 *
		 * @param   Container  $container  The DI container.
		 *
		 * @return  void
		 *
		 * @since   4.4.0
		 */
		public function register(Container $container): void
		{
				$container->set(
						PluginInterface::class,
						function (Container $container) {
								$plugin     = new RedirectTamGhsvs(
										$container->get(DispatcherInterface::class),
										(array) PluginHelper::getPlugin('system', 'redirecttamghsvs')
								);
								$plugin->setApplication(Factory::getApplication());
								$plugin->setDatabase($container->get(DatabaseInterface::class));

								return $plugin;
						}
				);
		}
};
