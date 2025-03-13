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

use BaseTemplate;
use Hooks;
use Linker;
use Sanitizer;

/**
 * BaseTemplate class for ShadowrunNexus skin
 * @ingroup Skins
 */
class ShadowrunNexusTemplate extends BaseTemplate {
	/**
	 * Outputs the entire contents of the page
	 */
	public function execute() {
		// For debugging - let's see what data we have available
		//echo '<pre>' . htmlspecialchars(print_r($this->data, true)) . '</pre>';

		// Output the opening html element and head element
		echo '<!DOCTYPE html>';
		echo '<html class="client-nojs" lang="' . htmlspecialchars( $this->get( 'lang' ) ) . '" dir="' . htmlspecialchars( $this->get( 'dir' ) ) . '">';
		echo '<head>';
		echo '<meta charset="UTF-8" />';
		echo '<title>' . htmlspecialchars( $this->get( 'pagetitle' ) ) . '</title>';
		
		// Include all the necessary head elements
		echo $this->get( 'csslinks' );
		echo $this->get( 'headlinks' );
		
		// Add site scripts - removed jsvarurl section that was causing warnings
		echo $this->get( 'headscripts' );
		
		echo '</head>';
		echo '<body class="' . htmlspecialchars( $this->get( 'bodyclass' ) ) . '">';
		
		// Add body content
		echo $this->get( 'prebodyhtml' );
		?>
		<div id="sr-nexus-wrapper" class="sr-nexus-wrapper">
			<header id="sr-nexus-header">
				<div class="sr-nexus-header-inner">
					<div class="sr-nexus-logo-container">
						<?php
						if ( isset( $this->data['newtalk'] ) && $this->data['newtalk'] ) {
							?>
							<div class="sr-nexus-new-messages"><?php $this->html( 'newtalk' ); ?></div>
							<?php
						}
						?>
						<div class="sr-nexus-logo">
							<a href="<?php echo isset( $this->data['nav_urls']['mainpage']['href'] ) ? htmlspecialchars( $this->data['nav_urls']['mainpage']['href'] ) : '/'; ?>">
								<div class="sr-nexus-logo-image"></div>
								<div class="sr-nexus-sitename"><?php $this->msg( 'sitetitle' ); ?></div>
							</a>
						</div>
					</div>
					<div class="sr-nexus-header-tools">
						<div class="sr-nexus-search">
							<form action="<?php $this->text( 'wgScript' ); ?>" id="sr-nexus-searchform">
								<?php
								echo $this->makeSearchInput( [ 'id' => 'sr-nexus-searchInput', 'class' => 'sr-nexus-search-input' ] );
								echo $this->makeSearchButton( 'go', [ 'id' => 'sr-nexus-searchButton', 'class' => 'sr-nexus-search-button' ] );
								?>
							</form>
						</div>
						<div class="sr-nexus-user-tools">
							<?php $this->renderPersonalTools(); ?>
						</div>
					</div>
				</div>
				<nav id="sr-nexus-navigation">
					<div class="sr-nexus-nav-inner">
						<div class="sr-nexus-nav-main">
							<?php $this->renderNavigation( 'MAIN' ); ?>
						</div>
						<div class="sr-nexus-nav-actions">
							<?php $this->renderNavigation( [ 'VIEWS', 'ACTIONS' ] ); ?>
						</div>
					</div>
				</nav>
			</header>
			<div id="sr-nexus-content-wrapper">
				<div id="sr-nexus-content" class="sr-nexus-content">
					<div id="sr-nexus-body" class="sr-nexus-body">
						<?php if ( isset( $this->data['sitenotice'] ) && $this->data['sitenotice'] ) { ?>
							<div id="siteNotice"><?php $this->html( 'sitenotice' ); ?></div>
						<?php } ?>
						<div class="sr-nexus-page-header">
							<h1 id="firstHeading" class="firstHeading">
								<?php $this->html( 'title' ); ?>
							</h1>
							<?php if ( isset( $this->data['subtitle'] ) && $this->data['subtitle'] ) { ?>
								<div id="contentSub"><?php $this->html( 'subtitle' ); ?></div>
							<?php } ?>
							<?php if ( isset( $this->data['undelete'] ) && $this->data['undelete'] ) { ?>
								<div id="contentSub2"><?php $this->html( 'undelete' ); ?></div>
							<?php } ?>
						</div>
						<div id="bodyContent" class="sr-nexus-body-content">
							<?php 
							// Make sure we're outputting the body content
							if ( isset( $this->data['bodycontent'] ) ) {
								$this->html( 'bodycontent' );
							} else {
								echo '<div class="error">Page content not found</div>';
								// For debugging - uncomment to see what data is available
								echo '<pre>Available data keys: ' . htmlspecialchars(implode(', ', array_keys($this->data))) . '</pre>';
							}
							?>
							<?php if ( isset( $this->data['printfooter'] ) && $this->data['printfooter'] ) { ?>
								<div class="printfooter"><?php $this->html( 'printfooter' ); ?></div>
							<?php } ?>
							<?php if ( isset( $this->data['catlinks'] ) && $this->data['catlinks'] ) { ?>
								<?php $this->html( 'catlinks' ); ?>
							<?php } ?>
							<?php if ( isset( $this->data['dataAfterContent'] ) && $this->data['dataAfterContent'] ) { ?>
								<?php $this->html( 'dataAfterContent' ); ?>
							<?php } ?>
						</div>
					</div>
				</div>
				<div id="sr-nexus-sidebar" class="sr-nexus-sidebar">
					<div class="sr-nexus-sidebar-inner">
						<div class="sr-nexus-sidebar-tools">
							<?php 
							if ( isset( $this->data['sidebar'] ) && is_array( $this->data['sidebar'] ) ) {
								$this->renderPortals( $this->data['sidebar'] );
							}
							?>
						</div>
					</div>
				</div>
			</div>
			<footer id="sr-nexus-footer" class="sr-nexus-footer">
				<div class="sr-nexus-footer-inner">
					<div class="sr-nexus-footer-info">
						<?php 
						$footerLinks = $this->getFooterLinks();
						if ( is_array( $footerLinks ) ) {
							foreach ( $footerLinks as $category => $links ) {
								if ( is_array( $links ) ) {
						?>
							<ul id="sr-nexus-footer-<?php echo $category; ?>">
								<?php foreach ( $links as $link ) { ?>
									<li id="sr-nexus-footer-<?php echo $link; ?>"><?php $this->html( $link ); ?></li>
								<?php } ?>
							</ul>
						<?php 
								}
							}
						}
						?>
					</div>
					<div class="sr-nexus-footer-icons">
						<?php 
						$footerIcons = $this->getFooterIcons( 'icononly' );
						if ( is_array( $footerIcons ) ) {
							foreach ( $footerIcons as $blockName => $icons ) {
								if ( is_array( $icons ) ) {
						?>
							<div id="sr-nexus-footer-<?php echo htmlspecialchars( $blockName ); ?>">
								<?php foreach ( $icons as $icon ) { ?>
									<?php echo $this->getSkin()->makeFooterIcon( $icon ); ?>
								<?php } ?>
							</div>
						<?php 
								}
							}
						}
						?>
					</div>
				</div>
			</footer>
		</div>
		<?php 
		// Output the closing body and html elements
		echo $this->get( 'debughtml' );
		echo $this->get( 'reporttime' );
		echo $this->get( 'bottomscripts' );
		echo '</body>';
		echo '</html>';
	}

