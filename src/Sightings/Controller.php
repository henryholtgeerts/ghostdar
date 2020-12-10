<?php

namespace Ghostdar\Chapters;

use Ghostdar\Chapters\Model as Chapter;

class Controller
{
    public function handleInsert (\WP_Post $post, \WP_REST_Request $request, bool $update)
    {
        $attrs = $this->getChapterAttributesFromPost($post);
        if ( empty($attrs['id']) ) {
            $chapter = Chapter::create([
                'post_id' => $attrs['post_id'],
                'name'=> $attrs['name'],
                'description'=> $attrs['description'],
                'latitude'=> $attrs['latitude'],
                'longitude'=> $attrs['longitude'],
                'radius'=> $attrs['radius'],
                'is_public' => $attrs['is_public'],
            ]);
            update_post_meta($post->ID, 'ghostdar_chapter_id', $chapter->id);
        } else {
            $chapter = Chapter::get($attrs['id']);
            $chapter->post_id = $attrs['post_id'];
            $chapter->name = $attrs['name'];
            $chapter->description = $attrs['description'];
            $chapter->latitude = $attrs['latitude'];
            $chapter->longitude = $attrs['longitude'];
            $chapter->radius = $attrs['radius'];
            $chapter->is_public = $attrs['is_public'];
            $chapter->save();
        }
    }

    public function handleTrash ( int $postId )
    {
        $chapter = Chapter::get_one_by_post_id($postId);
        if ($chapter) {
            $chapter->is_public = false;
            $chapter->save();
        }
    }

    public function handleUntrash ( int $postId )
    {
        $chapter = Chapter::get_one_by_post_id($postId);
        if ($chapter) {
            $chapter->is_public = true;
            $chapter->save();
        }
    }

    public function handleDelete ( int $postId, \WP_Post $post )
    {
        if ( $post->post_type !== 'ghostdar-chapter' ) {
            return;
        }
        $chapter = Chapter::get_one_by_post_id($postId);
        if ($chapter) {
            $chapter->delete();
        }
    }

    protected function getChapterAttributesFromPost (\WP_POST $post)
    {
        return [
            'post_id' => $post->ID,
            'longitude' => $post->ghostdar_chapter_longitude,
            'latitude' => $post->ghostdar_chapter_latitude,
            'radius' => $post->ghostdar_chapter_radius,
            'name' => $post->post_title,
            'description' => $post->post_excerpt,
            'id' => $post->ghostdar_chapter_id,
            'is_public' => $post->post_status === 'publish' ? true : false,
        ];
    }
}