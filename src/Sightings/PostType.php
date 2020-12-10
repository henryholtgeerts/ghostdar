<?php

namespace Ghostdar\Chapters;

use Ghostdar\Framework\Abstracts\PostType as PostTypeAbstract;

class PostType extends PostTypeAbstract
{
    public function getSlug ()
    {
        return 'chapter';
    }

    public function getSingularName ()
    {
        return 'Chapter';
    }

    public function getPluralName ()
    {
        return 'Chapters';
    }

    public function registerMeta ()
    {
        $metaKeys = [
            'id',
            'longitude',
            'latitude',
            'radius',
        ];

        foreach ($metaKeys as $key) {
            register_post_meta( 'ghostdar-chapter', "ghostdar_chapter_{$key}", [
                'single' => true,
                'show_in_rest' => true,
                'type' => 'string',
                'default' => ''
            ] );
        }
    }
}