	/**
	 * Render a series of portals
	 *
	 * @param array $portals
	 */
	protected function renderPortals( $portals ) {
		// Force the rendering of the following portals
		if ( !isset( $portals['SEARCH'] ) ) {
			$portals['SEARCH'] = true;
		}
		if ( !isset( $portals['TOOLBOX'] ) ) {
			$portals['TOOLBOX'] = true;
		}
		if ( !isset( $portals['LANGUAGES'] ) ) {
			$portals['LANGUAGES'] = true;
		}

		foreach ( $portals as $name => $content ) {
			if ( $content === false ) {
				continue;
			}

			// Numeric strings gets an integer when set as key, cast back
			$name = (string)$name;

			switch ( $name ) {
				case 'SEARCH':
					break;
				case 'TOOLBOX':
					$this->renderPortal( 'tb', $this->getToolbox(), 'toolbox', 'sr-nexus-toolbox' );
					break;
				case 'LANGUAGES':
					if ( isset( $this->data['language_urls'] ) && $this->data['language_urls'] !== false ) {
						$this->renderPortal( 'lang', $this->data['language_urls'], 'otherlanguages', 'sr-nexus-languages' );
					}
					break;
				default:
					$this->renderPortal( $name, $content );
					break;
			}
		}
	}

	/**
	 * @param string $name
	 * @param array $content
	 * @param null|string $msg
	 * @param null|string $hook
	 */
	protected function renderPortal( $name, $content, $msg = null, $hook = null ) {
		if ( $msg === null ) {
			$msg = $name;
		}
		$msgObj = wfMessage( $msg );
		$labelId = Sanitizer::escapeIdForAttribute( "p-$name-label" );
		?>
		<div class="sr-nexus-portal" role="navigation" id="<?php echo Sanitizer::escapeIdForAttribute( "p-$name" ); ?>"
			<?php echo Linker::tooltip( 'p-' . $name ); ?> aria-labelledby="<?php echo $labelId; ?>">
			<h3 id="<?php echo $labelId; ?>"><?php echo htmlspecialchars( $msgObj->exists() ? $msgObj->text() : $msg ); ?></h3>
			<div class="sr-nexus-portal-content">
				<?php if ( is_array( $content ) ) { ?>
					<ul>
						<?php foreach ( $content as $key => $val ) { ?>
							<?php echo $this->makeListItem( $key, $val ); ?>
						<?php } ?>
						<?php if ( $hook !== null ) {
							Hooks::run( $hook, [ &$this, true ] );
						} ?>
					</ul>
				<?php } else { ?>
					<?php echo $content; ?>
				<?php } ?>
			</div>
		</div>
		<?php
	}

