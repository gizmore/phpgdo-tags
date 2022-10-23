<?php
namespace GDO\Tags\tpl\cell;
use GDO\Tags\GDT_Tags;
/** @var $field GDT_Tags **/

if (isset($field->gdo))
{
	foreach ($field->gdo->getTags() as $tag)
	{
		echo $tag->renderName();
	}
}
