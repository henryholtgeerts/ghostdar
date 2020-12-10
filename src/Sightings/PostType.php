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

    protected function getArgs ()
    {
        $args = [
            'template' => [
                [
                    'ghostdar/sighting'
                ]
            ],
            'template_lock' => 'all'
        ];
        return array_merge($this->getDefaultArgs(), $args);
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
            register_post_meta( 'ghostdar-sighting', "ghostdar_sighting_{$key}", [
                'single' => true,
                'show_in_rest' => true,
                'type' => 'string',
                'default' => ''
            ] );
        }
    }
}