<?php
namespace GDO\Tags\Method;

use GDO\Core\Method;

final class AdminOverview extends Method
{
	public function execute()
	{
		return $this->templatePHP('admin_overview.php');
	}
}
