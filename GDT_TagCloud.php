<?php
declare(strict_types=1);
namespace GDO\Tags;

use GDO\Core\GDT_Template;
use GDO\Core\WithObject;
use GDO\DB\Query;
use GDO\Table\GDT_Filter;

/**
 * Render a tag cloud.
 *
 * @version 7.0.3
 * @since 6.04
 *
 * @author gizmore
 * @see WithTags
 * @see GDT_Tag
 * @see GDO_Tag
 * @see GDO_TagTable
 */
class GDT_TagCloud extends GDT_Template
{

	use WithObject;

	public string $totalCountCondition = '1';
	public string $filterName = 'f';

	protected function __construct()
	{
		parent::__construct();
		$this->template('Tags', 'cell/tag_cloud.php', ['field' => $this]);
	}

	###################
	### Total count ###
	###################

	/**
	 * @return GDO_Tag[]
	 */
	public function getTags()
	{
		return $this->getTagTable()->allObjectTags();
	}

	/**
	 * @return GDO_TagTable
	 */
	public function getTagTable()
	{
		return $this->table->gdoTagTable();
	}

	public function totalCountCondition($totalCountCondition)
	{
		$this->totalCountCondition = $totalCountCondition;
		return $this;
	}

	##############
	### Filter ###
	##############

	public function totalCount()
	{
		return $this->table->countWhere($this->totalCountCondition);
	}

	public function filterName($filterName)
	{
		$this->filterName = $filterName;
		return $this;
	}

	public function filterQuery(Query $query, GDT_Filter $f): static
	{
		if ($filterId = $this->filterVar($f))
		{
			$tagtable = $this->getTagTable();
			$objtable = $this->table;
			$query->join("JOIN {$tagtable->gdoTableIdentifier()} ON tag_tag={$filterId} AND tag_object={$objtable->gdoPrimaryKeyColumn()->getName()}");
		}
		return $this;
	}


	public function hrefTagFilter(GDO_Tag $tag = null)
	{
		$name = $this->name;
		$f = $this->filterName;
		$url = preg_replace("/&$f\\[$name\\]=\d+/", '', urldecode($_SERVER['REQUEST_URI']));
		$url = preg_replace('/&page=\d+/', '', $url);
		if ($tag)
		{
			$url .= "&{$f}[$name]=" . $tag->getID();
		}
		return $url;
	}

}
