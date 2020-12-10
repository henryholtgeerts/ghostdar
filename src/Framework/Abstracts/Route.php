<?php

namespace Ghostdar\Framework\Abstracts;

use WP_REST_Request;

/**
 * @since 2.8.0
 */
abstract class Route {

    abstract function getEndpoint ();
    
    abstract function registerRoute ();
    
    abstract function getSchema ();

	/**
	 * @param WP_REST_Request $request
	 *
	 * @return array
	 *
	 * @since 2.8.0
	 */
    abstract function handleRequest( WP_REST_Request $request );
    
    public function getRoot ()
    {
        return 'ghostdar/v2';
    }

}
