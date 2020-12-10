<?php

namespace Ghostdar\Chapters;

use WP_REST_Request;
use Ghostdar\Framework\Abstracts\Route as RouteAbstract;

class Route extends RouteAbstract
{

    public function getEndpoint () 
    {
        return 'chapters';
    }

	public function handleRequest( WP_REST_Request $request ) {
        return [
            'this' => 'is a test'
        ];
    }

	public function registerRoute() {
		register_rest_route(
			$this->getRoot(),
			$this->getEndpoint(),
			[
				[
					'methods'             => 'POST',
					'callback'            => [ $this, 'handleRequest' ],
					'permission_callback' => function() {
						return current_user_can( 'manage_options' );
					},
					'args'                => [
						'action' => [
							'type'              => 'string',
							'required'          => false,
							//'validate_callback' => [ $this, 'validateCallback' ],
							'sanitize_callback' => [ $this, 'sanitizeTextOrArray' ],
						],
						'payload' => [
							'type'              => 'array',
							'required'          => false,
							//'validate_callback' => [ $this, 'validateCallback' ],
							'sanitize_callback' => [ $this, 'sanitizeTextOrArray' ],
						]
					],
				],
				'schema' => [ $this, 'getSchema' ],
			]
		);
	}

	public function validateCallback() {

	}

	public function sanitizeTextOrArray( $var ) {
		if( is_string($var) ){
			$var = sanitize_text_field($var);
		} elseif ( is_array($var) ) {
			foreach ( $var as $key => &$value ) {
				if ( is_array( $value ) ) {
					$value = $this->sanitizeTextOrArray($value);
				}
				else {
					$value = sanitize_text_field( $value );
				}
			}
		}
		return $var;
	}

	public function getSchema() {
		return [
			// This tells the spec of JSON Schema we are using which is draft 4.
			'$schema'    => 'http://json-schema.org/draft-04/schema#',
			// The title property marks the identity of the resource.
			'title'      => 'chapters',
			'type'       => 'object',
			// In JSON Schema you can specify object properties in the properties attribute.
			'properties' => [
				'setting' => [
					'description' => esc_html__( 'The reference name for the setting being updated.', 'give' ),
					'type'        => 'string',
				],
				'value'   => [
					'description' => esc_html__( 'The value of the setting being updated.', 'give' ),
					'type'        => 'string',
				],
			],
		];
	}
}
