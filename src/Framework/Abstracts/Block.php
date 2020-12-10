<?php

namespace Ghostdar\Framework\Abstracts;

abstract class Block
{

    abstract function getSlug ();
    abstract function renderCallback ( $attributes, $content );
	abstract function getAttributes ();
	/**
	 * Registers block
	 *
	 * @since 2.9.0
	 **/
	public function registerBlock() {
		register_block_type(
			"ghostdar/{$this->getSlug()}",
			[
				'attributes' => $this->getAttributes(),
				'render_callback' => [ $this, 'renderCallback' ],
			]
		);
	}
}