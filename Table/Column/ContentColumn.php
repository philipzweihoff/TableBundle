<?php

namespace JGM\TableBundle\Table\Column;

use JGM\TableBundle\Table\Column\AbstractColumn;
use JGM\TableBundle\Table\Column\ContentGrabber\ContentGrabberInterface;
use JGM\TableBundle\Table\Row\Row;
use JGM\TableBundle\Table\TableException;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


/**
 * Uses a ContentGrabber or a ContentFunction to generate
 * the output for this column.
 *
 * @author	Jan Mühlig <mail@janmuehlig.de>
 * @since	1.0
 */
class ContentColumn extends AbstractColumn implements ContainerAwareInterface
{
	/**
	 * @var ContainerInterface 
	 */
	protected $container;
	
	public function setDefaultOptions(OptionsResolverInterface $optionsResolver)
	{
		parent::setDefaultOptions($optionsResolver);
		
		$optionsResolver->setDefaults(array(
			'content_grabber' => null
		));
	}

	public function setContainer(ContainerInterface $container = null)
	{
		$this->container = $container;
	}

	public function getContent(Row $row)
	{
		if($this->options['content_grabber'] !== null)
		{
			if($this->options['content_grabber'] instanceof ContentGrabberInterface)
			{
				if(is_callable(array($this->options['content_grabber'], 'setContainer')))
				{
					$this->options['content_grabber']->setContainer($this->container);
				}
			
				return $this->options['content_grabber']->getContent($row, $this);
			}
			else if(is_callable($this->options['content_grabber']))
			{
				return $this->options['content_grabber']($row, $this);
			}
		}
		
		TableException::noContentDefined($this->getName());
	}

}
