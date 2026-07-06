@extends('layouts.kades')
@section('title', 'Dashboard Persetujuan')

@section('content')
{{-- Welcome Banner --}}
<div style="position: relative; overflow: hidden; background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); border-radius: 16px; padding: 28px; margin-bottom: 32px; color: #ffffff; box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.25);">
    <div style="position: absolute; right: -40px; top: -40px; width: 160px; height: 160px; background-color: rgba(255, 255, 255, 0.1); border-radius: 50%; filter: blur(40px);"></div>
    <div style="position: absolute; right: 80px; bottom: 0; width: 128px; height: 128px; background-color: rgba(255, 255, 255, 0.05); border-radius: 50%; filter: blur(30px);"></div>
    <div style="position: relative; z-index: 10; display: flex; flex-direction: row; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1 style="font-size: 24px; font-weight: 800; margin: 0; letter-spacing: -0.02em; line-height: 1.2;">Selamat Datang, Kepala Desa!</h1>
            <p style="color: rgba(239, 246, 255, 0.9); font-size: 13px; margin: 8px 0 0 0; max-width: 500px; line-height: 1.5;">
                Silakan tinjau dan berikan persetujuan digital (TTE) pada permohonan surat warga Desa Ketileng.
            </p>
        </div>
        <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 6px; flex-shrink: 0;">
            <span style="padding: 4px 12px; background-color: rgba(255, 255, 255, 0.15); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 9999px; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">
                Hari Ini
            </span>
            <p style="font-size: 13px; font-weight: 600; color: #f1f5f9; margin: 4px 0 0 0;">
                {{ now()->locale('id')->isoFormat('D MMMM YYYY') }}
            </p>
        </div>
    </div>
</div>

