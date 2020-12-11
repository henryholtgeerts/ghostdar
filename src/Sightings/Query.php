<?php

namespace Ghostdar\Sightings;

class Query
{
    public function byLocation($lat, $lng, $radius) 
    {
        global $wpdb;

		$sql = "
            SELECT id, ( 3959 * acos( cos( radians({$lat}) ) * cos( radians( latitude ) ) 
            * cos( radians( longitude ) - radians({$lng}) ) + sin( radians({$lat}) ) * sin(radians(latitude)) ) ) AS distance 
            FROM {$wpdb->ghostdar_sightings}
            HAVING distance < {$radius}
            ORDER BY distance 
        ";

		return $sql;
    }
}