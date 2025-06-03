<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'description'
    ];

    /**
     * Get setting value by key
     */
    public static function get($key, $default = null)
    {
        $setting = self::where('key', $key)->first();

        if (!$setting) {
            return $default;
        }

        // Cast based on type
        switch ($setting->type) {
            case 'boolean':
                return (bool) $setting->value;
            case 'integer':
                return (int) $setting->value;
            case 'json':
                return json_decode($setting->value, true);
            default:
                return $setting->value;
        }
    }

    /**
     * Set setting value
     */
    public static function set($key, $value, $type = 'text', $group = 'general')
    {
        // Convert value based on type
        if ($type === 'boolean') {
            $value = $value ? '1' : '0';
        } elseif ($type === 'json') {
            $value = json_encode($value);
        }

        return self::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'type' => $type,
                'group' => $group
            ]
        );
    }

    /**
     * Get all settings by group
     */
    public static function getGroup($group)
    {
        return self::where('group', $group)->pluck('value', 'key')->toArray();
    }

    /**
     * Get all settings as array
     */
    public static function getAll()
    {
        $settings = self::all();
        $result = [];

        foreach ($settings as $setting) {
            $result[$setting->key] = self::get($setting->key);
        }

        return $result;
    }
}
