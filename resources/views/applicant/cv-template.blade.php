<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>CV - {{ $applicant->hoten_uv }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
        }

        .container {
            padding: 20px;
        }

        /* Header Section */
        .cv-header {
            background: linear-gradient(135deg, #4f46e5, #06b6d4);
            color: white;
            padding: 30px;
            margin-bottom: 20px;
            border-radius: 10px;
        }

        .cv-header h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }

        .cv-header .position {
            font-size: 14px;
            opacity: 0.9;
            margin-bottom: 15px;
        }

        .contact-info {
            display: table;
            width: 100%;
            margin-top: 10px;
        }

        .contact-item {
            display: table-cell;
            padding: 5px 10px;
            font-size: 11px;
        }

        /* Section Styles */
        .section {
            margin-bottom: 20px;
            page-break-inside: avoid;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #4f46e5;
            border-bottom: 2px solid #4f46e5;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }

        .section-content {
            padding-left: 10px;
        }

        /* Timeline Items */
        .timeline-item {
            margin-bottom: 15px;
            padding-left: 15px;
            border-left: 3px solid #e5e7eb;
        }

        .timeline-item h3 {
            font-size: 14px;
            color: #1f2937;
            margin-bottom: 3px;
        }

        .timeline-item .company,
        .timeline-item .school {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 3px;
        }

        .timeline-item .duration {
            font-size: 11px;
            color: #9ca3af;
            margin-bottom: 8px;
        }

        .timeline-item .description {
            font-size: 11px;
            color: #4b5563;
            white-space: pre-wrap;
            margin-top: 5px;
        }

        /* Skills & Languages */
        .badge-container {
            margin-top: 10px;
        }

        .badge {
            display: inline-block;
            background: #4f46e5;
            color: white;
            padding: 5px 12px;
            border-radius: 15px;
            margin-right: 8px;
            margin-bottom: 8px;
            font-size: 11px;
        }

        .badge-light {
            background: #e5e7eb;
            color: #1f2937;
        }

        /* Introduction */
        .intro-text {
            font-size: 12px;
            line-height: 1.8;
            color: #4b5563;
            text-align: justify;
        }

        /* Link Styles */
        .link {
            color: #4f46e5;
            text-decoration: none;
            font-size: 11px;
        }

        /* Award Icon */
        .award-title {
            color: #f59e0b;
        }

        /* Page Break */
        .page-break {
            page-break-after: always;
        }

        /* Footer */
        .cv-footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #9ca3af;
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="cv-header">
            <h1>{{ $applicant->hoten_uv ?? 'Họ tên ứng viên' }}</h1>
            <div class="position">{{ $applicant->vitritungtuyen ?? 'Chức danh / Vị trí' }}</div>

            <div class="contact-info">
                <div class="contact-item">✉ {{ $email }}</div>
                <div class="contact-item">☎ {{ $applicant->sdt_uv ?? 'N/A' }}</div>
                <div class="contact-item">📅 {{ $applicant->ngaysinh ?? 'N/A' }}</div>
                <div class="contact-item">⚧ {{ $applicant->gioitinh_uv ?? 'N/A' }}</div>
            </div>
            <div style="margin-top: 5px; font-size: 11px;">
                📍 {{ $applicant->diachi_uv ?? 'N/A' }}
            </div>
        </div>

        <!-- Giới thiệu bản thân -->
        @if($applicant->gioithieu)
        <div class="section">
            <div class="section-title">GIỚI THIỆU BẢN THÂN</div>
            <div class="section-content">
                <div class="intro-text">{!! nl2br(strip_tags($applicant->gioithieu)) !!}</div>
            </div>
        </div>
        @endif

        <!-- Kinh nghiệm làm việc -->
        @if(isset($kinhnghiem) && $kinhnghiem->count() > 0)
        <div class="section">
            <div class="section-title">KINH NGHIỆM LÀM VIỆC</div>
            <div class="section-content">
                @foreach($kinhnghiem as $kn)
                <div class="timeline-item">
                    <h3>{{ $kn->chucdanh }}</h3>
                    <div class="company">{{ $kn->congty }}</div>
                    <div class="duration">
                        {{ date('m/Y', strtotime($kn->tu_ngay)) }} -
                        {{ $kn->dang_lam_viec ? 'Hiện tại' : date('m/Y', strtotime($kn->den_ngay)) }}
                    </div>

                    @if($kn->mota)
                    <div class="description">
                        <strong>Mô tả:</strong><br>
                        {{ $kn->mota }}
                    </div>
                    @endif

                    @if($kn->duan)
                    <div class="description">
                        <strong>Dự án tham gia:</strong><br>
                        {{ $kn->duan }}
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Học vấn -->
        @if(isset($hocvan) && $hocvan->count() > 0)
        <div class="section">
            <div class="section-title">HỌC VẤN</div>
            <div class="section-content">
                @foreach($hocvan as $hv)
                <div class="timeline-item">
                    <h3>{{ $hv->truong }}</h3>
                    <div class="school">{{ $hv->nganh }} - {{ $hv->trinhdo }}</div>
                    <div class="duration">
                        {{ date('Y', strtotime($hv->tu_ngay)) }} -
                        {{ $hv->dang_hoc ? 'Hiện tại' : date('Y', strtotime($hv->den_ngay)) }}
                    </div>
                    @if($hv->thongtin_khac)
                    <div class="description">{{ $hv->thongtin_khac }}</div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Kỹ năng -->
        @if(isset($kynang) && $kynang->count() > 0)
        <div class="section">
            <div class="section-title">KỸ NĂNG</div>
            <div class="section-content">
                <div class="badge-container">
                    @foreach($kynang as $kn)
                    <span class="badge">
                        {{ $kn->ten_ky_nang }}
                        ({{ $kn->nam_kinh_nghiem == 0 ? '<1 năm' : $kn->nam_kinh_nghiem . ' năm' }})
                    </span>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Ngoại ngữ -->
        @if(isset($ngoaiNgu) && $ngoaiNgu->count() > 0)
        <div class="section">
            <div class="section-title">NGOẠI NGỮ</div>
            <div class="section-content">
                <div class="badge-container">
                    @foreach($ngoaiNgu as $nn)
                    <span class="badge badge-light">
                        {{ $nn->ten_ngoai_ngu }} - {{ $nn->trinh_do }}
                    </span>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Dự án nổi bật -->
        @if(isset($duAn) && $duAn->count() > 0)
        <div class="section">
            <div class="section-title">DỰ ÁN NỔI BẬT</div>
            <div class="section-content">
                @foreach($duAn as $da)
                <div class="timeline-item">
                    <h3>{{ $da->ten_duan }}</h3>
                    <div class="duration">
                        {{ date('m/Y', strtotime($da->ngay_bat_dau)) }} -
                        {{ $da->dang_lam ? 'Hiện tại' : date('m/Y', strtotime($da->ngay_ket_thuc)) }}
                    </div>

                    @if($da->mota_duan)
                    <div class="description">{{ $da->mota_duan }}</div>
                    @endif

                    @if($da->duongdan_website)
                    <div style="margin-top: 5px;">
                        <span class="link">🔗 {{ $da->duongdan_website }}</span>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Chứng chỉ -->
        @if(isset($chungChi) && $chungChi->count() > 0)
        <div class="section">
            <div class="section-title">CHỨNG CHỈ</div>
            <div class="section-content">
                @foreach($chungChi as $cc)
                <div class="timeline-item">
                    <h3>{{ $cc->ten_chungchi }}</h3>
                    <div class="company">{{ $cc->to_chuc }}</div>
                    <div class="duration">{{ date('m/Y', strtotime($cc->thoigian)) }}</div>

                    @if($cc->mo_ta)
                    <div class="description">{{ $cc->mo_ta }}</div>
                    @endif

                    @if($cc->link_chungchi)
                    <div style="margin-top: 5px;">
                        <span class="link">🔗 {{ $cc->link_chungchi }}</span>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Giải thưởng -->
        @if(isset($giaiThuong) && $giaiThuong->count() > 0)
        <div class="section">
            <div class="section-title">GIẢI THƯỞNG</div>
            <div class="section-content">
                @foreach($giaiThuong as $gt)
                <div class="timeline-item">
                    <h3 class="award-title">🏆 {{ $gt->ten_giaithuong }}</h3>
                    <div class="company">{{ $gt->to_chuc }}</div>
                    <div class="duration">{{ date('m/Y', strtotime($gt->thoigian)) }}</div>

                    @if($gt->mo_ta)
                    <div class="description">{{ $gt->mo_ta }}</div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Footer -->
        <div class="cv-footer">
            <p>CV được tạo tự động từ hệ thống - {{ now()->format('d/m/Y H:i') }}</p>
        </div>
    </div>
</body>

</html>