<?php
namespace Ghostdar\Framework\Migrations;

use Ghostdar\Framework\Migrations\Runner as MigrationsRunner;
use Ghostdar\Framework\Migrations\Register as MigrationsRegister;
use Ghostdar\Framework\Abstracts\ServiceProvider as ServiceProviderInterface;
use Ghostdar\Framework\Helpers\Hooks;

/**
 * Class DatabaseServiceProvider
 * @package Give\Framework\Migrations
 *
 * @since 2.9.0
 */
class ServiceProvider implements ServiceProviderInterface {
	/**
	 * @inheritdoc
	 */
	public function register() {
		ghostdar()->singleton( MigrationsRunner::class );
		ghostdar()->singleton( MigrationsRegister::class );
	}

	/**
	 * @inheritdoc
	 */
	public function boot() {
		Hooks::addAction( 'admin_init', MigrationsRunner::class, 'run', 0 );
		Hooks::addAction( 'ghostdar_upgrades', MigrationsRunner::class, 'run', 0 );
	}
}
