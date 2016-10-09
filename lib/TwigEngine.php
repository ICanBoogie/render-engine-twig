<?php

/*
 * This file is part of the ICanBoogie package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ICanBoogie\RenderEngineTwig;

use ICanBoogie\Render\Engine;

/**
 * Renders a template using Twig.
 */
class TwigEngine implements Engine
{
	const VAR_THIS = '_this';

	/**
	 * @var \Twig_Environment
	 */
	private $twig;

	/**
	 * @param \Twig_Environment $twig
	 */
	public function __construct(\Twig_Environment $twig)
	{
		$this->twig = $twig;
	}

	/**
	 * @inheritdoc
	 */
	public function render($template_pathname, $thisArg, array $variables, array $options = [])
	{
		return $this->load_template($template_pathname)->render([

			self::VAR_THIS => $thisArg,
			self::VAR_TEMPLATE_PATHNAME => $template_pathname,

		] + $variables);
	}

	/**
	 * @param string $template_pathname
	 *
	 * @return \Twig_TemplateInterface
	 */
	private function load_template($template_pathname)
	{
		return $this->twig->loadTemplate($template_pathname);
	}
}
