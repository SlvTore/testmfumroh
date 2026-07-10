<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;

class AnalyzeDepartures extends Command
{
    protected $signature = 'app:analyze-departures';
    protected $description = 'Analyze departures for marketing and operations';

    public function handle()
    {
        $departures = [
            ['code' => 'UMR-A1', 'status' => 'Confirmed', 'date' => '2026-08-01', 'filled' => 45, 'quota' => 50, 'price' => 30000000],
            ['code' => 'UMR-B2', 'status' => 'Pending', 'date' => '2026-08-15', 'filled' => 12, 'quota' => 45, 'price' => 28000000],
            ['code' => 'UMR-C3', 'status' => 'Confirmed', 'date' => '2026-09-01', 'filled' => 38, 'quota' => 40, 'price' => 35000000],
            ['code' => 'UMR-D4', 'status' => 'Pending', 'date' => '2026-07-25', 'filled' => 8, 'quota' => 30, 'price' => 32000000],
            ['code' => 'UMR-E5', 'status' => 'Confirmed', 'date' => '2026-07-20', 'filled' => 28, 'quota' => 30, 'price' => 30000000],
        ];

        $collection = collect($departures);
        $today = Carbon::now();

        $this->info("=== DEPARTURE ANALYSIS REPORT ===");

        $marketing = $collection->map(function ($item) use ($today) {
            $days = (int) $today->diffInDays(Carbon::parse($item['date']), false);
            $occupancy = ($item['filled'] / $item['quota']) * 100;

            $action = 'Normal';
            if ($days <= 30 && $occupancy < 60) {
                $action = 'PROMO URGENT (Diskon 15%)';
            } elseif ($days <= 45 && $occupancy < 80) {
                $action = 'Push Sales (Diskon 5%)';
            }

            return [
                'code' => $item['code'],
                'date' => $item['date'],
                'days_left' => $days . ' days',
                'occupancy' => round($occupancy) . '%',
                'remaining' => $item['quota'] - $item['filled'],
                'action' => $action
            ];
        })->filter(fn($item) => $item['action'] !== 'Normal');

        $this->line("\n[MARKETING ALERT: LOW OCCUPANCY NEAR DEPARTURE]");
        $this->table(['Code', 'Date', 'Days Left', 'Occupancy', 'Remaining', 'Action'], $marketing->toArray());

        $operations = $collection->map(function ($item) use ($today) {
            $days = (int) $today->diffInDays(Carbon::parse($item['date']), false);
            $occupancy = ($item['filled'] / $item['quota']) * 100;

            $priority = 'Normal';
            if ($item['status'] === 'Confirmed') {
                if ($days <= 30) {
                    $priority = 'URGENT (Book Hotel & Visa)';
                } elseif ($days <= 60 && $occupancy >= 70) {
                    $priority = 'MEDIUM (Lock Tickets)';
                }
            }

            return [
                'code' => $item['code'],
                'status' => $item['status'],
                'date' => $item['date'],
                'jemaah' => $item['filled'] . ' pax',
                'days_left' => $days . ' days',
                'priority' => $priority
            ];
        })->filter(fn($item) => $item['priority'] !== 'Normal')->sortBy('days_left');

        $this->line("\n[OPERATIONAL ALERT: CONFIRMED DEPARTURES PRIORITY]");
        $this->table(['Code', 'Status', 'Date', 'Jemaah', 'Days Left', 'Priority'], $operations->toArray());
    }
}
