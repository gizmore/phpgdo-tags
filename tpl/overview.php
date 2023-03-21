<?php

use GDO\UI\GDT_Bar;
use GDO\UI\GDT_Panel;

/** @var $navbar GDT_Bar * */
echo $navbar->render();
echo GDT_Panel::make()->text('box_content_tags_overview')->render();
