<?php

namespace Ghostdar\Sightings\Blocks;

use Ghostdar\Framework\Abstracts\Block as BlockAbstract;

class SightingBlock extends BlockAbstract {

    public function getSlug ()
    {
        return 'sighting';
    }

    public function renderCallback ( $attributes, $content )
    {
        return $this->getOutput();
    }

    public function getAttributes ()
    {
        return null;
    }

    /**
	 * Get output markup for Section
	 *
	 * @return string
	 * @since 2.9.0
	 **/
	public function getOutput() {
		ob_start();
		$output = '';
		require $this->getTemplatePath();
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
    }
    
    /**
	 * Get template path for Sighting Block template
	 * @since 2.9.0
	 **/
	public function getTemplatePath() {
		return GHOSTDAR_PLUGIN_DIR . '/src/Sightings/resources/views/sighting.php';
	}

}