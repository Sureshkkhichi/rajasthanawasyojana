<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $project->name }} - Portfolio PDF</title>
    <style>
        @page {
            margin: 20px 25px;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #1e293b;
            margin: 0;
            padding: 0;
            background: #ffffff;
        }
        .header {
            text-align: center;
            padding-bottom: 15px;
            border-bottom: 2px solid #c0392b;
            margin-bottom: 20px;
        }
        .title {
            font-size: 22px;
            font-weight: bold;
            color: #0f172a;
            margin: 0 0 5px 0;
        }
        .subtitle {
            font-size: 13px;
            color: #c0392b;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 4px;
        }
        .meta {
            font-size: 11px;
            color: #64748b;
        }
        .image-container {
            text-align: center;
            margin-bottom: 25px;
            page-break-inside: avoid;
        }
        .portfolio-img {
            max-width: 100%;
            max-height: 520px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        .caption {
            font-size: 11px;
            color: #64748b;
            margin-top: 6px;
        }
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 20px;
            font-size: 10px;
            color: #94a3b8;
            text-align: center;
            border-top: 1px solid #f1f5f9;
            padding-top: 5px;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>

    <div class="header">
        <div class="subtitle">PROJECT PORTFOLIO GALLERY</div>
        <div class="title">{{ $project->name }}</div>
        <div class="meta">
            @if($project->city) Location: {{ $project->city }} &nbsp;|&nbsp; @endif
            Total Images: {{ count($imagesData) }} &nbsp;|&nbsp; Generated on: {{ date('d M Y') }}
        </div>
    </div>

    @forelse($imagesData as $index => $base64Img)
        <div class="image-container">
            <img src="{{ $base64Img }}" class="portfolio-img" alt="Portfolio Image {{ $index + 1 }}">
            <div class="caption">Image {{ $index + 1 }} of {{ count($imagesData) }}</div>
        </div>
        @if(!$loop->last && ($index + 1) % 2 == 0)
            <div class="page-break"></div>
        @endif
    @empty
        <div style="text-align: center; padding: 50px; color: #94a3b8;">
            No portfolio images uploaded for this project.
        </div>
    @endforelse

    <div class="footer">
        {{ $project->name }} &bull; Rajasthan Awas Yojana
    </div>

</body>
</html>
