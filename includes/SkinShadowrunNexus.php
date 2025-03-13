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
		$out->addModules( 'skins.shadowrunnexus.js' );
		$out->addModuleStyles( [
			'mediawiki.skinning.interface',
			'skins.shadowrunnexus.styles'
		] );
	}

	/**
	 * @param OutputPage $out
	 */
	function setupSkinUserCss( OutputPage $out ) {
		parent::setupSkinUserCss( $out );
	}
	
	/**
	 * Override to ensure we're properly preparing the template data
	 */
	public function prepareQuickTemplate() {
		$tpl = parent::prepareQuickTemplate();
		
		// Make sure bodycontent is set
		if ( !isset( $tpl->data['bodycontent'] ) && isset( $this->getOutput()->mBodytext ) ) {
			$tpl->set( 'bodycontent', $this->getOutput()->mBodytext );
		}
		
		// For debugging - log the available template data keys
		error_log('ShadowrunNexus template data keys: ' . implode(', ', array_keys($tpl->data)));
		
		return $tpl;
	}
}

