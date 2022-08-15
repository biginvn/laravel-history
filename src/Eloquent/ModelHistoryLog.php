<?php

namespace Biginvn\History\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Biginvn\History\Traits\DetectionTrait;

abstract class ModelHistoryLog extends Model
{
    use DetectionTrait;

    /**
     * Create a new Eloquent model instance.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }
}
