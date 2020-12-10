<?php

namespace Ghostdar\Framework\Abstracts;

abstract class PostType
{
    abstract function getSlug();
    abstract function getSingularName();
    abstract function getPluralName();

    protected function getDefaultLabels () 
    {
        return [
            'name'                  => _x( $this->getPluralName(), 'Post type general name', 'ghostdar' ),
            'singular_name'         => _x( $this->getSingularName(), 'Post type singular name', 'ghostdar' ),
            'menu_name'             => _x( $this->getPluralName(), 'Admin Menu text', 'ghostdar' ),
            'name_admin_bar'        => _x( $this->getSingularName(), 'Add New on Toolbar', 'ghostdar' ),
        ];
    }

    protected function getDefaultArgs ()
    {
        return [
            'labels'             => $this->getLabels(),
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => [ 'slug' => $this->getSlug() ],
            'capability_type'    => 'post',
            'has_archive'        => true,
            'show_in_rest'       => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => $this->getSupports(),
        ];
    }

    protected function getDefaultSupports ()
    {
        return [
            'title',
            'editor',
            'author',
            'thumbnail',
            'excerpt',
            'comments',
            'custom-fields'
        ];
    }

    protected function getArgs ()
    {
        return $this->getDefaultArgs();
    }

    protected function getLabels ()
    {
        return $this->getDefaultLabels();
    }

    protected function getSupports ()
    {
        return $this->getDefaultSupports();
    }

    public function registerPostType ()
    {
        register_post_type( "ghostdar-{$this->getSlug()}", $this->getArgs() );
    }
}