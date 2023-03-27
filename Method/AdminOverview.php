<?php
namespace GDO\Tags\Method;

use GDO\Core\GDT;
use GDO\Core\Method;

final class AdminOverview extends Method
{

	public function getMethodTitle(): string
	{
		return t('perm_admin');
	}

	public function execute(): GDT
	{
		return $this->templatePHP('admin_overview.php');
	}

}
