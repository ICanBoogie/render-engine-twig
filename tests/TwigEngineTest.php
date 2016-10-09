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

class TwigEngineTest extends \PHPUnit_Framework_TestCase
{
	public function test_render()
	{
		$template_pathname = '/path/to/template.twig';
		$variables = [ uniqid() => uniqid() ];
		$expected = uniqid();

		$template = $this->mock_template(function ($template) use ($template_pathname, $variables, $expected) {

			$template->render([

				TwigEngine::VAR_THIS => $this,
				TwigEngine::VAR_TEMPLATE_PATHNAME => $template_pathname,

			] + $variables)->shouldBeCalled()->willReturn($expected);

		});

		$twig = $this->mock_twig(function ($twig) use ($template_pathname, $template) {

			$twig->loadTemplate($template_pathname)
				->shouldBeCalled()->willReturn($template);

		});

		$engine = new TwigEngine($twig);
		$this->assertSame($expected, $engine->render($template_pathname, $this, $variables));
	}

	/**
	 * @param callable $init
	 *
	 * @return \Twig_Environment
	 */
	private function mock_twig(callable $init)
	{
		$twig = $this->prophesize(\Twig_Environment::class);

		$init($twig);

		return $twig->reveal();
	}

	/**
	 * @param callable $init
	 *
	 * @return \Twig_Template
	 */
	private function mock_template(callable $init)
	{
		$template = $this->prophesize(\Twig_Template::class);

		$init($template);

		return $template->reveal();
	}
}
