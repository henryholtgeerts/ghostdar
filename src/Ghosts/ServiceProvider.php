<?php

namespace Ghostdar\Ghosts;

use Ghostdar\Framework\Helpers\Hooks;
use Ghostdar\Framework\Abstracts\ServiceProvider as ServiceProviderInterface;
use Ghostdar\Ghosts\PostType as GhostPostType;
use Ghostdar\Ghosts\Controller as GhostController;
use Ghostdar\Ghosts\Migrations\CreateGhostsTable;

use Ghostdar\Framework\Migrations\Register as MigrationsRegister;

class ServiceProvider implements ServiceProviderInterface {

	/**
	 * @inheritDoc
	 */
	public function register() {
		ghostdar()->singleton( GhostPostType::class );
		ghostdar()->singleton( GhostController::class );
	}

	/**
	 * @inheritDoc
	 */
	public function boot() {
		$this->registerMigrations();

		Hooks::addAction( 'init', GhostPostType::class, 'registerPostType' );
		Hooks::addAction( 'init', GhostPostType::class, 'registerMeta' );
		Hooks::addAction( 'rest_after_insert_ghostdar-ghost', GhostController::class, 'handleInsert', 10, 3 );
		Hooks::addAction( 'delete_post', GhostController::class, 'handleDelete', 10, 2 );
		Hooks::addAction( 'wp_trash_post', GhostController::class, 'handleTrash', 10, 1 );
		Hooks::addAction( 'untrash_post', GhostController::class, 'handleUntrash', 10, 1 );
	}

	/**
	 * Registers database migrations with the MigrationsRunner
	 */
	private function registerMigrations() {
		$register = ghostdar( MigrationsRegister::class );
		$register->addMigration( CreateGhostsTable::class );
	}
}
