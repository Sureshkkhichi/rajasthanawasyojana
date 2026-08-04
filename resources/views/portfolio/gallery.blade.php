<!DOCTYPE html>
<html lang="hi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $project->name }} — Portfolio Gallery</title>
    <meta name="description" content="Portfolio images of {{ $project->name }} project.">

    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <!-- Remix Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --primary: #c0392b;
            --primary-dark: #96281b;
            --bg-light: #f8f9fa;
            --card-bg: #ffffff;
            --card-border: #e2e8f0;
            --text-dark: #1e293b;
            --text-muted: #64748b;
        }

        * {
            box-sizing: border-box;
        }

        body {
            background: var(--bg-light);
            color: var(--text-dark);
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ===== HERO HEADER ===== */
        .hero-header {
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 36px 0 28px;
            position: relative;
            overflow: hidden;
            flex-shrink: 0;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
        }

        .hero-header::before {
            content: '';
            position: absolute;
            top: -60px;
            left: -60px;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(192, 57, 43, 0.06) 0%, transparent 70%);
            pointer-events: none;
        }

        .hero-header::after {
            content: '';
            position: absolute;
            bottom: -80px;
            right: -80px;
            width: 350px;
            height: 350px;
            background: radial-gradient(circle, rgba(192, 57, 43, 0.04) 0%, transparent 70%);
            pointer-events: none;
        }

        .project-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(192, 57, 43, 0.08);
            border: 1px solid rgba(192, 57, 43, 0.2);
            color: #c0392b;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            padding: 5px 14px;
            border-radius: 50px;
            margin-bottom: 14px;
        }

        .project-title {
            font-size: clamp(1.6rem, 4vw, 2.6rem);
            font-weight: 700;
            letter-spacing: -0.5px;
            margin-bottom: 8px;
            color: #0f172a;
        }

        .project-meta {
            color: var(--text-muted);
            font-size: 14px;
        }

        .share-btn {
            background: #ffffff;
            border: 1px solid #cbd5e1;
            color: #334155;
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }

        .share-btn:hover {
            background: #f1f5f9;
            border-color: #94a3b8;
            color: #0f172a;
        }

        .share-btn.copied {
            background: rgba(39, 174, 96, 0.1);
            border-color: rgba(39, 174, 96, 0.4);
            color: #27ae60;
        }

        /* ===== GALLERY GRID ===== */
        .gallery-section {
            padding: 48px 0 80px;
            flex: 1 0 auto;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 14px;
        }

        .gallery-item {
            position: relative;
            border-radius: 14px;
            overflow: hidden;
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            cursor: pointer;
            aspect-ratio: 4/3;
            box-shadow: 0 2px 4px rgba(0,0,0,0.04);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .gallery-item:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px -4px rgba(0, 0, 0, 0.12), 0 0 0 1px rgba(192, 57, 43, 0.2);
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.35s ease;
        }

        .gallery-item:hover img {
            transform: scale(1.05);
        }

        .gallery-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.6) 0%, transparent 60%);
            opacity: 0;
            transition: opacity 0.25s ease;
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            padding: 16px;
        }

        .gallery-item:hover .gallery-overlay {
            opacity: 1;
        }

        .overlay-expand {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: #fff;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            transition: background 0.2s;
        }

        .overlay-expand:hover {
            background: rgba(192, 57, 43, 0.8);
        }

        .img-index-badge {
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(8px);
            color: rgba(255, 255, 255, 0.9);
            font-size: 11px;
            padding: 3px 10px;
            border-radius: 50px;
            font-weight: 500;
        }

        /* ===== EMPTY STATE ===== */
        .empty-state {
            text-align: center;
            padding: 80px 20px;
            color: var(--text-muted);
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 16px;
            display: block;
            opacity: 0.3;
        }

        /* ===== LIGHTBOX MODAL (WHITE THEME) ===== */
        .lightbox-modal {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 9999;
            background: #ffffff;
            flex-direction: column;
        }

        .lightbox-modal.active {
            display: flex;
        }

        .lightbox-top-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 24px;
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            flex-shrink: 0;
        }

        .lightbox-title {
            font-size: 15px;
            font-weight: 600;
            color: #0f172a;
        }

        .lightbox-counter {
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            padding: 4px 14px;
            border-radius: 50px;
            font-size: 13px;
            color: #475569;
            font-weight: 600;
        }

        .lightbox-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .lb-action-btn {
            background: #f8fafc;
            border: 1px solid #cbd5e1;
            color: #334155;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
        }

        .lb-action-btn:hover {
            background: #f1f5f9;
            color: #0f172a;
            border-color: #94a3b8;
        }

        .lb-action-btn.download-btn:hover {
            background: rgba(192, 57, 43, 0.08);
            border-color: rgba(192, 57, 43, 0.3);
            color: #c0392b;
        }

        .lb-action-btn.close-btn:hover {
            background: #fee2e2;
            border-color: #fca5a5;
            color: #dc2626;
        }

        /* Swiper in lightbox */
        .lightbox-swiper-wrap {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 60px;
            min-height: 0;
            background: #f8f9fa;
        }

        .lightbox-swiper {
            width: 100%;
            height: 100%;
            max-height: calc(100vh - 180px);
        }

        .lightbox-swiper .swiper-slide {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .lightbox-swiper .swiper-slide img {
            max-width: 100%;
            max-height: calc(100vh - 200px);
            object-fit: contain;
            border-radius: 10px;
            user-select: none;
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.15);
        }

        .lightbox-swiper .swiper-button-next,
        .lightbox-swiper .swiper-button-prev {
            width: 48px;
            height: 48px;
            background: #ffffff;
            border: 1px solid #cbd5e1;
            border-radius: 12px;
            color: #1e293b;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: all 0.2s;
        }

        .lightbox-swiper .swiper-button-next:hover,
        .lightbox-swiper .swiper-button-prev:hover {
            background: #ffffff;
            color: #c0392b;
            border-color: rgba(192, 57, 43, 0.4);
            box-shadow: 0 6px 16px rgba(192, 57, 43, 0.15);
        }

        .lightbox-swiper .swiper-button-next::after,
        .lightbox-swiper .swiper-button-prev::after {
            font-size: 16px;
            font-weight: 700;
        }

        /* Thumbnail strip */
        .lightbox-thumbnails {
            flex-shrink: 0;
            padding: 12px 24px;
            background: #ffffff;
            border-top: 1px solid #e2e8f0;
            overflow-x: auto;
        }

        .thumb-strip {
            display: flex;
            gap: 8px;
            justify-content: center;
            min-width: max-content;
        }

        .thumb-item {
            width: 56px;
            height: 42px;
            border-radius: 6px;
            overflow: hidden;
            border: 2px solid #e2e8f0;
            cursor: pointer;
            transition: all 0.2s;
            flex-shrink: 0;
        }

        .thumb-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .thumb-item.active {
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(192, 57, 43, 0.2);
        }

        .thumb-item:hover {
            border-color: #94a3b8;
        }

        /* ===== FOOTER ===== */
        .gallery-footer {
            text-align: center;
            padding: 24px;
            background: #ffffff;
            color: var(--text-muted);
            font-size: 12px;
            border-top: 1px solid #e2e8f0;
            margin-top: auto;
            flex-shrink: 0;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 786px) {
            .gallery-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .gallery-item {
                aspect-ratio: 16/10;
            }

            .lightbox-swiper-wrap {
                padding: 0 50px;
            }

            .hero-header {
                padding: 28px 0 20px;
            }
        }


        @media (max-width: 480px) {
            .gallery-grid {
                grid-template-columns: 1fr;
                gap: 12px;
            }
        }
    </style>
