<?php
/**
 * ShadowrunNexus - A MediaWiki skin blending cyberpunk and magical aesthetics
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * @file
 * @ingroup Skins
 */

namespace MediaWiki\Skins\ShadowrunNexus;

use MediaWiki\MediaWikiServices;
use OutputPage;
use SkinTemplate;

/**
 * SkinTemplate class for the ShadowrunNexus skin
 * @ingroup Skins
 */
class SkinShadowrunNexus extends SkinTemplate {
	/** @var string */
	public $skinname = 'shadowrunnexus';
	/** @var string */
	public $template = 'MediaWiki\\Skins\\ShadowrunNexus\\ShadowrunNexusTemplate';

	/**
	 * Add CSS via ResourceLoader
	 *
	 * @param OutputPage $out
	 */
	public function initPage( OutputPage $out ) {
		parent::initPage( $out );
		
		// Add JavaScript
		$out->addModules( 'skins.shadowrunnexus.js' );
		
		// Add CSS
		$out->addModuleStyles( [
			'skins.shadowrunnexus.styles'
		] );
		
		// For debugging - add inline CSS to verify CSS loading works
		$out->addInlineStyle( 'body { border: 5px solid red !important; }' );
	}

	/**
	 * @param OutputPage $out
	 */
	function setupSkinUserCss( OutputPage $out ) {
		parent::setupSkinUserCss( $out );
		
		// Add additional CSS modules if needed
		$out->addModuleStyles( [
			'mediawiki.skinning.interface',
			'skins.shadowrunnexus.styles'
		] );
	}
	
	/**
	 * Override to ensure we're properly preparing the template data
	 */
	public function prepareQuickTemplate() {
		$tpl = parent::prepareQuickTemplate();
		
		// Make sure bodycontent is set
		if ( !isset( $tpl->data['bodycontent'] ) || empty( $tpl->data['bodycontent'] ) ) {
			$output = $this->getOutput();
			if ( isset( $output->mBodytext ) ) {
				$tpl->set( 'bodycontent', $output->mBodytext );
			}
		}
		
		// Also set bodytext as an alternative
		if ( !isset( $tpl->data['bodytext'] ) || empty( $tpl->data['bodytext'] ) ) {
			$output = $this->getOutput();
			if ( isset( $output->mBodytext ) ) {
				$tpl->set( 'bodytext', $output->mBodytext );
			}
		}
		
		return $tpl;
	}
}

