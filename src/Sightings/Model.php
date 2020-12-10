<?php

namespace Ghostdar\Chapters;

use Ghostdar\Framework\Abstracts\ActiveRecord;

class Model extends ActiveRecord
{
    protected static $tableName = 'ghostdar_chapters';

    protected static $casts = [
        'post_id' => 'int',
        'latitude' => 'float',
        'longitude' => 'float',
        'radius' => 'float',
        'name' => 'string',
        'description' => 'string',
        'created_at' => 'datetime',
        'is_public' => 'boolean',
    ];
}