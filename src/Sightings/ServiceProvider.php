<?php

namespace Ghostdar\Sightings;

use Ghostdar\Framework\Helpers\Hooks;
use Ghostdar\Framework\Abstracts\ServiceProvider as ServiceProviderInterface;
use Ghostdar\Sightings\PostType as SightingPostType;
use Ghostdar\Sightings\Controller as SightingController;
use Ghostdar\Sightings\Migrations\CreateSightingsTable;

use Ghostdar\Framework\Migrations\Register as MigrationsRegister;

class ServiceProvider implements ServiceProviderInterface {

	/**
	 * @inheritDoc
	 */
	public function register() {
		ghostdar()->singleton( SightingPostType::class );
		ghostdar()->singleton( SightingController::class );
	}

	/**
	 * @inheritDoc
	 */
	public function boot() {
		$this->registerMigrations();

		Hooks::addAction( 'init', SightingPostType::class, 'registerPostType' );
		Hooks::addAction( 'init', SightingPostType::class, 'registerMeta' );
		Hooks::addAction( 'rest_after_insert_ghostdar-sighting', SightingController::class, 'handleInsert', 10, 3 );
		Hooks::addAction( 'delete_post', SightingController::class, 'handleDelete', 10, 2 );
		Hooks::addAction( 'wp_trash_post', SightingController::class, 'handleTrash', 10, 1 );
		Hooks::addAction( 'untrash_post', SightingController::class, 'handleUntrash', 10, 1 );
	}

	/**
	 * Registers database migrations with the MigrationsRunner
	 */
	private function registerMigrations() {
		$register = ghostdar( MigrationsRegister::class );
		$register->addMigration( CreateSightingsTable::class );
	}
}
