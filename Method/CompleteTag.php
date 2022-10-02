<?php
namespace GDO\Tags\Method;

use GDO\Core\GDO;
use GDO\Core\MethodCompletion;
use GDO\Tags\GDO_Tag;

/**
 * Tag autocompletion.
 * 
 * @author gizmore
 */
final class CompleteTag extends MethodCompletion
{

	public function gdoTable(): GDO
	{
		return GDO_Tag::table();
	}

	protected function gdoHeaderFields(): array
	{
		return $this->gdoTable()->gdoColumnsOnly('tag_name');
	}
	
}
