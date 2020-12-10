<?php

namespace Ghostdar\Sightings;

use Ghostdar\Sightings\Model as Sighting;

class Controller
{
    public function handleInsert (\WP_Post $post, \WP_REST_Request $request, bool $update)
    {
        $attrs = $this->getSightingAttributesFromPost($post);
        if ( empty($attrs['id']) ) {
            $sighting = Sighting::create($attrs);
            update_post_meta($post->ID, 'ghostdar_sighting_id', $sighting->id);
        } else {
            $sighting = Sighting::get($attrs['id']);
            if ( $sighting ) {
                foreach ( $attrs as $key => $value ) {
                    $sighting->{$key} = $value;
                }
                $sighting->save();
            }
        }
    }

    public function handleTrash ( int $postId )
    {
        $sighting = Sighting::get_one_by_post_id($postId);
        if ($sighting) {
            $sighting->is_public = false;
            $sighting->save();
        }
    }

    public function handleUntrash ( int $postId )
    {
        $sighting = Sighting::get_one_by_post_id($postId);
        if ($sighting) {
            $sighting->is_public = true;
            $sighting->save();
        }
    }

    public function handleDelete ( int $postId, \WP_Post $post )
    {
        if ( $post->post_type !== 'ghostdar-sighting' ) {
            return;
        }
        $sighting = Sighting::get_one_by_post_id($postId);
        if ($sighting) {
            $sighting->delete();
        }
    }

    protected function getSightingAttributesFromPost (\WP_POST $post)
    {
        return [
            'post_id' => $post->ID,
            'name' => $post->post_title,
            'description' => $post->post_excerpt,
            'evidence_url' => get_the_post_thumbnail_url($post, 'medium'),
            'seen' => $post->post_date_gmt,
            'ghost_id' => $post->ghostdar_sighting_ghost_id,
            'latitude' => $post->ghostdar_sighting_latitude,
            'longitude' => $post->ghostdar_sighting_longitude,
            'id' => $post->ghostdar_sighting_id,
            'is_public' => $post->post_status === 'publish' ? true : false,
        ];
    }
}