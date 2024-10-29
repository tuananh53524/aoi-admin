<?php

namespace App\Traits;

trait ExcelConfigurable
{
    protected array $columns = [];
    protected array $columnFormats = [];
    protected array $columnWidths = [];
    protected bool $shouldAutoSize = true;
    protected array $callbacks = [];

    public function configureColumns(array $columns): self
    {
        $this->columns = $columns;
        return $this;
    }

    public function setColumnFormats(array $formats): self
    {
        $this->columnFormats = $formats;
        return $this;
    }

    public function setColumnWidths(array $widths): self
    {
        $this->columnWidths = $widths;
        return $this;
    }

    public function disableAutoSize(): self
    {
        $this->shouldAutoSize = false;
        return $this;
    }

    public function registerCallback(string $event, callable $callback): self
    {
        $this->callbacks[$event] = $callback;
        return $this;
    }
}
