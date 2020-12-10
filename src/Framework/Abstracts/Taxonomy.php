<?php

namespace Ghostdar\Framework\Abstracts;

abstract class Taxonomy
{
    abstract function getSlug();
    abstract function getSingularName();
    abstract function getPluralName();
    abstract function getObjectTypes();
    abstract function getRelationshipType();

    private function getDefaultLabels ()
    {
        return [
            'name'                  => _x( $this->getPluralName(), 'Post type general name', 'ghostdar' ),
            'singular_name'         => _x( $this->getSingularName(), 'Post type singular name', 'ghostdar' ),
            'menu_name'             => _x( $this->getPluralName(), 'Admin Menu text', 'ghostdar' ),
            'name_admin_bar'        => _x( $this->getSingularName(), 'Add New on Toolbar', 'ghostdar' ),
        ];
    }

    private function getDefaultArgs ()
    {
        return [
            'hierarchical'      => false,
            'labels'            => $this->getLabels(),
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => [ 'slug' => $this->getSlug() ],
            'show_in_rest'      => true,
            'description'       => $this->getRelationshipType()
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

    public function registerTaxonomy ()
    {
        register_taxonomy( $this->getSlug(), $this->getObjectTypes(), $this->getArgs() );
    }
}