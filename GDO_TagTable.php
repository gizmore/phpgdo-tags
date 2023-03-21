<?php
namespace GDO\Tags;

use GDO\Core\GDO;
use GDO\Core\GDT_CreatedAt;
use GDO\Core\GDT_CreatedBy;
use GDO\Core\GDT_Object;
use GDO\Core\ModuleLoader;

class GDO_TagTable extends GDO
{

	/**
	 * @return self[]
	 */
	public static function allTagTables()
	{
		$tables = [];
		foreach (ModuleLoader::instance()->getModules() as $module)
		{
			if ($classes = $module->getClasses())
			{
				foreach ($classes as $className)
				{
					if (is_subclass_of($className, 'GDO\Tags\GDO_TagTable'))
					{
						$tables[] = GDO::tableFor($className);
					}
				}
			}
		}
		return $tables;
	}

	public function gdoCached(): bool { return false; }

	public function gdoAbstract(): bool { return $this->gdoTagObjectTable() === null; }

	/**
	 * @return GDO
	 */
	public function gdoTagObjectTable() {}

	public function gdoColumns(): array
	{
		return [
			GDT_Object::make('tag_tag')->table(GDO_Tag::table())->primary(),
			GDT_TagTable::make('tag_object')->table($this->gdoTagObjectTable())->primary(),
			GDT_CreatedBy::make('tag_created_by'),
			GDT_CreatedAt::make('tag_created_at'),
		];
	}

	public function allObjectTags()
	{
		$table = $this->gdoTagObjectTable();
		if (!($cache = $table->tempGet('gdo_tags')))
		{
			$cache = $this->select('tag_id, tag_name, COUNT(tag_id) tag_count')->joinObject('tag_tag')->group('tag_id, tag_name')->exec()->fetchAllArray2dObject(GDO_Tag::table());
			$table->tempSet('gdo_tags', $cache);
		}
		return $cache;
	}

}
