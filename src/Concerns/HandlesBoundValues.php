<?php

namespace Rawilk\FormComponents\Concerns;

use Rawilk\FormComponents\Support\FormDataBinder;

trait HandlesBoundValues
{
    /**
     * Get the latest bound target.
     *
     * @return mixed
     */
    private function getBoundTarget()
    {
        return $this->getFormDataBinder()->get();
    }

    /**
     * Get an item from the latest bound target.
     *
     * @param null|bool|mixed $bind
     * @param string $name
     * @return mixed
     */
    private function getBoundValue($bind = null, string $name = '')
    {
        if ($bind === false) {
            return null;
        }

        $bind = $bind ?: $this->getBoundTarget();

        return data_get($bind, $name);
    }

    private function getFormDataBinder(): FormDataBinder
    {
        return app(FormDataBinder::class);
    }
}
