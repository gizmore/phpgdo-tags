<?php
namespace GDO\Tag\Method;

use GDO\Core\GDO;
use GDO\Core\MethodCompletion;
use GDO\Tags\GDO_Tag;

final class CompleteTag extends MethodCompletion
{
    public function gdoTable() : GDO
    {
        return GDO_Tag::table();
    }

    public function gdoHeaderColumns()
    {
        return ['tag_name'];
    }
    
    public function renderJSON(GDO $gdo)
    {
        return array(
            'id' => $gdo->getID(),
            'text' => $gdo->displayName(),
            'display' => $gdo->renderCell(),
        );
    }
	public function execute()
	{
	}



}
