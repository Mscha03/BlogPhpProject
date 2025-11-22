<?php

namespace App\Models;

use App\Entities\SettingEntity;

/**
 * Setting model
 *
 * Handles database operations for application settings
 */
final class Setting extends Model
{
    protected string $fileName = 'settings';
    protected string $entityClass = SettingEntity::class;
}