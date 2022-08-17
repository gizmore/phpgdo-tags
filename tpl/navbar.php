<?php
use GDO\UI\GDT_Bar;
use GDO\UI\GDT_Link;
$navbar = GDT_Bar::make();
$navbar->addFields(
	GDT_Link::make('link_tags')->href(href('Tags', 'AdminTags')),
	GDT_Link::make('link_untagged')->href(href('Tags', 'AdminTags')),
	GDT_Link::make('link_tagged_tables')->href(href('Tags', 'AdminTags')),
);
echo $navbar->render();
