<?php

namespace BlueSpice\SmartList\Tag;

use BlueSpice\Tag\Tag;
use MediaWiki\MediaWikiServices;
use Parser;
use PPFrame;
use RequestContext;

class Whatlinkshere extends Tag {

	/** @var MediaWikiServices */
	private $services;

	/** @var BlueSpiceSmartListModeFactory */
	private $factory;

	/** @var IMode */
	private $mode;

	/**
	 *
	 */
	public function __construct() {
		$this->services = MediaWikiServices::getInstance();
		$this->factory = $this->services->getService( 'BlueSpiceSmartList.SmartlistMode' );
		$this->mode = $this->factory->createMode( 'whatlinkshere' );
	}

	/**
	 *
	 * @param string $processedInput
	 * @param array $processedArgs
	 * @param Parser $parser
	 * @param PPFrame $frame
	 * @return PageBreakHandler
	 */
	public function getHandler( $processedInput, array $processedArgs, Parser $parser,
		PPFrame $frame ) {
		$context = RequestContext::getMain();
		$titleFactory = $this->services->getTitleFactory();
		$hookContainer = $this->services->getHookContainer();

		return new SmartListHandler(
			$processedInput,
			$processedArgs,
			$parser,
			$frame,
			$context,
			$titleFactory,
			$hookContainer,
			$this->mode
		);
	}

	/**
	 *
	 * @return string[]
	 */
	public function getTagNames() {
		return [
			'whatlinkshere'
		];
	}

	/**
	 * @return IParamDefinition[]
	 */
	public function getArgsDefinitions() {
		return $this->mode->getParams();
	}

}
