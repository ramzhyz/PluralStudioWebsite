<?php

namespace App\Exports;

use App\Models\Booking;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class BookingExport implements FromQuery, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    public function __construct(
        protected ?string $month = null,
        protected ?string $year = null,
        protected ?string $space_id = null,
    ) {}

    public function query()
    {
        $query = Booking::with('space')->orderBy('booking_date', 'asc');

        if ($this->year) {
            $query->whereYear('booking_date', $this->year);
        }
        if ($this->month) {
            $query->whereMonth('booking_date', $this->month);
        }
        if ($this->space_id) {
            $query->where('space_id', $this->space_id);
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'Invoice No',
            'Customer Name',
            'Email',
            'WhatsApp',
            'Space',
            'Booking Date',
            'Duration',
            'Add-On',
            'Notes',
            'Status',
            'Total Price (IDR)',
            'Submitted At',
        ];
    }

    public function map($booking): array
    {
        return [
            $booking->invoice_number ?? '-',
            $booking->name,
            $booking->email,
            $booking->whatsapp,
            $booking->space?->name ?? '-',
            Carbon::parse($booking->booking_date)->format('d M Y, H:i'),
            $booking->duration,
            $booking->addon ?? '-',
            $booking->notes ?? '-',
            strtoupper($booking->status),
            $booking->total_price ? number_format($booking->total_price, 0, ',', '.') : '-',
            Carbon::parse($booking->created_at)->format('d M Y'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '1a1a18']],
            ],
        ];
    }
}