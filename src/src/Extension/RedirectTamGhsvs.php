<?php
namespace GHSVS\Plugin\System\RedirectTamGhsvs\Extension;

\defined('_JEXEC') or die;

use Joomla\CMS\Router\Route;
use Joomla\Component\Content\Site\Helper\RouteHelper;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\Database\DatabaseAwareTrait;
use Joomla\Database\ParameterType;
use Joomla\Event\SubscriberInterface;
use Joomla\CMS\Event\ErrorEvent;

final class RedirectTamGhsvs extends CMSPlugin implements SubscriberInterface
{
	use DatabaseAwareTrait;

	/**
		* Returns an array of events this subscriber will listen to
		*
		* @return  array
		*
		* @since   4.0.0
		*/
	public static function getSubscribedEvents(): array
	{
			return ['onError' => 'handleLinkError'];
	}

	public function handleLinkError(ErrorEvent $event)
	{
		/** @var \Joomla\CMS\Application\CMSApplication $app */
		$app = $event->getApplication();

		if (!$app->isClient('site') || ((int) $event->getError()->getCode() !== 404))
		{
			return;
		}

		$uri = Uri::getInstance();
		$articleId = trim($uri->getPath(), '/');

		// Only 1 number? $articleId is a string yet!
		if ($articleId && is_numeric($articleId) && (int) $articleId == $articleId)
		{
			$articleId = (int) $articleId;
		}
		else
		{
			return;
		}

		$query = $this->getDatabase()->getQuery(true);
		$query->select($this->getDatabase()->quoteName(['id', 'alias', 'language', 'catid']))
		->from($this->getDatabase()->quoteName('#__content'))
		->where($this->getDatabase()->quoteName('id') . ' = :id')
		->bind(':id', $articleId, ParameterType::INTEGER);
		$this->getDatabase()->setQuery($query);

		try {
			$article = $this->getDatabase()->loadObject();
		} catch (\Exception $e) {
			return;
		}

		if (empty($article))
		{
			return;
		}

		$destination = Route::_(
			RouteHelper::getArticleRoute(
				$article->id,
				$article->catid,
				$article->language
			)
		);

		$app->redirect($destination, 301);
		return;
	}
}
