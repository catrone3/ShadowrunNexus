<?php

namespace MediaWiki\Skins\ShadowrunNexus;

use MediaWiki\Hook\BeforePageDisplayHook;
use OutputPage;
use Skin;

/**
 * Hook handlers for ShadowrunNexus skin
 */
class Hooks implements BeforePageDisplayHook {

	/**
	 * BeforePageDisplay hook handler
	 * @param OutputPage $out
	 * @param Skin $skin
	 */
	public function onBeforePageDisplay( $out, $skin ): void {
		if ( $skin->getSkinName() === 'shadowrunnexus' ) {
			// Add any specific JS or CSS needed for all pages
		}
	}
}
