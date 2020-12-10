<?php

namespace Ghostdar\Ghosts;

use Ghostdar\Framework\Abstracts\ActiveRecord;

class Model extends ActiveRecord
{
    protected static $tableName = 'ghostdar_ghosts';

    protected static $casts = [
        'post_id' => 'int',
        'name' => 'string',
        'description' => 'string',
        'avatar_url' => 'string',
        'first_seen' => 'datetime',
        'is_public' => 'boolean',
    ];
}