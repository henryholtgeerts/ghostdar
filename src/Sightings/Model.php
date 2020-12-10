<?php

namespace Ghostdar\Sightings;

use Ghostdar\Framework\Abstracts\ActiveRecord;

class Model extends ActiveRecord
{
    protected static $tableName = 'ghostdar_sightings';

    protected static $casts = [
        'post_id' => 'int',
        'name' => 'string',
        'description' => 'string',
        'evidence_url' => 'string',
        'seen' => 'string',
        'ghost_id' => 'int',
        'latitude' => 'float',
        'longitude' => 'float',
        'is_public' => 'boolean',
    ];
}