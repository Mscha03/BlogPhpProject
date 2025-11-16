<?php

namespace App\Models;

use App\Entities\SettingEntity;

class Setting extends Model
{
    protected string $fileName = 'settings';
    protected string $entityClass = SettingEntity::class;
}