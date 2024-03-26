<?php
namespace GHSVS\Plugin\System\RedirectTamGhsvs\Field;

\defined('_JEXEC') or die;

use Joomla\CMS\Form\FormField;
use Exception;

class VersionField extends FormField
{
	protected $type = 'Version';

	protected function getInput()
	{
		$version = (string) $this->element['extensionVersion'];
		return $version;
	}
}
