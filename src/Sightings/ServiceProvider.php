<?php

namespace Ghostdar\Sightings;

use Ghostdar\Framework\Helpers\Hooks;
use Ghostdar\Framework\Abstracts\ServiceProvider as ServiceProviderInterface;
use Ghostdar\Sightings\PostType as SightingPostType;
use Ghostdar\Sightings\Controller as SightingController;
use Ghostdar\Sightings\Blocks\SightingBlock as SightingBlock;
use Ghostdar\Sightings\Blocks\SightingsMapBlock as SightingsMapBlock;
use Ghostdar\Sightings\Blocks\SubmissionFormBlock as SubmissionFormBlock;
use Ghostdar\Sightings\Migrations\CreateSightingsTable;

use Ghostdar\Framework\Migrations\Register as MigrationsRegister;

class ServiceProvider implements ServiceProviderInterface {

	/**
	 * @inheritDoc
	 */
	public function register() {
		ghostdar()->singleton( SightingPostType::class );
		ghostdar()->singleton( SightingController::class );

		if ( function_exists( 'register_block_type' ) ) {
			ghostdar()->singleton( SightingBlock::class );
			ghostdar()->singleton( SightingsMapBlock::class );
			ghostdar()->singleton( SubmissionFormBlock::class );
		}
	}

	/**
	 * @inheritDoc
	 */
	public function boot() {
		$this->registerMigrations();

		Hooks::addAction( 'init', SightingPostType::class, 'registerPostType' );
		Hooks::addAction( 'init', SightingPostType::class, 'registerMeta' );
		Hooks::addAction( 'wp_insert_post', SightingController::class, 'handleInsert', 10, 3 );
		Hooks::addAction( 'delete_post', SightingController::class, 'handleDelete', 10, 2 );
		Hooks::addAction( 'wp_trash_post', SightingController::class, 'handleTrash', 10, 1 );
		Hooks::addAction( 'untrash_post', SightingController::class, 'handleUntrash', 10, 1 );

		if ( function_exists( 'register_block_type' ) ) {
			Hooks::addAction( 'init', SightingBlock::class, 'registerBlock' );
			Hooks::addAction( 'init', SightingsMapBlock::class, 'registerBlock' );
			Hooks::addAction( 'init', SubmissionFormBlock::class, 'registerBlock' );
		}
	}

	/**
	 * Registers database migrations with the MigrationsRunner
	 */
	private function registerMigrations() {
		$register = ghostdar( MigrationsRegister::class );
		$register->addMigration( CreateSightingsTable::class );
	}
}
