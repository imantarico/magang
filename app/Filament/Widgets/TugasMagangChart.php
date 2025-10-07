<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\TugasMagang;

class TugasMagangChart extends ChartWidget
{
    protected ?string $heading = 'Grafik Status Tugas Magang';

    protected function getData(): array
    {
        // Status tugas yang tersedia di tabel tugas_magang
        $labels = ['Belum Dikerjakan', 'Sedang Dikerjakan', 'Selesai'];
        $statuses = ['belum_dikerjakan', 'dikerjakan', 'selesai'];
        $counts = [];

        foreach ($statuses as $status) {
            $counts[] = TugasMagang::where('status', $status)->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Tugas',
                    'data' => $counts,
                    'backgroundColor' => [
                        '#6b7280', // abu: belum
                        '#f59e0b', // kuning: dikerjakan
                        '#10b981', // hijau: selesai
                    ],
                    'borderRadius' => 6,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar'; // bisa juga 'pie' atau 'doughnut'
    }
}
