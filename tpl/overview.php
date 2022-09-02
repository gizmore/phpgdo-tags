<?php
use GDO\UI\GDT_Panel;
use GDO\UI\GDT_Bar;
/** @var $navbar GDT_Bar **/
echo $navbar->render();
echo GDT_Panel::make()->text('box_content_tags_overview')->render();
