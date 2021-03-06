<?php

namespace JGM\TableBundle\Table\Filter;

use JGM\TableBundle\Table\Filter\FilterInterface;
use JGM\TableBundle\Table\TableException;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Builder for building table filters.
 * 
 * @author	Jan Mühlig <mail@janmuehlig.de>
 * @since	1.0
 */
class FilterBuilder
{
	/**
	 * @var array
	 */
	private $filters;
	
	/**
	 * @var array
	 */
	private $registeredFilters;
	
	/**
	 * @var ContainerInterface
	 */
	private $container;
	
	public function __construct(ContainerInterface $container)
	{
		$this->filters = array();
		
		$this->registeredFilters = $container->getParameter('jgm_table.filters');
		
		$this->container = $container;
	}
	
	public function add($type, $name, $options)
	{
		if(array_key_exists($name, $this->filters))
		{
			TableException::duplicatedFilterName($name);
		}
		
		$type = strtolower($type);
		if(!array_key_exists($type, $this->registeredFilters))
		{
			TableException::filterTypeNotAllowed($type, array_keys($this->registeredFilters));
		}
		
		$filter = new $this->registeredFilters[$type]($this->container);
		/* @var $filter FilterInterface */
		
		if(!$filter instanceof FilterInterface)
		{
			TableException::filterClassNotImplementingInterface($filter);
		}
		
		$filter->setName($name);
		$filter->setOptions($options);
		
		$this->filters[$name] = $filter;
		
		return $this;
	}
	
	public function getFilters()
	{
		return $this->filters;
	}
}