	/**
	 * Render personal tools
	 */
	protected function renderPersonalTools() {
		?>
		<div class="sr-nexus-personal-tools">
			<ul>
				<?php 
				$personalTools = $this->getPersonalTools();
				if ( is_array( $personalTools ) ) {
					foreach ( $personalTools as $key => $item ) { 
				?>
					<?php echo $this->makeListItem( $key, $item ); ?>
				<?php 
					}
				}
				?>
			</ul>
		</div>
		<?php
	}

	/**
	 * Render navigation
	 *
	 * @param string|array $navGroups
	 */
	protected function renderNavigation( $navGroups ) {
		if ( !is_array( $navGroups ) ) {
			$navGroups = [ $navGroups ];
		}

		foreach ( $navGroups as $navGroup ) {
			if ( isset( $this->data['nav_urls'][$navGroup] ) && is_array( $this->data['nav_urls'][$navGroup] ) ) {
				?>
				<ul class="sr-nexus-nav-group sr-nexus-nav-<?php echo strtolower( $navGroup ); ?>">
					<?php foreach ( $this->data['nav_urls'][$navGroup] as $navItem ) { ?>
						<?php if ( isset( $navItem['text'] ) ) { ?>
							<li<?php echo isset( $navItem['attributes'] ) ? $navItem['attributes'] : ''; ?>><a href="<?php echo htmlspecialchars( $navItem['href'] ) ?>"<?php echo isset( $navItem['key'] ) ? $navItem['key'] : ''; ?>><?php echo htmlspecialchars( $navItem['text'] ) ?></a></li>
						<?php } ?>
					<?php } ?>
				</ul>
				<?php
			} else {
				$navigation = isset( $this->data['sidebar'][$navGroup] ) ? $this->data['sidebar'][$navGroup] : [];
				if ( is_array( $navigation ) && !empty( $navigation ) ) {
				?>
				<ul class="sr-nexus-nav-group sr-nexus-nav-<?php echo strtolower( $navGroup ); ?>">
					<?php foreach ( $navigation as $navItem ) { ?>
						<?php echo $this->makeListItem( isset( $navItem['id'] ) ? $navItem['id'] : null, $navItem ); ?>
					<?php } ?>
				</ul>
				<?php
				}
			}
		}
	}
}

