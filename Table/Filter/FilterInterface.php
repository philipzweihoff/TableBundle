<?php

namespace JGM\TableBundle\Table\Filter;

use JGM\TableBundle\Table\DataSource\DataSourceInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Interface for adding filters to the table.
 * 
 * @author	Jan Mühlig <mail@janmuehlig.de>
 * @since	1.0
 */
interface FilterInterface
{
	public function __construct(ContainerInterface $container);

		/**
	 * Here are your options. 
	 * Do whatever you want with these.
	 * 
	 * @param array $options	Options.
	 */
	public function setOptions(array $options);
	
	/**
	 * This is your name in the table.
	 * 
	 * @param string $name		Name.
	 */
	public function setName($name);
	
	/**
	 * @return string			Label for this column.
	 */
	public function getLabel();
	
	/**
	 * @return string			Name of this column.
	 */
	public function getName();
	
	/**
	 * @return int				Index of the operator.
	 */
	public function getOperator();
	
	/**
	 * @return array			Columns, the filter will work on.
	 */
	public function getColumns();
	
	/**
	 * @return mixed			Expression for the column name and data source.
	 */
	public function getExpressionForColumn(DataSourceInterface $dataSource, $columnName);
	
	/**
	 * @return array			Attributes for every row (tr).
	 */
	public function getAttributes();
	
	/**
	 * @return boolean			Returns True, if this filter needs the <form>-enviroment,
	 *							including the submit und reset buttons. False, otherwise.
	 */
	public function needsFormEnviroment();
	
	/**
	 * Sets the value of the filter.
	 * 
	 * @param mixed $value
	 */
	public function setValue(array $value);
	
	/**
	 * @return array			List of parameter names, which contain the value(s) of
	 *							this filter.
	 */
	public function getParameterNames();
	
	/**
	 * @return mixed			Value of the filter.
	 */
	public function getValue();
	
	/**
	 * @return string			Name of the filter widgets block name.
	 */
	public function getWidgetBlockName();
}
