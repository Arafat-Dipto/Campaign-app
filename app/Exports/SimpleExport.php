<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class SimpleExport implements FromCollection, WithHeadings, WithTitle
{
	use Exportable;

	protected $data;
	protected $headings;
	protected $title;

	public function __construct(object $data, array $headings, string $title)
	{
		$this->data     = $data;
		$this->headings = $headings;
		$this->title    = $title;
	}

	public function collection()
	{
		return collect($this->data);
	}

	public function headings(): array
	{
		return $this->headings;
	}

	public function title(): string
	{
		return $this->title;
	}
}
