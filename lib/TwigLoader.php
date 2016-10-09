<?php

namespace ICanBoogie\RenderEngineTwig;

class TwigLoader implements \Twig_LoaderInterface
{
	/**
	 * @inheritdoc
	 */
	public function getSource($name)
	{
		return file_get_contents($name);
	}

	/**
	 * @inheritdoc
	 */
	public function getCacheKey($name)
	{
		return $name;
	}

	/**
	 * @inheritdoc
	 */
	public function isFresh($name, $time)
	{
		return filemtime($name) <= $time;
	}
}
