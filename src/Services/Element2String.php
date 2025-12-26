<?php

declare(strict_types=1);

namespace HTMx\Services;

use Concrete\Core\View\View;

class Element2String
{
	protected string $content = '';

	public function __construct(string $elementFileName, ?string $packageName, array $elementData = [])
	{
		ob_start();
			View::element($elementFileName, $elementData, $packageName);
			$this->content = ob_get_contents();
		ob_end_clean();
	}

	public function __toString()
	{
		return $this->content;
	}
}
