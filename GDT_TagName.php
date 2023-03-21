<?php
namespace GDO\Tags;

use GDO\Core\GDT;
use GDO\Core\GDT_String;

class GDT_TagName extends GDT_String
{

	protected function __construct()
	{
		parent::__construct();
		$this->min = 2;
		$this->max = 28;
		$this->caseI();
// 		$this->pattern = "/^[a-z0-9][-_a-z0-9]{1,27}$/iD";
	}

	public function plugVars(): array
	{
		return [
			[$this->getName() => 'Tag#' . GDT::$GDT_COUNT],
		];
	}

}