{{-- Stat Cards --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="card glass-card" style="display: flex; align-items: center; justify-content: space-between; padding: 20px;">
        <div>
            <p style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em; margin: 0 0 6px 0;">Menunggu Persetujuan</p>
            <p id="stat-menunggu" style="font-size: 30px; font-weight: 800; color: #1e293b; margin: 0;">{{ $stats['menunggu'] }}</p>
        </div>
        <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #f59e0b, #d97706); color: #ffffff; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 12px rgba(245, 158, 11, 0.2);">
            <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
    </div>
    
    <div class="card glass-card" style="display: flex; align-items: center; justify-content: space-between; padding: 20px;">
        <div>
            <p style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em; margin: 0 0 6px 0;">Disetujui Hari Ini</p>
            <p id="stat-disetujui" style="font-size: 30px; font-weight: 800; color: #2563eb; margin: 0;">{{ $stats['disetujui'] }}</p>
        </div>
        <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #2563eb, #3b82f6); color: #ffffff; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);">
            <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
    </div>
    
    <div class="card glass-card" style="display: flex; align-items: center; justify-content: space-between; padding: 20px;">
        <div>
            <p style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em; margin: 0 0 6px 0;">Total Dokumen (Bulan Ini)</p>
            <p id="stat-total-bulan" style="font-size: 30px; font-weight: 800; color: #1e293b; margin: 0;">{{ $stats['total_bulan'] }}</p>
        </div>
        <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #64748b, #475569); color: #ffffff; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 12px rgba(100, 116, 139, 0.2);">
            <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"/></svg>
        </div>
    </div>
</div>

{{-- Charts --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    {{-- Chart 1: Tren Bulanan --}}
    <div class="card glass-card lg:col-span-2" style="padding: 24px;">
        <h3 style="font-size: 15px; font-weight: 700; color: #1e293b; margin: 0 0 16px 0;">Tren Pengajuan Surat (Tahun {{ now()->year }})</h3>
        <div id="monthly-chart" style="min-height: 280px;"></div>
    </div>

    {{-- Chart 2: Jenis Surat Terpopuler --}}
    <div class="card glass-card" style="padding: 24px;">
        <h3 style="font-size: 15px; font-weight: 700; color: #1e293b; margin: 0 0 16px 0;">Jenis Surat Terpopuler</h3>
        <div id="popular-chart" style="min-height: 280px; display: flex; align-items: center; justify-content: center;"></div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    function renderKadesCharts() {
        if (typeof ApexCharts === 'undefined') {
            setTimeout(renderKadesCharts, 300);
            return;
        }

        // 1. Monthly Chart Options
        var monthlyOptions = {
            chart: {
                type: 'area',
                height: 280,
                toolbar: {
                    show: true,
                    tools: {
                        download: true,
                        selection: false,
                        zoom: false,
                        zoomin: false,
                        zoomout: false,
                        pan: false,
                        reset: false
                    }
                },
                fontFamily: 'Inter, sans-serif'
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 3,
                colors: ['#2563eb']
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.45,
                    opacityTo: 0.05,
                    stops: [0, 90, 100]
                }
            },
            series: [{
                name: 'Pengajuan',
                data: @json($monthlyChartData)
            }],
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                labels: {
                    style: {
                        colors: '#64748b',
                        fontSize: '11px',
                        fontWeight: 600
                    }
                },
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: '#64748b',
                        fontSize: '11px',
                        fontWeight: 600
                    }
                }
            },
            grid: {
                borderColor: '#f1f5f9',
                strokeDashArray: 4
            },
            theme: { mode: 'light' },
            tooltip: {
                theme: 'light',
                x: { show: true }
            }
        };

        var monthlyChartContainer = document.querySelector("#monthly-chart");
        if (monthlyChartContainer) {
            monthlyChartContainer.innerHTML = '';
            window.monthlyChartInstance = new ApexCharts(monthlyChartContainer, monthlyOptions);
            window.monthlyChartInstance.render();
        }

        // 2. Popular Chart Options
        var popularOptions = {
            chart: {
                type: 'donut',
                height: 280,
                fontFamily: 'Inter, sans-serif'
            },
            series: @json($popularChartSeries),
            labels: @json($popularChartLabels),
            colors: ['#2563eb', '#10b981', '#f59e0b', '#7c3aed', '#ef4444'],
            legend: {
                position: 'bottom',
                fontSize: '11px',
                fontWeight: 600,
                labels: { colors: '#475569' },
                markers: { radius: 12 }
            },
            dataLabels: {
                enabled: true,
                style: { fontSize: '11px', fontWeight: 700 },
                dropShadow: { enabled: false }
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '70%',
                        labels: {
                            show: true,
                            name: { show: true, fontSize: '12px', fontWeight: 700, color: '#64748b' },
                            value: { show: true, fontSize: '18px', fontWeight: 800, color: '#1e293b' },
                            total: {
                                show: true,
                                label: 'Total',
                                color: '#64748b',
                                formatter: function (w) {
                                    return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                }
                            }
                        }
                    }
                }
            },
            tooltip: { theme: 'light' }
        };

        var popularChartContainer = document.querySelector("#popular-chart");
        if (popularChartContainer) {
            popularChartContainer.innerHTML = '';
            window.popularChartInstance = new ApexCharts(popularChartContainer, popularOptions);
            window.popularChartInstance.render();
        }
    }

    document.addEventListener("DOMContentLoaded", renderKadesCharts);
    window.addEventListener("load", renderKadesCharts);

    // Otomatis perbarui grafik secara smooth tanpa full reload browser
    window.addEventListener('new-notification-received', function () {
        console.log('Notifikasi baru masuk, memperbarui data secara smooth...');

        // 1. Ambil data JSON untuk memperbarui grafik & angka statistik
        fetch(window.location.href, {
            headers: { 
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            // Update stats cards dengan transisi angka yang rapi
            if (data.stats) {
                const updateStat = (id, newVal) => {
                    const el = document.getElementById(id);
                    if (el && el.textContent !== String(newVal)) {
                        el.style.transition = 'all 0.3s ease';
                        el.style.opacity = '0';
                        setTimeout(() => {
                            el.textContent = newVal;
                            el.style.opacity = '1';
                        }, 300);
                    }
                };
                updateStat('stat-menunggu', data.stats.menunggu);
                updateStat('stat-disetujui', data.stats.disetujui);
                updateStat('stat-total-bulan', data.stats.total_bulan);
            }

            // Update chart bulanan
            if (window.monthlyChartInstance && data.monthlyChartData) {
                window.monthlyChartInstance.updateSeries([{
                    name: 'Pengajuan',
                    data: data.monthlyChartData
                }]);
            }

            // Update chart terpopuler
            if (window.popularChartInstance && data.popularChartSeries && data.popularChartLabels) {
                window.popularChartInstance.updateSeries(data.popularChartSeries);
                window.popularChartInstance.updateOptions({
                    labels: data.popularChartLabels
                });
            }
        })
        .catch(err => console.error('Gagal mengambil data statistik via AJAX:', err));

        // 2. Ambil HTML baru untuk memperbarui daftar tabel antrean tanpa reload
        fetch(window.location.href)
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newAntrean = doc.getElementById('antrean-container');
            const oldAntrean = document.getElementById('antrean-container');
            if (newAntrean && oldAntrean) {
                oldAntrean.style.transition = 'all 0.3s ease';
                oldAntrean.style.opacity = '0.5';
                setTimeout(() => {
                    oldAntrean.innerHTML = newAntrean.innerHTML;
                    oldAntrean.style.opacity = '1';
                }, 300);
            }
        })
        .catch(err => console.error('Gagal memperbarui tabel antrean:', err));
    });
