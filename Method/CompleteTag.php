<?php
namespace GDO\Tags\Method;

use GDO\Core\GDO;
use GDO\Core\MethodCompletion;
use GDO\Tags\GDO_Tag;

final class CompleteTag extends MethodCompletion
{

	public function gdoTable(): GDO
	{
		return GDO_Tag::table();
	}

	protected function gdoHeaderFields(): array
	{
		return [
			'tag_name',
		];
	}

}
