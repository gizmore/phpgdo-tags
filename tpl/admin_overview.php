<?php
namespace GDO\Tags\tpl;

use GDO\Table\GDT_Filter;
use GDO\Table\GDT_Table;
use GDO\Tags\GDO_Tag;
use GDO\Tags\Module_Tags;
use GDO\UI\GDT_Button;

$module = Module_Tags::instance();
echo $module->renderAdminTabs();

$gdo = GDO_Tag::table();
$query = $gdo->select();

$filter = GDT_Filter::make();

$table = GDT_Table::make();
$table->getHeaders()->addFields(
	GDT_Button::make('edit'),
	...$gdo->gdoColumnsCache());
$table->filtered(true, $filter);
$table->paginateDefault();
$table->query($query);
$table->href(href('Tags', 'AdminOverview'));

echo $table->render();
