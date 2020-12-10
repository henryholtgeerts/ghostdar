<?php

namespace Ghostdar\Ghosts;

use Ghostdar\Ghosts\Model as Ghost;

class Controller
{
    public function handleInsert (\WP_Post $post, \WP_REST_Request $request, bool $update)
    {
        $attrs = $this->getGhostAttributesFromPost($post);
        if ( empty($attrs['id']) ) {
            $ghost = Ghost::create($attrs);
            error_log('created ghost! ' . $ghost->id);
            update_post_meta($post->ID, 'ghostdar_ghost_id', $ghost->id);
        } else {
            $ghost = Ghost::get($attrs['id']);
            if ( $ghost ) {
                foreach ( $attrs as $key => $value ) {
                    $ghost->{$key} = $value;
                }
                $ghost->save();
            }
        }
    }

    public function handleTrash ( int $postId )
    {
        $ghost = Ghost::get_one_by_post_id($postId);
        if ($ghost) {
            $ghost->is_public = false;
            $ghost->save();
        }
    }

    public function handleUntrash ( int $postId )
    {
        $ghost = Ghost::get_one_by_post_id($postId);
        if ($ghost) {
            $ghost->is_public = true;
            $ghost->save();
        }
    }

    public function handleDelete ( int $postId, \WP_Post $post )
    {
        if ( $post->post_type !== 'ghostdar-ghost' ) {
            return;
        }
        $ghost = Ghost::get_one_by_post_id($postId);
        if ($ghost) {
            $ghost->delete();
        }
    }

    protected function getGhostAttributesFromPost (\WP_POST $post)
    {
        return [
            'post_id' => $post->ID,
            'name' => $post->post_title,
            'description' => $post->post_excerpt,
            'avatar_url' => get_the_post_thumbnail_url($post, [120, 120]),
            'first_seen' => $post->post_date_gmt,
            'id' => $post->ghostdar_ghost_id,
            'is_public' => $post->post_status === 'publish' ? true : false,
        ];
    }
}