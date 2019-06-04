<?php
/**
 * Created by PhpStorm.
 * User: Pietro Falco
 * Date: 25/01/2018
 * Time: 10:00
 */

namespace UdyWfToWp\Plugins\ContentManager\Models\Query;

abstract class Query implements IQuery {

	abstract public function __construct( $query_meta );

	public static final function factory( $subject, $query_meta ) {

		$class = "\\" . __NAMESPACE__ . "\Query_" . $subject;

		$class_file = str_replace( '_', '-', $subject );

		if ( ! file_exists( plugin_dir_path( __FILE__ ) . "/class-query-$class_file.php" ) ) {
			return false;
		}

		return new $class($query_meta);

	}

}

interface IQuery {

	static function factory( $subject, $query_meta );

	public function find_matching_items( $search_term );

	public function get_matched_items($items, $key = null);

}