</script>

{{-- Antrean Dokumen --}}
<div id="antrean-container" class="card glass-card" style="padding: 0; overflow: hidden; margin-bottom: 32px;">
    <div style="padding: 20px; border-bottom: 1px solid rgba(241, 245, 249, 0.8); display: flex; align-items: center; justify-content: space-between; background: rgba(250, 250, 250, 0.5);">
        <div style="display: flex; align-items: center; gap: 8px;">
            <span style="width: 10px; height: 10px; border-radius: 50%; background-color: #f59e0b; display: inline-block;"></span>
            <h2 style="font-size: 15px; font-weight: 700; color: #1e293b; margin: 0;">Dokumen Menunggu Tanda Tangan</h2>
        </div>
        <a href="{{ route('kades.surat-disetujui') }}" style="font-size: 11px; font-weight: 700; color: #2563eb; text-decoration: none; text-transform: uppercase; letter-spacing: 0.05em;">Arsip Disetujui</a>
    </div>
    <div style="overflow-x: auto;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Pemohon</th>
                    <th>Jenis Dokumen</th>
                    <th>Keperluan</th>
                    <th>Tanggal Masuk</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($antrean as $p)
                <tr>
                    <td style="padding: 16px;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 36px; height: 36px; border-radius: 50%; background-color: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px; border: 1px solid #dbeafe; flex-shrink: 0;">
                                {{ strtoupper(substr($p->penduduk->nama, 0, 1)) }}
                            </div>
                            <div>
                                <p style="font-weight: 700; color: #1e293b; margin: 0;">{{ $p->penduduk->nama }}</p>
                                <p style="font-size: 11px; color: #64748b; margin: 2px 0 0 0;">NIK: {{ $p->penduduk->nik }}</p>
                            </div>
                        </div>
                    </td>
                    <td style="font-weight: 700; color: #1e293b;">{{ $p->jenisSurat->nama }}</td>
                    <td style="color: #475569; max-w-xs truncate; font-size: 12px;">{{ $p->keperluan }}</td>
                    <td style="color: #64748b; font-size: 12px;">
                        <div style="display: flex; align-items: center; gap: 4px;">
                            <svg style="width: 14px; height: 14px; color: #94a3b8;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>{{ $p->verified_at ? $p->verified_at->format('d M Y, H:i') : '-' }} WIB</span>
                        </div>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('kades.review', $p) }}" class="btn-primary" style="padding: 6px 12px; font-size: 11px; border-radius: 8px; font-weight: 700; text-decoration: none; display: inline-flex;">
                            Tinjau Dokumen
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 48px; color: #64748b;">
                        <svg style="width: 48px; height: 48px; margin: 0 auto 12px auto; color: #cbd5e1; display: block;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p style="font-weight: 700; color: #475569; margin: 0 0 4px 0;">Tidak ada antrean dokumen</p>
                        <p style="font-size: 11px; color: #94a3b8; margin: 0;">Semua berkas pengajuan warga saat ini telah selesai ditinjau.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($antrean->hasPages())
    <div class="p-4 border-t border-slate-100">
        {{ $antrean->links() }}
    </div>
    @endif
</div>
@endsection
