<?php

namespace App\Filament\Resources\Bookings;

use App\Exports\BookingExport;
use App\Filament\Resources\Bookings\Pages;
use App\Models\Booking;
use App\Models\Space;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions\Action as TableAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;
use Maatwebsite\Excel\Facades\Excel;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationLabel = 'Bookings';
    protected static ?int $navigationSort = 1;

    // ── Helper: apakah field harus di-lock ──
    private static function isLocked($record): bool
    {
        $user = Auth::user();
        return $record?->status === 'completed' && !($user && $user->isSuperAdmin());
    }

    public static function form(Schema $form): Schema
    {
        return $form->schema([

            // ── BOOKING INFO ──
            Section::make('Booking Info')
                ->schema([
                    Select::make('space_id')
                        ->label('Space')
                        ->options(fn () => Space::all()->pluck('name', 'id')->toArray())
                        ->required()
                        ->disabled(fn ($record) => self::isLocked($record)),
                    TextInput::make('name')
                        ->label('Customer Name')
                        ->required()
                        ->disabled(fn ($record) => self::isLocked($record)),
                    TextInput::make('email')
                        ->email()
                        ->required()
                        ->disabled(fn ($record) => self::isLocked($record)),
                    TextInput::make('whatsapp')
                        ->label('WhatsApp')
                        ->required()
                        ->disabled(fn ($record) => self::isLocked($record)),
                    DateTimePicker::make('booking_date')
                        ->label('Booking Date & Time')
                        ->required()
                        ->disabled(fn ($record) => self::isLocked($record)),
                    TextInput::make('duration')
                        ->required()
                        ->disabled(fn ($record) => self::isLocked($record)),
                    Textarea::make('addon')
                        ->label('Add-On Request')
                        ->rows(3)
                        ->disabled(fn ($record) => self::isLocked($record)),
                    Textarea::make('notes')
                        ->rows(3)
                        ->disabled(fn ($record) => self::isLocked($record)),
                ])->columns(2),

            // ── STATUS & PAYMENT ──
            Section::make('Status & Payment')
                ->schema([
                    Select::make('status')
                        ->options([
                            'pending'      => 'Pending',
                            'contacted'    => 'Contacted',
                            'invoice_sent' => 'Invoice Sent',
                            'confirmed'    => 'Confirmed',
                            'checked_in'   => 'Checked In',
                            'completed'    => 'Completed',
                            'cancelled'    => 'Cancelled',
                        ])
                        ->default('contacted')
                        ->required()
                        ->disabled(fn ($record) => self::isLocked($record))
                        ->dehydrated()
                        ->hiddenOn('create'),
                    TextInput::make('total_price')
                        ->label('Total Price (IDR)')
                        ->numeric()
                        ->readOnly()
                        ->disabled(fn ($record) => self::isLocked($record))
                        ->hiddenOn('create'),
                    TextInput::make('invoice_number')
                        ->label('Invoice Number')
                        ->readOnly()
                        ->disabled(fn ($record) => self::isLocked($record))
                        ->hiddenOn('create'),
                    Placeholder::make('invoice_link')
                        ->label('Invoice PDF')
                        ->content(fn ($record) => $record?->invoice_path
                            ? new HtmlString('<a href="' . url('storage/' . $record->invoice_path) . '" target="_blank" style="color:#f59e0b; text-decoration:underline;">📄 View Invoice PDF</a>')
                            : '-'
                        )
                        ->hiddenOn('create'),
                    Placeholder::make('payment_proof_link')
                        ->label('Payment Proof')
                        ->content(fn ($record) => $record?->payment_proof_path
                            ? new HtmlString('<a href="' . url('storage/' . $record->payment_proof_path) . '" target="_blank" style="color:#f59e0b; text-decoration:underline;">🖼️ View Payment Proof</a>')
                            : '-'
                        )
                        ->hiddenOn('create'),
                ])->columns(2)
                ->hiddenOn('create'),

            // ── COMPLETION NOTES (admin bisa edit ini meski completed) ──
            Section::make('Completion Notes')
                ->schema([
                    Textarea::make('completion_notes')
                        ->label('General Notes / Kronologi')
                        ->placeholder('Contoh: Client extend 1 jam, bayar cash IDR 1.000.000. Beli kopi 2x IDR 100.000.')
                        ->rows(4),
                    Textarea::make('damage_notes')
                        ->label('Damage / Loss Notes')
                        ->placeholder('Contoh: Ada noda di cyclorama, dipotong dari deposit.')
                        ->rows(3),
                    TextInput::make('extra_time')
                        ->label('Extra Time (e.g. 1 Hour)'),
                    FileUpload::make('extra_payment_proof')
                        ->label('Bukti Pembayaran Tambahan')
                        ->image()
                        ->multiple()
                        ->directory('extra-payment-proofs')
                        ->disk('public')
                        ->reorderable()
                        ->helperText('Upload bukti transfer/foto pembayaran tambahan (kopi, overtime, dll)'),
                    Placeholder::make('extra_payment_links')
                        ->label('Lihat Bukti Pembayaran')
                        ->content(function ($record) {
                            if (!$record?->extra_payment_proof) return '-';
                            $links = collect($record->extra_payment_proof)
                                ->map(fn ($path) => '<a href="' . url('storage/' . $path) . '" target="_blank" style="color:#f59e0b; text-decoration:underline; margin-right:8px;">🖼️ Lihat</a>')
                                ->implode('');
                            return new HtmlString($links);
                        })
                        ->hiddenOn('create'),
                ])->columns(2)
                ->hiddenOn('create'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::Medium),
                Tables\Columns\TextColumn::make('space.name')
                    ->label('Space')
                    ->sortable(),
                Tables\Columns\TextColumn::make('booking_date')
                    ->label('Date & Time')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('duration')
                    ->label('Duration'),
                Tables\Columns\TextColumn::make('whatsapp')
                    ->label('WhatsApp'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending'      => 'warning',
                        'contacted'    => 'info',
                        'invoice_sent' => 'primary',
                        'confirmed'    => 'success',
                        'checked_in'   => 'success',
                        'completed'    => 'gray',
                        'cancelled'    => 'danger',
                        default        => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending'      => 'Pending',
                        'contacted'    => 'Contacted',
                        'invoice_sent' => 'Invoice Sent',
                        'confirmed'    => 'Confirmed',
                        'checked_in'   => 'Checked In',
                        'completed'    => 'Completed',
                        'cancelled'    => 'Cancelled',
                        default        => $state,
                    }),
                Tables\Columns\TextColumn::make('total_price')
                    ->label('Total')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('invoice_path')
                    ->label('Invoice')
                    ->formatStateUsing(fn ($state) => $state ? '📄 View' : '-')
                    ->url(fn ($record) => $record->invoice_path ? url('storage/' . $record->invoice_path) : null)
                    ->openUrlInNewTab(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Submitted')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending'      => 'Pending',
                        'contacted'    => 'Contacted',
                        'invoice_sent' => 'Invoice Sent',
                        'confirmed'    => 'Confirmed',
                        'checked_in'   => 'Checked In',
                        'completed'    => 'Completed',
                        'cancelled'    => 'Cancelled',
                    ]),
                Tables\Filters\SelectFilter::make('space_id')
                    ->label('Space')
                    ->options(fn () => Space::all()->pluck('name', 'id')->toArray()),
            ])
            ->headerActions([
                TableAction::make('export_excel')
                    ->label('Export Excel')
                    ->icon('heroicon-o-table-cells')
                    ->color('success')
                    ->form([
                        Select::make('year')
                            ->label('Year')
                            ->options(fn () => collect(range(now()->year, now()->year - 3))
                                ->mapWithKeys(fn ($y) => [$y => $y])->toArray())
                            ->default(now()->year),
                        Select::make('month')
                            ->label('Month')
                            ->options([
                                '1' => 'January',  '2' => 'February', '3' => 'March',
                                '4' => 'April',    '5' => 'May',      '6' => 'June',
                                '7' => 'July',     '8' => 'August',   '9' => 'September',
                                '10' => 'October', '11' => 'November','12' => 'December',
                            ])
                            ->placeholder('All months'),
                        Select::make('space_id')
                            ->label('Space')
                            ->options(fn () => Space::all()->pluck('name', 'id')->toArray())
                            ->placeholder('All spaces'),
                    ])
                    ->action(function (array $data) {
                        $month    = $data['month'] ?? null;
                        $year     = $data['year'] ?? null;
                        $spaceId  = $data['space_id'] ?? null;
                        $monthStr = $month ? Carbon::create()->month($month)->format('M') . '-' : '';
                        $filename = 'bookings-' . $monthStr . $year . '.xlsx';
                        return Excel::download(new BookingExport($month, $year, $spaceId), $filename);
                    }),

                TableAction::make('export_pdf')
                    ->label('Export PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('danger')
                    ->form([
                        Select::make('year')
                            ->label('Year')
                            ->options(fn () => collect(range(now()->year, now()->year - 3))
                                ->mapWithKeys(fn ($y) => [$y => $y])->toArray())
                            ->default(now()->year),
                        Select::make('month')
                            ->label('Month')
                            ->options([
                                '1' => 'January',  '2' => 'February', '3' => 'March',
                                '4' => 'April',    '5' => 'May',      '6' => 'June',
                                '7' => 'July',     '8' => 'August',   '9' => 'September',
                                '10' => 'October', '11' => 'November','12' => 'December',
                            ])
                            ->placeholder('All months'),
                        Select::make('space_id')
                            ->label('Space')
                            ->options(fn () => Space::all()->pluck('name', 'id')->toArray())
                            ->placeholder('All spaces'),
                    ])
                    ->action(function (array $data) {
                        $query = Booking::with('space')->orderBy('booking_date', 'asc');
                        if (!empty($data['year']))     $query->whereYear('booking_date', $data['year']);
                        if (!empty($data['month']))    $query->whereMonth('booking_date', $data['month']);
                        if (!empty($data['space_id'])) $query->where('space_id', $data['space_id']);

                        $bookings     = $query->get();
                        $totalRevenue = $bookings->whereNotNull('total_price')->sum('total_price');
                        $monthStr     = !empty($data['month']) ? Carbon::create()->month($data['month'])->format('F') . ' ' : '';
                        $period       = $monthStr . ($data['year'] ?? '');

                        $pdf      = Pdf::loadView('pdf.booking-report', compact('bookings', 'totalRevenue', 'period'))
                            ->setPaper('a4', 'landscape');
                        $filename = 'booking-report-' . str_replace(' ', '-', strtolower($period)) . '.pdf';
                        return response()->streamDownload(fn () => print($pdf->output()), $filename);
                    }),
            ])
            ->recordActions([
                Action::make('contacted')
                    ->label('Contacted')
                    ->icon('heroicon-o-phone')
                    ->color('info')
                    ->visible(fn (Booking $record): bool => $record->status === 'pending')
                    ->action(function (Booking $record): void {
                        $record->update(['status' => 'contacted']);
                        Notification::make()->title('Status updated to Contacted')->success()->send();
                    }),

                Action::make('send_invoice')
                    ->label('Send Invoice')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('primary')
                    ->visible(fn (Booking $record): bool => $record->status === 'contacted')
                    ->form([
                        TextInput::make('studio_rate')->label('Studio Rate (IDR)')->numeric()->default(0)->required(),
                        TextInput::make('studio_qty')->label('Quantity')->default(1)->required(),
                        Repeater::make('additional_charges')
                            ->label('Additional Charges')
                            ->schema([
                                TextInput::make('description')->label('Description')->required(),
                                TextInput::make('qty')->label('Qty')->default(1)->required(),
                                TextInput::make('rate')->label('Rate (IDR)')->numeric()->required(),
                            ])
                            ->default([])
                            ->columnSpanFull(),
                    ])
                    ->action(function (Booking $record, array $data): void {
                        $bookingCarbon = Carbon::parse($record->booking_date);
                        $durationHours = (int) filter_var($record->duration, FILTER_SANITIZE_NUMBER_INT);
                        $endTime       = $bookingCarbon->copy()->addHours($durationHours)->format('H:i A');
                        $bookingTime   = $bookingCarbon->format('H:i A') . ' - ' . $endTime;
                        $bookingDate   = $bookingCarbon->format('d F Y');

                        $spaceCodeMap  = ['sun-lounge' => 'SLG', 'lodge' => 'LDG', 'athletics' => 'ATC', 'cafe' => 'CFE', 'recovery' => 'RCY'];
                        $spaceCode     = $spaceCodeMap[$record->space?->slug] ?? 'PLR';
                        $baseInvoice   = $spaceCode . $bookingCarbon->format('dmY');
                        $existingCount = Booking::query()->where('invoice_number', 'like', $baseInvoice . '%')->where('id', '!=', $record->id)->count();
                        $invoiceNumber = $baseInvoice . '-' . ($existingCount + 1);

                        $studioAmount    = $data['studio_rate'] * $data['studio_qty'];
                        $additionalTotal = collect($data['additional_charges'])->sum(fn ($c) => $c['rate'] * $c['qty']);
                        foreach ($data['additional_charges'] as &$charge) {
                            $charge['amount'] = $charge['rate'] * $charge['qty'];
                        }
                        $grandTotal = $studioAmount + $additionalTotal;

                        $pdf = Pdf::loadView('pdf.invoice', [
                            'invoice_number'     => $invoiceNumber,
                            'invoice_date'       => now()->format('d F Y'),
                            'customer_name'      => $record->name,
                            'customer_email'     => $record->email,
                            'customer_whatsapp'  => $record->whatsapp,
                            'space_name'         => $record->space?->name,
                            'booking_day'        => $bookingCarbon->format('l'),
                            'booking_date'       => $bookingDate,
                            'booking_time'       => $bookingTime,
                            'studio_qty'         => $data['studio_qty'],
                            'studio_rate'        => $data['studio_rate'],
                            'studio_amount'      => $studioAmount,
                            'additional_charges' => $data['additional_charges'],
                            'subtotal'           => $grandTotal,
                            'grand_total'        => $grandTotal,
                        ])->setPaper('a4', 'portrait');

                        $filename = 'invoices/' . $record->name . '-' . $invoiceNumber . '.pdf';
                        Storage::disk('public')->put($filename, $pdf->output());
                        $record->update(['status' => 'invoice_sent', 'total_price' => $grandTotal, 'invoice_number' => $invoiceNumber, 'invoice_path' => $filename]);

                        $invoiceUrl = url('storage/' . $filename);
                        $message = "Halo *{$record->name}*! 👋\n\nBerikut invoice untuk booking kamu di *Plural Studio*:\n\n"
                            . "📋 *Invoice:* {$invoiceNumber}\n🏠 *Space:* {$record->space?->name}\n"
                            . "📅 *Tanggal:* {$bookingDate}\n⏱ *Waktu:* {$bookingTime}\n"
                            . "💰 *Grand Total:* IDR " . number_format($grandTotal, 0, ',', '.') . "\n\n"
                            . "📎 *Download Invoice:*\n{$invoiceUrl}\n\n"
                            . "Silakan lakukan pembayaran dan kirimkan bukti transfer ke kami.\n\nTerima kasih! 🙏\n_Plural Studio_";

                        Http::withHeaders(['Authorization' => config('fonnte.cs_token')])
                            ->post('https://api.fonnte.com/send', ['target' => $record->whatsapp, 'message' => $message]);

                        Notification::make()->title('Invoice #' . $invoiceNumber . ' sent to ' . $record->name)->success()->send();
                    }),

                Action::make('confirm')
                    ->label('Confirm Booking')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (Booking $record): bool => $record->status === 'invoice_sent')
                    ->form([
                        FileUpload::make('payment_proof_path')->label('Upload Payment Proof')->image()->directory('payment-proofs')->disk('public')->required(),
                    ])
                    ->action(function (Booking $record, array $data): void {
                        $record->update(['status' => 'confirmed', 'payment_proof_path' => $data['payment_proof_path']]);
                        $bookingDate = Carbon::parse($record->booking_date)->format('d M Y, H:i');
                        $message = "Hello,\n\nThank you for your payment.\nYour booking is confirmed for *{$bookingDate}* in our *{$record->space?->name}* Studio.\n\n"
                            . "• A cash deposit of IDR 1,000,000 is required upon arrival.\n"
                            . "• The studio will be ready 5 minutes prior to your session.\n"
                            . "• We recommend arriving 15 minutes early for check-in.\n"
                            . "• Overtime is charged at IDR 1,000,000 per hour.\n\nBest regards,\n*PLURAL*";
                        Http::withHeaders(['Authorization' => config('fonnte.cs_token')])
                            ->post('https://api.fonnte.com/send', ['target' => $record->whatsapp, 'message' => $message]);
                        Notification::make()->title('Booking confirmed & WA sent to ' . $record->name)->success()->send();
                    }),

                Action::make('checkin')
                    ->label('Check-In')
                    ->icon('heroicon-o-clipboard-document-check')
                    ->color('success')
                    ->visible(fn (Booking $record): bool => $record->status === 'confirmed')
                    ->url(fn (Booking $record): string => route('checkin.show', $record))
                    ->openUrlInNewTab(),

                Action::make('checkout')
                    ->label('Check-Out')
                    ->icon('heroicon-o-arrow-right-circle')
                    ->color('warning')
                    ->visible(fn (Booking $record): bool => $record->status === 'checked_in')
                    ->url(fn (Booking $record): string => route('checkout.show', $record))
                    ->openUrlInNewTab(),

                Action::make('done')
                    ->label('Done')
                    ->icon('heroicon-o-flag')
                    ->color('gray')
                    ->visible(fn (Booking $record): bool => $record->status === 'checked_in')
                    ->form([
                        Textarea::make('completion_notes')->label('General Notes')->rows(3),
                        Textarea::make('damage_notes')->label('Damage / Loss Notes')->rows(3),
                        TextInput::make('extra_time')->label('Extra Time (e.g. 30 minutes)'),
                    ])
                    ->action(function (Booking $record, array $data): void {
                        $record->update(['status' => 'completed', 'completion_notes' => $data['completion_notes'], 'damage_notes' => $data['damage_notes'], 'extra_time' => $data['extra_time']]);
                        Notification::make()->title('Booking completed!')->success()->send();
                    }),

                Action::make('view_checkin')
                    ->label('Waiver')
                    ->icon('heroicon-o-document-text')
                    ->color('gray')
                    ->visible(fn (Booking $record): bool => !empty($record->checkin_path))
                    ->url(fn (Booking $record): string => url('storage/' . $record->checkin_path))
                    ->openUrlInNewTab(),

                Action::make('view_checkout')
                    ->label('Checkout PDF')
                    ->icon('heroicon-o-document-text')
                    ->color('gray')
                    ->visible(fn (Booking $record): bool => !empty($record->checkout_path))
                    ->url(fn (Booking $record): string => url('storage/' . $record->checkout_path))
                    ->openUrlInNewTab(),

                Action::make('cancel')
                    ->label('Cancel')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn (Booking $record): bool => !in_array($record->status, ['completed', 'cancelled', 'checked_in']))
                    ->requiresConfirmation()
                    ->action(function (Booking $record): void {
                        $record->update(['status' => 'cancelled']);
                        Notification::make()->title('Booking cancelled')->warning()->send();
                    }),

                EditAction::make(),

                Action::make('reschedule')
                    ->label('Reschedule')
                    ->icon('heroicon-o-calendar-days')
                    ->color('warning')
                    ->visible(fn (Booking $record): bool => in_array($record->status, ['invoice_sent', 'confirmed']))
                    ->form([
                        DateTimePicker::make('new_booking_date')->label('New Booking Date & Time')->required(),
                        TextInput::make('reschedule_reason')->label('Reason (optional)')->placeholder('e.g. Customer request'),
                    ])
                    ->requiresConfirmation()
                    ->modalDescription('This will generate a new invoice and notify the customer.')
                    ->action(function (Booking $record, array $data): void {
                        $oldDate = Carbon::parse($record->booking_date)->format('d M Y, H:i');
                        $newDate = Carbon::parse($data['new_booking_date'])->format('d M Y, H:i');
                        $record->update(['booking_date' => $data['new_booking_date'], 'status' => 'contacted']);
                        $message = "Halo *{$record->name}*! 📅\n\nBooking kamu telah di-*RESCHEDULE*.\n\n"
                            . "📅 *Tanggal Lama:* {$oldDate}\n📅 *Tanggal Baru:* {$newDate}\n🏠 *Space:* {$record->space?->name}\n\n"
                            . ($data['reschedule_reason'] ? "📝 *Alasan:* {$data['reschedule_reason']}\n\n" : '')
                            . "Invoice baru akan segera dikirimkan. Terima kasih! 🙏\n_Plural Studio_";
                        Http::withHeaders(['Authorization' => config('fonnte.cs_token')])
                            ->post('https://api.fonnte.com/send', ['target' => $record->whatsapp, 'message' => $message]);
                        Notification::make()->title('Booking rescheduled — new invoice needed')->warning()->send();
                    }),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'edit'   => Pages\EditBooking::route('/{record}/edit'),
        ];
    }
}