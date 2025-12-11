<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Activity extends Model
{
    protected $table = 'activity_log';

    /**
     * Casts for JSON / datetime columns.
     */
    protected $fillable = [
        'log_name',
        'description',
        'causer_type',
        'causer_id',
        'subject_type',
        'subject_id',
        'properties',
    ];

    // If 'properties' is JSON, cast it
    protected $casts = [
        'properties' => 'array',
    ];

    /**
     * Example relationship: the user who caused the activity.
     */
    public function causer(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Example relationship: the model this activity is about.
     */
    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Scope: latest first.
     */
    public function scopeLatestFirst($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function getReadableCauserAttribute()
    {
        if ($this->relationLoaded('causer')) {
             return $this->causer->name ?? ($this->causer_type . ' #' . $this->causer_id);
        }
        return $this->causer_type . ' #' . $this->causer_id;
    }

    public function getReadableSubjectAttribute()
    {
        $modelName = class_basename($this->subject_type);
        return "{$modelName} #{$this->subject_id}";
    }

    public function getReadableChangesAttribute()
    {
        $old     = $this->properties['old_values'] ?? [];
        $new     = $this->properties['new_values'] ?? [];
        $changes = [];

        $modelName = class_basename($this->subject_type);
        $excludeFields = ['created_at', 'updated_at', 'deleted_at', 'password'];

        if (\Illuminate\Support\Str::contains(strtolower($this->description), 'created')) {
            foreach ($new as $key => $value) {
                if (in_array($key, $excludeFields)) continue;
                if ($value === null || $value === '' || (is_array($value) && empty($value))) continue;
                if (is_array($value)) $value = implode(', ', $value);
                $changes[] = ucfirst(str_replace('_', ' ', $key)) . ": " . $value;
            }
            if (!empty($changes)) {
                array_unshift($changes, "New {$modelName} created");
            } else {
                $changes[] = "New {$modelName} created (no details filled)";
            }
        } elseif (\Illuminate\Support\Str::contains(strtolower($this->description), 'updated')) {
            foreach ($new as $key => $value) {
                if (in_array($key, $excludeFields)) continue;
                $oldValue = $old[$key] ?? null;
                if ($oldValue != $value) {
                    if (is_array($value)) {
                        $value    = implode(', ', $value);
                        $oldValue = is_array($oldValue) ? implode(', ', $oldValue) : $oldValue;
                    }
                    $changes[] = ucfirst(str_replace('_', ' ', $key)) . " changed from '" . ($oldValue ?? '') . "' to '{$value}'";
                }
            }
        } elseif (\Illuminate\Support\Str::contains(strtolower($this->description), 'deleted')) {
            $changes[] = "{$modelName} deleted: #" . ($this->subject_id ?? '-');
        }

        return $changes;
    }
}
