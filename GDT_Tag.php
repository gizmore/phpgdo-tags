<?php
namespace GDO\Tags;

use GDO\Core\GDT_Object;

class GDT_Tag extends GDT_Object
{

	protected function __construct()
	{
		parent::__construct();
		$this->icon('tag');
		$this->table(GDO_Tag::table());
		$this->completionHref(href('Tags', 'CompleteTag'));
	}

	public function renderName(): string
	{
		return $this->getTag()->renderName();
	}

	/**
	 * @return Tag;
	 */
	public function getTag()
	{
		return $this->getValue();
	}

	public function gdtDefaultLabel(): ?string
	{
		return 'tag';
	}

}
