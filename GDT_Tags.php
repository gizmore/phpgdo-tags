<?php
namespace GDO\Tags;

use GDO\Core\GDO;
use GDO\Core\GDT_Template;
use GDO\Util\Arrays;
use GDO\Table\GDT_Filter;
use GDO\Core\WithGDO;
use GDO\Core\GDT_ComboBox;
use GDO\Core\GDT_Enum;
use GDO\Core\GDT_Select;

/**
 * A tag form input field.
 * Updates an objects tagdata upon create and update.
 * 
 * @author gizmore
 * @version 7.0.1
 * @since 3.0.0
 * @see WithTags
 */
final class GDT_Tags extends GDT_Select
{
	use WithGDO;
	
	public function isTestable(): bool
	{
		return false;
	}
	
//     use WithIcon;
//     use WithLabel;
//     use WithError;
//     use WithValue;
//     use WithFormAttributes;
    
    public function defaultLabel(): static { return $this->label('tags'); }
    
    protected function __construct()
    {
        parent::__construct();
        $this->icon = 'tag';
        $this->multiple();
//         $this->initial = '';
        $this->completionHref(href('Tags', 'Completion'));
    }
    
    ################
    ### TagTable ###
    ################
    /**
     * Mandatory.
     * The tagtable backing this tags input.
     */
    public GDO_TagTable $tagtable;
    public function tagtable(GDO_TagTable $tagtable) { $this->tagtable = $tagtable; return $this; }
    
	#############
	### Event ###
	#############
	public function gdoAfterCreate(GDO $gdo) : void { $this->updateTags(); }
	public function gdoAfterUpdate(GDO $gdo) : void { $this->updateTags(); }
	public function updateTags() { $this->gdo->updateTags($this->getValue()); }
	
	#############
	### Value ###
	#############
	public function toValue($var=null)
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
			return array_map(function($a){return trim($a);}, $tags);
		}
		return [];
	}
	
	public function toVar($value) : ?string
	{
	    if ($value !== null)
	    {
	        return json_encode(array_values($value));
	    }
	    return null;
	}
	
	####################
	### Min/Max Tags ###
	####################
	public int $minTags = 0;
	public function minTags($minTags) { $this->minTags = $minTags; return $this; }
	public int $maxTags = 4;
	public function maxTags($maxTags) { $this->maxTags = $maxTags; return $this; }
	
	##############
	### Render ###
	##############
	public function renderHTML(): string { return GDT_Template::php('Tags', 'cell/tags.php', ['field' => $this]); }
	public function renderForm(): string { return GDT_Template::php('Tags', 'form/tags.php', ['field' => $this]); }
	public function renderJSON()
	{
		return [
		    'all' => array_keys(GDO_Tag::table()->all()),
			'tags' => isset($this->gdo) ? array_values(array_map(function($tag){return $tag->getName();}, $this->gdo->getTags())) : $this->getValue(),
		];
	}
	
	################
	### Validate ###
	################
	public function validate($tags) : bool
	{
		# Have to pass null check
		if (parent::validate($tags))
		{
			# Has to be array
			if (is_array($tags))
			{
				# Check forced tag count
				if (count($tags) < $this->minTags)
				{
					return $this->error('err_min_tags', [$this->minTags]);
				}
				if (count($tags) > $this->maxTags)
				{
					return $this->error('err_max_tags', [$this->maxTags]);
				}
				
				# Check individual tags
				$namefield = GDT_TagName::make();
				foreach ($tags as $tagName)
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
	}
	
	public function renderHeader() : string { return $this->displayLabel(); }
	
	public function renderFilter(GDT_Filter $f) : string
	{
		return GDT_Template::php('Tags', 'filter/tags.php', ['field' => $this, 'f' => $f]);
	}
	
}
