<?php

namespace PZAD\TableBundle\Table\Filter;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Builder for building table filters.
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
	
	public function __construct(ContainerInterface $container)
	{
		$this->filters = array();
		
		$this->registeredFilters = $container->getParameter('pzad_table.filters');
	}
	
	public function add($type, $name, $options)
	{
		if(array_key_exists($name, $this->filters))
		{
			FilterException::duplicatedFilterName($name);
		}
		
		$type = strtolower($type);
		if(!array_key_exists($type, $this->registeredFilters))
		{
			FilterException::typeNotAllowed($type, array_keys($this->registeredFilters));
		}
		
		$filter = new $this->registeredFilters[$type];
		/* @var $filter FilterInterface */
		
		if(!$filter instanceof FilterInterface)
		{
			FilterException::filterClassNotImplementingInterface($filter);
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