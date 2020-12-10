<?php

namespace Ghostdar\Ghosts;

use Ghostdar\Framework\Abstracts\PostType as PostTypeAbstract;

class PostType extends PostTypeAbstract
{
    public function getSlug ()
    {
        return 'ghost';
    }

    public function getSingularName ()
    {
        return 'Ghost';
    }

    public function getPluralName ()
    {
        return 'Ghosts';
    }

    public function registerMeta ()
    {
        $metaKeys = [
            'id',
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