@extends('layouts.admin')
@section('title', 'Dashboard Admin')

@section('content')
{{-- ══════════════════════════════════════════════════ --}}
{{-- AURORA BACKGROUND BLOBS (fixed behind all content) --}}
{{-- ══════════════════════════════════════════════════ --}}
<style>
    /* Override body/page background for this dashboard only */
    #main-content {
        background: linear-gradient(135deg, #f0f4ff 0%, #faf5ff 40%, #f0fdf4 100%) !important;
        position: relative;
    }
    .aurora-blob {
        position: fixed;
        border-radius: 50%;
        filter: blur(80px);
        pointer-events: none;
        z-index: 0;
    }
    /* Glassmorphism card override */
    .glass-card {
        background: rgba(255, 255, 255, 0.72) !important;
        backdrop-filter: blur(16px) !important;
        -webkit-backdrop-filter: blur(16px) !important;
        border: 1px solid rgba(255, 255, 255, 0.55) !important;
        box-shadow: 0 4px 24px rgba(99, 102, 241, 0.07), 0 1px 3px rgba(0,0,0,0.06) !important;
        position: relative;
        z-index: 1;
    }
    /* Subtle hover lift on glass cards */
    .glass-card:hover {
        box-shadow: 0 8px 32px rgba(99, 102, 241, 0.12), 0 2px 8px rgba(0,0,0,0.07) !important;
        transform: translateY(-1px);
        transition: all 0.25s ease;
    }
    /* Content wrapper z-index */
    .dashboard-content { position: relative; z-index: 1; }
</style>

{{-- Aurora Blobs --}}
<div class="aurora-blob" style="width: 500px; height: 500px; background: rgba(99, 102, 241, 0.12); top: -100px; right: -80px;"></div>
<div class="aurora-blob" style="width: 400px; height: 400px; background: rgba(59, 130, 246, 0.10); top: 200px; left: -100px;"></div>
<div class="aurora-blob" style="width: 350px; height: 350px; background: rgba(16, 185, 129, 0.08); bottom: 100px; right: 100px;"></div>
<div class="aurora-blob" style="width: 280px; height: 280px; background: rgba(168, 85, 247, 0.09); bottom: 200px; left: 200px;"></div>

