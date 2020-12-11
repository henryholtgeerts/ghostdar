<?php

namespace Ghostdar\Sightings\Blocks;

use Ghostdar\Framework\Abstracts\Block as BlockAbstract;

class SubmissionFormBlock extends BlockAbstract {

    public function getSlug ()
    {
        return 'submission-form';
    }

    public function renderCallback ( $attributes, $content )
    {
        return $this->getOutput();
    }

    public function getAttributes ()
    {
        return [];
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
		return GHOSTDAR_PLUGIN_DIR . '/src/Sightings/resources/views/submission-form.php';
	}

}