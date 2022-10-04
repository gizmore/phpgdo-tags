<?php
namespace GDO\Tags;

use GDO\Core\GDO;
use GDO\Core\GDT_AutoInc;
use GDO\Core\GDT_Int;

final class GDO_Tag extends GDO
{
	public function memCached() : bool { return false; }
	
	public function gdoColumns() : array
	{
		return array(
			GDT_AutoInc::make('tag_id'),
			GDT_TagName::make('tag_name')->notNull()->unique(),
			GDT_Int::make('tag_count')->unsigned()->notNull()->initial('1')->writeable(false),
		);
	}
	
	public function getID() : ?string { return $this->gdoVar('tag_id'); }
	public function getName() : ?string { return $this->gdoVar('tag_name'); }
	public function getCount() { return $this->gdoVar('tag_count'); }
	
	public function renderName(): string { return $this->getName(); }
	
	public function renderHTML() : string
	{
		return GDT_Tag::make()->gdo($this)->renderHTML();
	}
	
	public function href_edit() {return href('Tags', 'AdminEdit', '&id='.$this->getID()); }
	
	##############
	### Static ###
	##############
	
	/**
	 * 
	 * @param GDO $gdo
	 * @return self[]
	 */
	public static function forObject(GDO $gdo=null)
	{
		if ($gdo)
		{
			if (!($cache = $gdo->tempGet('gdo_tags')))
			{
				$tags = $gdo->gdoTagTable();
				$tags instanceof GDO_TagTable;
				$cache = $tags->select('tag_name, tag_id, tag_count')->joinObject('tag_tag')->where("tag_object=".$gdo->getID())->exec()->fetchAllArray2dObject(self::table());
				$gdo->tempSet('gdo_tags', $cache);
			}
			return $cache;
		}
		return [];
	}
}