<div class="dashboard-content">
{{-- Welcome Banner --}}
<div style="position: relative; overflow: hidden; background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); border-radius: 16px; padding: 28px; margin-bottom: 32px; color: #ffffff; box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.25);">
    <div style="position: absolute; right: -40px; top: -40px; width: 160px; height: 160px; background-color: rgba(255, 255, 255, 0.1); border-radius: 50%; filter: blur(40px);"></div>
    <div style="position: absolute; right: 80px; bottom: 0; width: 128px; height: 128px; background-color: rgba(255, 255, 255, 0.05); border-radius: 50%; filter: blur(30px);"></div>
    <div style="position: relative; z-index: 10; display: flex; flex-direction: row; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1 style="font-size: 24px; font-weight: 800; margin: 0; letter-spacing: -0.02em; line-height: 1.2;">Selamat Datang, Admin!</h1>
            <p style="color: rgba(239, 246, 255, 0.9); font-size: 13px; margin: 8px 0 0 0; max-width: 500px; line-height: 1.5;">
                Aplikasi SIPADU Desa Ketileng siap melayani warga. Pantau permohonan surat masuk dan lakukan verifikasi dengan cepat dan transparan hari ini.
            </p>
        </div>
        <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 6px; flex-shrink: 0;">
            <span style="padding: 4px 12px; background-color: rgba(255, 255, 255, 0.15); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 9999px; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">
                Hari Ini
            </span>
            <p style="font-size: 13px; font-weight: 600; color: #f1f5f9; margin: 4px 0 0 0;">
                {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
            </p>
        </div>
    </div>
</div>

{{-- Stat Cards --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="card glass-card" style="display: flex; align-items: center; gap: 20px; padding: 20px;">
        <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #2563eb, #4f46e5); color: #ffffff; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);">
            <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
        </div>
        <div>
            <p style="font-size: 11px; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em; margin: 0;">Total Penduduk</p>
            <p style="font-size: 24px; font-weight: 700; color: #1e293b; margin: 4px 0 0 0; line-height: 1;">{{ number_format($stats['total_penduduk']) }}</p>
        </div>
    </div>
    
    <div class="card glass-card" style="display: flex; align-items: center; gap: 20px; padding: 20px;">
        <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #0ea5e9, #2563eb); color: #ffffff; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 12px rgba(14, 165, 233, 0.2);">
            <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        </div>
        <div>
            <p style="font-size: 11px; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em; margin: 0;">Berkas Masuk</p>
            <p style="font-size: 24px; font-weight: 700; color: #1e293b; margin: 4px 0 0 0; line-height: 1;">{{ number_format($stats['berkas_masuk']) }}</p>
        </div>
    </div>

    <div class="card glass-card" style="display: flex; align-items: center; gap: 20px; padding: 20px;">
        <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #f43f5e, #e11d48); color: #ffffff; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 12px rgba(244, 63, 94, 0.2);">
            <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <p style="font-size: 11px; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em; margin: 0;">Perlu Tinjauan</p>
            <p style="font-size: 24px; font-weight: 700; color: #1e293b; margin: 4px 0 0 0; line-height: 1;">{{ number_format($stats['perlu_tinjauan']) }}</p>
        </div>
    </div>

    <div class="card glass-card" style="display: flex; align-items: center; gap: 20px; padding: 20px;">
        <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #8b5cf6, #6d28d9); color: #ffffff; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 12px rgba(139, 92, 246, 0.2);">
            <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
        </div>
        <div>
            <p style="font-size: 11px; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em; margin: 0;">Sedang Diproses</p>
            <p style="font-size: 24px; font-weight: 700; color: #1e293b; margin: 4px 0 0 0; line-height: 1;">{{ number_format($stats['diproses']) }}</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-8 mb-8">
    {{-- Verifikasi Berkas (Pending) --}}
    <div class="card glass-card" style="padding: 0; overflow: hidden; display: flex; flex-direction: column;">
        <div style="padding: 20px; border-bottom: 1px solid rgba(241, 245, 249, 0.8); display: flex; align-items: center; justify-content: space-between; background: rgba(250, 250, 250, 0.5);">
            <div style="display: flex; align-items: center; gap: 8px;">
                <span style="width: 10px; height: 10px; border-radius: 50%; background-color: #f59e0b;"></span>
                <h2 style="font-size: 15px; font-weight: 700; color: #1e293b; margin: 0;">Verifikasi Berkas Masuk</h2>
            </div>
            <a href="{{ route('admin.verifikasi.index') }}" style="font-size: 11px; font-weight: 700; color: #2563eb; text-decoration: none; text-transform: uppercase; letter-spacing: 0.05em;">Lihat Semua</a>
        </div>
        <div style="flex: 1; overflow-x: auto;">
            @if($verifikasi_pending->isEmpty())
                <div style="padding: 48px; text-align: center; color: #94a3b8; display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 200px;">
                    <svg style="width: 40px; height: 40px; text-color: #cbd5e1; margin-bottom: 8px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p style="font-size: 14px; font-weight: 500; margin: 0;">Belum ada berkas yang perlu diverifikasi.</p>
                </div>
            @else
                <table style="width: 100%; text-align: left; font-size: 13px; min-width: 300px; border-collapse: collapse;">
                    <tbody>
                        @foreach($verifikasi_pending as $p)
                        <tr style="border-bottom: 1px solid #f8fafc; transition: background-color 0.2s;">
                            <td style="padding: 16px;">
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div style="width: 36px; height: 36px; border-radius: 50%; background-color: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px; border: 1px solid #dbeafe; flex-shrink: 0;">
                                        {{ strtoupper(substr($p->penduduk->nama, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p style="font-weight: 700; color: #1e293b; margin: 0;">{{ $p->jenisSurat->nama }}</p>
                                        <p style="color: #64748b; font-size: 11px; margin: 2px 0 0 0;">Pemohon: <span style="font-weight: 600; color: #475569;">{{ $p->penduduk->nama }}</span></p>
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 16px; color: #64748b; font-size: 12px;">
                                <div style="display: flex; align-items: center; gap: 4px;">
                                    <svg style="width: 14px; height: 14px; color: #94a3b8;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span>{{ $p->created_at->diffForHumans() }}</span>
                                </div>
                            </td>
                            <td style="padding: 16px; text-align: right;">
                                <div style="display: flex; align-items: center; justify-content: flex-end; gap: 12px;">
                                    <span style="display: inline-flex; align-items: center; padding: 2px 10px; border-radius: 9999px; font-size: 11px; font-weight: 600; background-color: #fef3c7; color: #d97706; border: 1px solid rgba(217, 119, 6, 0.15);">{{ $p->status_badge['label'] }}</span>
                                    <a href="{{ route('admin.verifikasi.show', $p) }}" class="btn-outline" style="padding: 6px 12px; font-size: 11px; border-radius: 8px; font-weight: 600; display: inline-flex; text-decoration: none;">Review</a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    {{-- Notifikasi Registrasi Warga Baru --}}
    <div class="card glass-card" style="padding: 0; overflow: hidden; display: flex; flex-direction: column;">
        <div style="padding: 20px; border-bottom: 1px solid rgba(241, 245, 249, 0.8); display: flex; align-items: center; justify-content: space-between; background: rgba(250, 250, 250, 0.5);">
            <div style="display: flex; align-items: center; gap: 8px;">
                <svg style="width: 16px; height: 16px; color: #3b82f6;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                <h2 style="font-size: 15px; font-weight: 700; color: #1e293b; margin: 0;">Notifikasi Registrasi Warga</h2>
            </div>
            <span style="padding: 2px 8px; background-color: #dbeafe; color: #1e40af; border-radius: 9999px; font-size: 10px; font-weight: 700; text-transform: uppercase;">Akun Baru</span>
        </div>
        <div style="flex: 1; overflow-x: auto;">
            @if($registrasi_baru->isEmpty())
                <div style="padding: 48px; text-align: center; color: #94a3b8; display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 200px;">
                    <svg style="width: 40px; height: 40px; text-color: #cbd5e1; margin-bottom: 8px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <p style="font-size: 14px; font-weight: 500; margin: 0;">Belum ada registrasi akun warga.</p>
                </div>
            @else
                <table style="width: 100%; text-align: left; font-size: 13px; min-width: 250px; border-collapse: collapse;">
                    <thead style="background-color: #fafafa; border-bottom: 1px solid #f1f5f9;">
                        <tr>
                            <th style="padding: 12px 16px; font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">Warga / NIK</th>
                            <th style="padding: 12px 16px; font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($registrasi_baru as $u)
                        <tr style="border-bottom: 1px solid #f8fafc; transition: background-color 0.2s;">
                            <td style="padding: 12px 16px;">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div style="width: 32px; height: 32px; border-radius: 50%; background-color: #eff6ff; color: #3b82f6; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 12px; border: 1px solid #bfdbfe; flex-shrink: 0;">
                                        {{ strtoupper(substr($u->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div style="font-weight: 700; color: #1e293b;">{{ $u->name }}</div>
                                        <div style="font-size: 10px; color: #94a3b8; font-family: monospace;">NIK: {{ $u->nik }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 12px 16px; color: #64748b; font-size: 11px; vertical-align: middle;">
                                <div style="display: flex; align-items: center; gap: 4px;">
                                    <span style="display: inline-block; width: 6px; height: 6px; background-color: #10b981; border-radius: 50%;"></span>
                                    <span>{{ $u->created_at->diffForHumans() }}</span>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    {{-- Penduduk Terbaru --}}
    <div class="card glass-card" style="padding: 0; overflow: hidden; display: flex; flex-direction: column;">
        <div style="padding: 20px; border-bottom: 1px solid rgba(241, 245, 249, 0.8); display: flex; align-items: center; justify-content: space-between; background: rgba(250, 250, 250, 0.5);">
            <div style="display: flex; align-items: center; gap: 8px;">
                <svg style="width: 16px; height: 16px; color: #64748b;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <h2 style="font-size: 15px; font-weight: 700; color: #1e293b; margin: 0;">Penduduk Baru Terdaftar</h2>
            </div>
            <a href="{{ route('admin.penduduk.index') }}" style="font-size: 11px; font-weight: 700; color: #2563eb; text-decoration: none; text-transform: uppercase; letter-spacing: 0.05em;">Lihat Semua</a>
        </div>
        <div style="flex: 1; overflow-x: auto;">
            @if($penduduk_terbaru->isEmpty())
                <div style="padding: 48px; text-align: center; color: #94a3b8; display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 200px;">
                    <svg style="width: 40px; height: 40px; text-color: #cbd5e1; margin-bottom: 8px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857"/></svg>
                    <p style="font-size: 14px; font-weight: 500; margin: 0;">Belum ada data penduduk.</p>
                </div>
            @else
                <table style="width: 100%; text-align: left; font-size: 13px; min-width: 250px; border-collapse: collapse;">
                    <thead style="background-color: #fafafa; border-bottom: 1px solid #f1f5f9;">
                        <tr>
                            <th style="padding: 12px 16px; font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">Nama</th>
                            <th style="padding: 12px 16px; font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">Alamat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($penduduk_terbaru as $p)
                        <tr style="border-bottom: 1px solid #f8fafc; transition: background-color 0.2s;">
                            <td style="padding: 12px 16px;">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div style="width: 32px; height: 32px; border-radius: 50%; background-color: #f1f5f9; color: #475569; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 12px; border: 1px solid #e2e8f0; flex-shrink: 0;">
                                        {{ strtoupper(substr($p->nama, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div style="font-weight: 700; color: #1e293b;">{{ $p->nama }}</div>
                                        <div style="font-size: 10px; color: #94a3b8; font-family: monospace;">NIK: {{ $p->nik }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 12px 16px; color: #64748b; font-size: 11px; line-height: 1.4;">
                                <div>{{ $p->desa }}</div>
                                <div style="font-size: 10px; color: #94a3b8; margin-top: 2px;">RT {{ $p->rt ?? '-' }}/RW {{ $p->rw ?? '-' }}</div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>

{{-- Arsip Surat Terakhir --}}
<div class="card glass-card" style="padding: 0; overflow: hidden; margin-bottom: 32px;">
    <div style="padding: 20px; border-bottom: 1px solid rgba(241, 245, 249, 0.8); display: flex; align-items: center; justify-content: space-between; background: rgba(250, 250, 250, 0.5);">
        <div style="display: flex; align-items: center; gap: 8px;">
            <svg style="width: 16px; height: 16px; color: #10b981;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            <h2 style="font-size: 15px; font-weight: 700; color: #1e293b; margin: 0;">Arsip Surat Selesai Hari Ini</h2>
        </div>
        <span style="padding: 3px 10px; bg-color: #ecfdf5; border: 1px solid rgba(16, 185, 129, 0.2); color: #047857; border-radius: 9999px; font-size: 11px; font-weight: 700; background-color: #ecfdf5;">TTE Terverifikasi</span>
    </div>
    <div style="overflow-x: auto;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>No. Surat</th>
                    <th>Jenis Surat</th>
                    <th>Pemohon</th>
                    <th>Tanggal Selesai</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($arsip_surat as $p)
                <tr>
                    <td style="font-weight: 600; color: #1e293b; font-family: monospace; font-size: 12px;">{{ $p->no_surat }}</td>
                    <td style="color: #1e293b; font-weight: 700;">{{ $p->jenisSurat->nama }}</td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <div style="width: 24px; height: 24px; border-radius: 50%; background-color: #ecfdf5; color: #10b981; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 10px; border: 1px solid #d1fae5; flex-shrink: 0;">
                                {{ strtoupper(substr($p->penduduk->nama, 0, 1)) }}
                            </div>
                            <span style="color: #475569; font-weight: 500;">{{ $p->penduduk->nama }}</span>
                        </div>
                    </td>
                    <td style="color: #64748b; font-size: 12px;">
                        <div style="display: flex; align-items: center; gap: 4px;">
                            <svg style="width: 14px; height: 14px; color: #94a3b8;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>{{ $p->approved_at->format('d M Y, H:i') }} WIB</span>
                        </div>
                    </td>
                    <td>
                        <span style="display: inline-flex; align-items: center; gap: 4px; padding: 2px 10px; border-radius: 9999px; font-size: 11px; font-weight: 700; background-color: #ecfdf5; color: #047857; border: 1px solid rgba(16, 185, 129, 0.15);">
                            <svg style="width: 12px; height: 12px; color: #059669;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            Selesai
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 48px; color: #64748b;">
                        <svg style="width: 48px; height: 48px; margin: 0 auto 12px auto; color: #cbd5e1; display: block;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <p style="font-size: 14px; font-weight: 700; color: #475569; margin: 0 0 4px 0;">Tidak ada arsip surat hari ini.</p>
                        <p style="font-size: 11px; color: #94a3b8; margin: 0;">Berkas yang disetujui Kepala Desa hari ini akan tampil di sini.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</div>{{-- end dashboard-content --}}
@endsection
