<?php

namespace Ghostdar\Sightings;

use Ghostdar\Framework\Abstracts\PostType as PostTypeAbstract;

class PostType extends PostTypeAbstract
{
    public function getSlug ()
    {
        return 'sighting';
    }

    public function getSingularName ()
    {
        return 'Sighting';
    }

    public function getPluralName ()
    {
        return 'Sightings';
    }

    public function registerMeta ()
    {
        $metaKeys = [
            'id',
            'ghost_id',
            'latitude',
            'longitude',
        ];

        foreach ($metaKeys as $key) {
            register_post_meta( 'ghostdar-chapter', "ghostdar_ghost_{$key}", [
                'single' => true,
                'show_in_rest' => true,
                'type' => 'string',
                'default' => ''
            ] );
        }
    }
}