<?php
use GDO\Table\GDT_Table;
use GDO\Tags\Module_Tag;
use GDO\Tags\GDO_Tag;
use GDO\UI\GDT_Button;
use GDO\Core\GDT_Fields;

$module = Module_Tag::instance();
echo $module->renderAdminTabs();

$gdo = GDO_Tag::table();
$query = $gdo->select('*');

$table = GDT_Table::make();
$headers = GDT_Fields::make();
$headers->addFields($gdo->gdoColumnsCache());
$headers->addField(GDT_Button::make('edit'));
$table->headers($headers);
$table->filtered();
$table->paginateDefault();
$table->query($query);
$table->href(href('Tags', 'AdminOverview'));

echo $table->render();
