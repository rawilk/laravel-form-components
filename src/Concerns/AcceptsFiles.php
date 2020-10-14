<?php

namespace Rawilk\FormComponents\Concerns;

trait AcceptsFiles
{
    /**
     * If specified, the component will fill out the "accept" property depending on
     * which type is requested.
     *
     * @var string
     */
    public $type;

    public function accepts(): ?string
    {
        if (! $this->type) {
            return null;
        }

        $excelTypes = '.csv,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';

        return [
            'audio' => 'audio/*',
            'image' => 'image/*',
            'video' => 'video/*',
            'pdf' => '.pdf',
            'csv' => '.csv',
            'spreadsheet' => $excelTypes,
            'excel' => $excelTypes,
            'text' => 'text/plain',
            'html' => 'text/html',
        ][$this->type] ?? null;
    }
}