</head>

<body>

    <!-- ===== HERO HEADER ===== -->
    <header class="hero-header">
        <div class="container">
            <div class="row align-items-center gy-3">
                <div class="col-lg-8">
                    <div class="project-badge">
                        <i class="ri-building-2-line"></i> Project Portfolio
                    </div>
                    <h1 class="project-title">{{ $project->name }}</h1>
                    <p class="project-meta">
                        <i class="ri-gallery-line me-1"></i>
                        {{ $images->count() }} {{ $images->count() === 1 ? 'image' : 'images' }} in this portfolio
                        @if($project->city)
                            &nbsp;·&nbsp; <i class="ri-map-pin-line me-1"></i>{{ $project->city }}
                        @endif
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <button class="share-btn" id="copyLinkBtn" onclick="copyLink()">
                        <i class="ri-link-m" id="copyIcon"></i>
                        <span id="copyText">Copy Link</span>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- ===== GALLERY SECTION ===== -->
    <section class="gallery-section">
        <div class="container">
            @if($images->count() > 0)
                <div class="gallery-grid" id="galleryGrid">
                    @foreach($images as $index => $img)
                        <div class="gallery-item" onclick="openLightbox({{ $index }})" data-index="{{ $index }}">
                            <img src="{{ asset($img->image_path) }}" alt="{{ $project->name }} Portfolio Image {{ $index + 1 }}"
                                loading="{{ $index < 6 ? 'eager' : 'lazy' }}">
                            <div class="gallery-overlay">
                                <span class="img-index-badge">{{ $index + 1 }} / {{ $images->count() }}</span>
                                <div class="overlay-expand">
                                    <i class="ri-fullscreen-line"></i>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <i class="ri-gallery-line"></i>
                    <h5 style="color:rgba(255,255,255,0.3); font-weight:500;">No portfolio images available yet.</h5>
                </div>
            @endif
        </div>
    </section>

    <!-- ===== LIGHTBOX MODAL ===== -->
    <div class="lightbox-modal" id="lightboxModal">
        <!-- Top Bar -->
        <div class="lightbox-top-bar">
            <div class="lightbox-title">
                <i class="ri-building-2-line me-1" style="color:#e74c3c;"></i>
                {{ $project->name }}
            </div>
            <div class="lightbox-counter" id="lbCounter">1 / {{ $images->count() }}</div>
            <div class="lightbox-actions">
                <a href="#" class="lb-action-btn download-btn" id="downloadBtn" download title="Download Image">
                    <i class="ri-download-2-line"></i>
                </a>
                <button class="lb-action-btn close-btn" onclick="closeLightbox()" title="Close (Esc)">
                    <i class="ri-close-line"></i>
                </button>
            </div>
        </div>

        <!-- Swiper -->
        <div class="lightbox-swiper-wrap">
            <div class="swiper lightbox-swiper" id="lightboxSwiper">
                <div class="swiper-wrapper">
                    @foreach($images as $index => $img)
                        <div class="swiper-slide">
                            <img src="{{ asset($img->image_path) }}" alt="{{ $project->name }} Image {{ $index + 1 }}"
                                data-src="{{ asset($img->image_path) }}"
                                data-filename="portfolio-{{ $project->slug }}-{{ $index + 1 }}.{{ pathinfo($img->image_path, PATHINFO_EXTENSION) }}"
                                loading="lazy">
                        </div>
                    @endforeach
                </div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        </div>

        <!-- Thumbnails -->
        @if($images->count() > 1)
            <div class="lightbox-thumbnails">
                <div class="thumb-strip" id="thumbStrip">
                    @foreach($images as $index => $img)
                        <div class="thumb-item {{ $index === 0 ? 'active' : '' }}" id="thumb-{{ $index }}"
                            onclick="goToSlide({{ $index }})">
                            <img src="{{ asset($img->image_path) }}" alt="thumb {{ $index + 1 }}" loading="lazy">
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <!-- ===== FOOTER ===== -->
    <footer class="gallery-footer">
        © {{ now()->year }} {{ $project->name }} · {{ config('constants.site_name') }}
    </footer>

    <!-- ===== SCRIPTS ===== -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        // Image data for download
        const imageData = @json($imageDataJson);

        const totalImages = {{ $images->count() }};
        let lightboxSwiper = null;

        // ====== Init Swiper ======
        function initSwiper(startIndex = 0) {
            if (lightboxSwiper) {
                lightboxSwiper.slideTo(startIndex, 0);
                return;
            }
            lightboxSwiper = new Swiper('#lightboxSwiper', {
                initialSlide: startIndex,
                loop: totalImages > 1,
                keyboard: { enabled: true },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                on: {
                    slideChange: function () {
                        updateLightboxUI(this.realIndex);
                    }
                }
            });
        }

        function updateLightboxUI(realIndex) {
            // Counter
            document.getElementById('lbCounter').textContent = (realIndex + 1) + ' / ' + totalImages;
            // Download button
            if (imageData[realIndex]) {
                document.getElementById('downloadBtn').href = imageData[realIndex].src;
                document.getElementById('downloadBtn').download = imageData[realIndex].filename;
            }
            // Thumbnails
            document.querySelectorAll('.thumb-item').forEach((t, i) => {
                t.classList.toggle('active', i === realIndex);
            });
            // Scroll active thumb into view
            const activeThumb = document.getElementById('thumb-' + realIndex);
            if (activeThumb) {
                activeThumb.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
            }
        }

        // ====== Open / Close Lightbox ======
        function openLightbox(index) {
            const modal = document.getElementById('lightboxModal');
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
            initSwiper(index);
            updateLightboxUI(index);
        }

        function closeLightbox() {
            document.getElementById('lightboxModal').classList.remove('active');
            document.body.style.overflow = '';
        }

        function goToSlide(index) {
            if (lightboxSwiper) {
                lightboxSwiper.slideToLoop(index, 300);
            }
        }

        // ====== Keyboard ======
        document.addEventListener('keydown', (e) => {
            const modal = document.getElementById('lightboxModal');
            if (!modal.classList.contains('active')) return;
            if (e.key === 'Escape') closeLightbox();
        });

        // ====== Copy Link ======
        function copyLink() {
            const url = window.location.href;
            navigator.clipboard.writeText(url).then(() => {
                const btn = document.getElementById('copyLinkBtn');
                const icon = document.getElementById('copyIcon');
                const text = document.getElementById('copyText');
                btn.classList.add('copied');
                icon.className = 'ri-check-line';
                text.textContent = 'Link Copied!';
                setTimeout(() => {
                    btn.classList.remove('copied');
                    icon.className = 'ri-link-m';
                    text.textContent = 'Copy Link';
                }, 2500);
            });
        }
    </script>
</body>

</html>