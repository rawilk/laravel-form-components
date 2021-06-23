<?php

namespace Rawilk\FormComponents\Concerns;

trait AcceptsFiles
{
    /*
     * If specified, the component will fill out the "accept" property depending on
     * which type is requested.
     */
    public null|string $type;

    public function accepts(): null|string
    {
        return match ($this->type) {
            'audio' => 'audio/*',
            'image' => 'image/*',
            'video' => 'video/*',
            'pdf' => '.pdf',
            'csv' => '.csv',
            'spreadsheet', 'excel' => '.csv,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'text' => 'text/plain',
            'html' => 'text/html',
            default => null,
        };
    }
}
