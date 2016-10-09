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

use ICanBoogie\Render\BasicTemplateResolver;
use ICanBoogie\Render\EngineCollection;
use ICanBoogie\Render\Renderer;

class IntegrationTest extends \PHPUnit_Framework_TestCase
{
	public function test_integration()
	{
		$twig = $this->create_twig();

		$template_resolver = new BasicTemplateResolver([

			__DIR__ . '/templates'

		]);

		$renderer = new Renderer($template_resolver, new EngineCollection([

			'.twig' => new TwigEngine($twig)

		]));

		$result = $renderer->render($this, [

			Renderer::OPTION_TEMPLATE => 'page/testing',
			Renderer::OPTION_LOCALS => [

				'range' => range(1, 3)

			]

		]);

		$expected = <<<EOT
Test class: ICanBoogie\RenderEngineTwig\IntegrationTest
Range: 1 2 3 |

EOT;

		$this->assertSame($expected, $result);
	}

	private function create_twig()
	{
		$loader = new TwigLoader();

		return new \Twig_Environment($loader);
	}

	public function __toString()
	{
		return get_class($this);
	}
}
