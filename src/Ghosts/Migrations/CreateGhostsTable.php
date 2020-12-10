<?php

namespace Ghostdar\Ghosts\Migrations;

use Ghostdar\Framework\Abstracts\Migration;
use Ghostdar\Framework\Helpers\Table;

class CreateGhostsTable extends Migration {
	/**
	 * @inheritDoc
	 *
	 * @since 2.9.0
	 */
	public static function id() {
		return 'create_ghosts_table';
	}

	/**
	 * @inheritDoc
	 *
	 * @since 2.9.0
	 */
	public static function timestamp() {
		return strtotime( '2020-12-10' );
	}

	/**
	 * @inheritDoc
	 *
	 * @since 2.9.0
	 */
	public function run() {		
		global $wpdb;

		$charset_collate     = $wpdb->get_charset_collate();
		$tableName           = "{$wpdb->prefix}ghostdar_ghosts";
		$referencedTableName = "{$wpdb->prefix}posts";

		$sql = "CREATE TABLE {$tableName} (
  			id bigint UNSIGNED NOT NULL AUTO_INCREMENT,
			post_id bigint UNSIGNED NOT NULL,
			name varchar(55) NOT NULL,
			description varchar(55) NOT NULL,
			avatar_url varchar(255) NOT NULL,
			first_seen datetime NOT NULL,
			is_public boolean NOT NULL,
  			PRIMARY KEY (id)
		) {$charset_collate};";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );
	}
}
