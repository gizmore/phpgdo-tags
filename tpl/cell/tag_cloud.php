<?php
namespace GDO\Tags\tpl\cell;

use GDO\Table\GDT_Filter;
use GDO\Tags\GDT_TagCloud;

/** @var $field GDT_TagCloud * */
$filterField = GDT_Filter::make($field->name);
$filterVar = $field->filterVar($filterField);
?>
<div class="gdt-tag-cloud">
    <a
            href="<?=$field->hrefTagFilter()?>"
            class="<?=$filterVar === '0' ? 'gdo-selected' : ''?>">
        <span><?=t('all')?>(<?=$field->totalCount()?>)</span>
    </a>
	<?php
	foreach ($field->getTags() as $tag) : ?>
        <a
                href="<?=$field->hrefTagFilter($tag)?>"
                class="<?=$filterVar === $tag->getID() ? 'gdo-selected' : ''?>">
            <span><?=$tag->renderName()?>(<?=$tag->getCount()?>)</span>
        </a>
	<?php
	endforeach; ?>
    <input type="hidden" name="f[<?=$field->name?>]" value="<?=html($filterVar)?>"/>
</div>
