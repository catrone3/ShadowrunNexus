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
use MediaWiki\Skins\SkinMustache;
use OutputPage;
use Skin;

/**
 * SkinMustache class for the ShadowrunNexus skin
 * @ingroup Skins
 */
class SkinShadowrunNexus extends SkinMustache {
	/**
	 * @inheritDoc
	 */
	public function __construct( $options = [] ) {
		$options['templateDirectory'] = __DIR__ . '/templates';
		parent::__construct( $options );
	}

	/**
	 * @inheritDoc
	 */
	public function getTemplateData(): array {
		$data = parent::getTemplateData();
		
		$contentNavigation = $this->buildContentNavigationUrls();
		$portals = $this->buildSidebar();
		
		// Format and add vector-specific data
		$data['data-portals'] = $this->getPortals( $portals );
		$data['data-portals-first'] = reset( $data['data-portals'] );
		$data['data-portals-rest'] = array_slice( $data['data-portals'], 1 );
		
		// Personal tools
		$data['personal-menu'] = $this->getPersonalToolsForMustache( $this->buildPersonalUrls() );
		
		// Content navigation
		$data['content-navigation'] = $this->getContentNavigationForMustache( $contentNavigation );
		
		// Site name
		$data['site-name'] = $this->getConfig()->get( 'Sitename' );
		
		// Logo
		$logos = $this->getLogoData();
		$data['logo'] = $logos['1x'];
		$data['logo-tagline'] = $this->msg( 'tagline' )->text();
		
		// Search
		$data['search-action'] = $this->getSearchURL();
		$data['search-input-id'] = 'sr-nexus-searchInput';
		$data['search-button-id'] = 'sr-nexus-searchButton';
		
		return $data;
	}
	
	/**
	 * Get personal tools for Mustache template
	 * @param array $personalTools
	 * @return array
	 */
	protected function getPersonalToolsForMustache( $personalTools ) {
		$items = [];
		foreach ( $personalTools as $key => $item ) {
			// Skip redundant logout link
			if ( $key === 'logout' ) {
				continue;
			}
			
			$items[] = [
				'id' => $key,
				'href' => $item['href'] ?? null,
				'text' => $item['text'] ?? null,
				'class' => $item['class'] ?? null,
				'active' => $item['active'] ?? false,
				'icon' => $item['icon'] ?? null,
			];
		}
		
		return [
			'id' => 'p-personal',
			'class' => 'sr-nexus-personal-tools',
			'html-items' => '',
			'html-tooltip' => '',
			'html-after-portal' => '',
			'items' => $items
		];
	}
	
	/**
	 * Get content navigation for Mustache template
	 * @param array $contentNavigation
	 * @return array
	 */
	protected function getContentNavigationForMustache( $contentNavigation ) {
		$result = [];
		
		foreach ( $contentNavigation as $category => $items ) {
			$formattedItems = [];
			
			foreach ( $items as $key => $item ) {
				$formattedItems[] = [
					'id' => $key,
					'href' => $item['href'] ?? null,
					'text' => $item['text'] ?? null,
					'class' => $item['class'] ?? null,
					'active' => $item['active'] ?? false,
					'icon' => $item['icon'] ?? null,
				];
			}
			
			$result[$category] = [
				'id' => 'p-' . $category,
				'class' => 'sr-nexus-nav-' . strtolower($category),
				'html-items' => '',
				'html-tooltip' => '',
				'html-after-portal' => '',
				'items' => $formattedItems
			];
		}
		
		return $result;
	}
	
	/**
	 * Get portals for Mustache template
	 * @param array $sidebar
	 * @return array
	 */
	protected function getPortals( $sidebar ) {
		$portals = [];
		
		// Render portals
		foreach ( $sidebar as $name => $content ) {
			if ( $content === false ) {
				continue;
			}
			
			// Numeric strings gets an integer when set as key, cast back
			$name = (string)$name;
			
			$portal = [
				'name' => $name,
				'id' => Skin::makeIdFromName( $name ),
				'class' => 'sr-nexus-portal',
				'html-items' => '',
				'html-tooltip' => '',
				'html-after-portal' => '',
				'items' => []
			];
			
			// Message that is used as the header of the portal
			$msgObj = $this->msg( $name );
			$portal['label'] = $msgObj->exists() ? $msgObj->text() : $name;
			
			if ( is_array( $content ) ) {
				foreach ( $content as $key => $val ) {
					$portal['items'][] = $this->makeListItem( $key, $val );
				}
			} else {
				$portal['html-items'] = $content;
			}
			
			$portals[] = $portal;
		}
		
		return $portals;
	}
	
	/**
	 * Get search URL
	 * @return string
	 */
	protected function getSearchURL() {
		$config = $this->getConfig();
		$target = $config->get( 'Script' );
		
		return wfAppendQuery( $target, [ 'title' => SpecialPage::getTitleFor( 'Search' )->getPrefixedDBkey() ] );
	}
	
	/**
	 * @inheritDoc
	 */
	public function initPage( OutputPage $out ) {
		parent::initPage( $out );
		$out->addModules( 'skins.shadowrunnexus.js' );
		$out->addModuleStyles( [
			'mediawiki.skinning.interface',
			'skins.shadowrunnexus.styles'
		] );
	}
}
