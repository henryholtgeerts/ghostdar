<?php

namespace Ghostdar\Assets;

/**
 * Handles Asset registration
 */

class Controller
{
    public function loadFrontendAssets ()
    {
        wp_enqueue_script( 
            'ghostdar-frontend', 
            GHOSTDAR_PLUGIN_URL . 'assets/dist/frontend.bundle.js',
            [], 
            GHOSTDAR_VERSION,
            true
        );
    }

    public function loadAdminAssets ()
    {
        wp_enqueue_script( 
            'ghostdar-admin', 
            GHOSTDAR_PLUGIN_URL . 'assets/dist/admin.bundle.js',
            [], 
            GHOSTDAR_VERSION,
            true
        );
    }

    public function loadEditorAssets ()
    {
        wp_enqueue_script( 
            'ghostdar-editor', 
            GHOSTDAR_PLUGIN_URL . 'assets/dist/editor.bundle.js',
            [], 
            GHOSTDAR_VERSION,
            true
        );
    }
}