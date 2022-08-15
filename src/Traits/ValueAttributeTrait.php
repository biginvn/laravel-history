<?php

namespace Biginvn\History\Traits;

trait ValueAttributeTrait
{
    /**
     * @param mixed $attr
     * @return mixed
     */
    protected function getOriginalMutator($attr)
    {
        $origin = $this->getOriginal($attr);

        return ($this->hasGetMutator($attr))
            ? $this->mutateAttribute($attr, $origin)
            : $origin;
    }

    /**
     * @param mixed $attr
     * @param mixed $newValue
     * @return mixed
     */
    protected function getNewValueMutator($attr, $newValue)
    {
        return ($this->hasGetMutator($attr))
            ? $this->mutateAttribute($attr, $newValue)
            : $newValue;
    }

    /**
     * @param mixed $attr
     * @return mixed
     */
    protected function getHistoryDisplayAttribute($attr)
    {
        return array_get($this->displayAttributes, $attr) ?: ucwords(implode(' ', explode('_', $attr)));
    }

    /**
     * @return string
     */
    protected function getHistoryDisplayTable(): string
    {
        return config("biginvn.history.history.nameTables.{$this->getTable()}") ?: $this->getTable();
    }
}
