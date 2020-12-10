<?php

namespace Ghostdar\Chapters;

use Ghostdar\Framework\Helpers\Hooks;
use Ghostdar\Framework\Abstracts\ServiceProvider as ServiceProviderInterface;
use Ghostdar\Chapters\PostType as ChapterPostType;
use Ghostdar\Chapters\Controller as ChapterController;
use Ghostdar\Chapters\Migrations\CreateChaptersTable;

use Ghostdar\Framework\Migrations\Register as MigrationsRegister;

class ServiceProvider implements ServiceProviderInterface {

	/**
	 * @inheritDoc
	 */
	public function register() {
		ghostdar()->singleton( ChapterPostType::class );
		ghostdar()->singleton( ChapterController::class );
	}

	/**
	 * @inheritDoc
	 */
	public function boot() {
		$this->registerMigrations();

		Hooks::addAction( 'init', ChapterPostType::class, 'registerPostType' );
		Hooks::addAction( 'init', ChapterPostType::class, 'registerMeta' );
		Hooks::addAction( 'rest_after_insert_ghostdar-chapter', ChapterController::class, 'handleInsert', 10, 3 );
		Hooks::addAction( 'delete_post', ChapterController::class, 'handleDelete', 10, 2 );
		Hooks::addAction( 'wp_trash_post', ChapterController::class, 'handleTrash', 10, 1 );
		Hooks::addAction( 'untrash_post', ChapterController::class, 'handleUntrash', 10, 1 );
	}

	/**
	 * Registers database migrations with the MigrationsRunner
	 */
	private function registerMigrations() {
		$register = ghostdar( MigrationsRegister::class );
		$register->addMigration( CreateChaptersTable::class );
	}
}
