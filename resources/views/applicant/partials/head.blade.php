<head>
    <!-- ✅ CSRF Token - QUAN TRỌNG -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>JobIT - Ứng viên</title>

    <!-- Favicons -->
    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Poppins:wght@400;600&family=Nunito:wght@400;700&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Main CSS -->
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
    <!-- Summernote CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">

    <!-- Summernote JS -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>

    <!-- Tailwind CDN & Custom Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            blue: '#1976D2',
                            blueLight: '#E3F2FD',
                            blueDark: '#0D47A1',
                            gray: '#F5F7FA',
                            grayDark: '#90A4AE',
                            accent: '#FFB300',
                            red: '#E53935'
                        }
                    },
                    boxShadow: {
                        soft: '0 6px 24px rgba(25,118,210,0.10)'
                    }
                }
            }
        }
    </script>
    <style>
        .thin-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(25, 118, 210, 0.15);
        }

        .thin-scrollbar:hover::-webkit-scrollbar-thumb {
            background: rgba(25, 118, 210, 0.25);
        }

        .gradient-hero {
            background: linear-gradient(120deg, #E3F2FD 60%, #ffffff 100%);
        }

        .chip {
            @apply text-xs px-3 py-1 rounded-full bg-brand-gray border border-brand-blue/10 hover:bg-brand-blue/10 text-brand-blue cursor-pointer transition;
        }

        .chip.active {
            @apply ring-2 ring-brand-accent;
        }

        .job-card {
            @apply bg-white border-2 border-brand-blue/30 rounded-xl p-5 flex flex-col justify-between h-full shadow-soft transition hover:shadow-lg relative;
        }

        .job-title {
            @apply text-base sm:text-lg font-semibold hover:underline text-brand-blue;
        }

        .job-meta {
            @apply text-sm text-brand-blue/70 mt-0.5;
        }

        .job-tags {
            @apply mt-2 flex flex-wrap gap-2 text-xs;
        }

        .job-tags span {
            @apply px-2.5 py-1 rounded-full bg-brand-gray border border-brand-blue/10 text-brand-blue;
        }

        .job-salary {
            @apply text-sm sm:text-base font-semibold text-brand-blue;
        }

        .btn-primary {
            @apply inline-flex items-center justify-center h-8 px-3 bg-brand-accent hover:bg-yellow-400 font-semibold text-white transition rounded-lg text-sm;
        }

        .save-btn {
            @apply absolute top-4 right-4 border-none bg-transparent p-0 m-0 hover:bg-brand-blue/10 rounded-full transition flex items-center justify-center;
        }

        .save-btn.active svg {
            color: #E53935 !important;
        }

        .save-btn svg {
            transition: color 0.2s;
        }

        .job-media {
            @apply w-12 h-12 rounded-xl overflow-hidden bg-brand-gray flex items-center justify-center;
        }

        @media (max-width: 640px) {
            #jobList {
                grid-template-columns: 1fr !important;
            }
        }
    </style>
</head>