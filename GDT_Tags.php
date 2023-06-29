<?php
namespace GDO\Tags;

use GDO\Core\GDO;
use GDO\Core\GDT_Select;
use GDO\Core\GDT_Template;
use GDO\Core\WithGDO;
use GDO\Table\GDT_Filter;
use GDO\Util\Arrays;

/**
 * A tag form input field.
 * Updates an objects tagdata upon create and update.
 *
 * @version 7.0.1
 * @since 3.0.0
 * @author gizmore
 * @see WithTags
 */
final class GDT_Tags extends GDT_Select
{

	use WithGDO;

	/**
	 * Mandatory.
	 * The tagtable backing this tags input.
	 */
	public GDO_TagTable $tagtable;

//     use WithIcon;
//     use WithLabel;
//     use WithError;
//     use WithValue;
//     use WithFormAttributes;
	public int $minTags = 0;
	public int $maxTags = 4;

	################
	### TagTable ###
	################

	protected function __construct()
	{
		parent::__construct();
		$this->icon = 'tag';
		$this->multiple();
//         $this->initial = '';
		$this->completionHref(href('Tags', 'Completion'));
	}

	public function isTestable(): bool
	{
		return false;
	}

	#############
	### Event ###
	#############

	public function gdtDefaultLabel(): ?string
    { return 'tags'; }

	public function gdoAfterCreate(GDO $gdo): void { $this->updateTags(); }

	public function updateTags() { $this->gdo->updateTags($this->getValue()); }

	#############
	### Value ###
	#############

	public function gdoAfterUpdate(GDO $gdo): void { $this->updateTags(); }

	public function toValue(null|string|array $var): null|bool|int|float|string|object|array
	{
		if (!empty($var))
		{
			if ($var[0] === '[')
			{
				$tags = ($tags = @json_decode($var)) ? $tags : [];
			}
			else
			{
				$tags = Arrays::explode($var);
			}
			return array_map(function ($a) { return trim($a); }, $tags);
		}
		return [];
	}

	####################
	### Min/Max Tags ###
	####################

	public function toVar(null|bool|int|float|string|object|array $value): ?string
	{
		if ($value !== null)
		{
			return json_encode(array_values($value));
		}
		return null;
	}

	public function renderHTML(): string { return GDT_Template::php('Tags', 'cell/tags.php', ['field' => $this]); }

	public function renderForm(): string { return GDT_Template::php('Tags', 'form/tags.php', ['field' => $this]); }

	public function renderJSON(): array|string|null|int|bool|float
	{
		return [
			'all' => array_keys(GDO_Tag::table()->all()),
			'tags' => isset($this->gdo) ? array_values(array_map(function ($tag) { return $tag->getName(); }, $this->gdo->getTags())) : $this->getValue(),
		];
	}

	##############
	### Render ###
	##############

	public function validate(int|float|string|array|null|object|bool $value): bool
	{
		# Have to pass null check
		if (parent::validate($value))
		{
			# Has to be array
			if (is_array($value))
			{
				# Check forced tag count
				if (count($value) < $this->minTags)
				{
					return $this->error('err_min_tags', [$this->minTags]);
				}
				if (count($value) > $this->maxTags)
				{
					return $this->error('err_max_tags', [$this->maxTags]);
				}

				# Check individual tags
				$namefield = GDT_TagName::make();
				foreach ($value as $tagName)
				{
					if (!$namefield->validate($tagName))
					{
						return $this->error('err_tag_name', [htmlspecialchars($tagName)]);
					}
				}
				# winner winner
			}
			else
			{
				return $this->error('err_tags_not_an_array');
			}
			# chicken dinner
			return true;
		}
		return false;
	}

	public function renderFilter(GDT_Filter $f): string
	{
		return GDT_Template::php('Tags', 'filter/tags.php', ['field' => $this, 'f' => $f]);
	}

	public function tagtable(GDO_TagTable $tagtable)
	{
		$this->tagtable = $tagtable;
		return $this;
	}

	################
	### Validate ###
	################

	public function minTags($minTags)
	{
		$this->minTags = $minTags;
		return $this;
	}

	public function maxTags($maxTags)
	{
		$this->maxTags = $maxTags;
		return $this;
	}

	public function renderHeader(): string { return $this->displayLabel(); }

}
