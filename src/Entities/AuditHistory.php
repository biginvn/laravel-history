<?php

namespace Biginvn\History\Entities;

use Illuminate\Database\Eloquent\Model;

class AuditHistory extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'audit_histories';

    protected $fillable = [
        'path',
        'target_type',
        'target_id',
        'author_id',
        'author_type',
        'type',
        'detail',
        'old_value',
        'new_value',
        'column',
        'table',
    ];
    /**
     * The date fields for the model.clear
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * __construct
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        if ($fillable = config('biginvn.history.history.fillable')) {
            $this->fillable = $fillable;
        }

        parent::__construct($attributes);
    }

    /**
     * Grab the revision history for the model that is calling
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function author()
    {
        return $this->morphTo();
    }

    /**
     * Grab the revision history for the model that is calling
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function target()
    {
        return $this->morphTo();
    }

    /**
     * getCreatedAtAttribute
     *
     * @param  $value
     * @return mixed
     */
    public function getCreatedAtAttribute($value)
    {
        return $value ? date(config('biginvn.history.history.format.datetime'), strtotime($value)) : '';
    }
}
