<?php

namespace Ghostdar\Assets;

use Ghostdar\Framework\Helpers\Hooks;
use Ghostdar\Framework\Abstracts\ServiceProvider as ServiceProviderInterface;
use Ghostdar\Assets\Controller as AssetsController;

class ServiceProvider implements ServiceProviderInterface {

	/**
	 * @inheritDoc
	 */
	public function register() {
		ghostdar()->singleton( AssetsController::class );
	}

	/**
	 * @inheritDoc
	 */
	public function boot() {
        Hooks::addAction( 'wp_enqueue_scripts', AssetsController::class, 'loadFrontendAssets' );
        Hooks::addAction( 'admin_enqueue_scripts', AssetsController::class, 'loadAdminAssets' );
        Hooks::addAction( 'enqueue_block_editor_assets', AssetsController::class, 'loadEditorAssets' );
	}
}
