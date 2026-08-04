<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectPortfolioImage;

class PortfolioController extends Controller
{
    public function show(string $slug)
    {
        $project = Project::where('slug', $slug)
            ->where('is_active', 'active')
            ->firstOrFail();

        $images = \App\Models\ProjectPortfolioImage::where('project_id', $project->id)
            ->orderBy('sort_order')
            ->get();

        // Pre-build JS-safe image data array for the gallery
        $imageDataJson = $images->values()->map(function ($img, $i) use ($project) {
            $ext = pathinfo($img->image_path, PATHINFO_EXTENSION);
            return [
                'src'      => asset($img->image_path),
                'filename' => 'portfolio-' . $project->slug . '-' . ($i + 1) . '.' . $ext,
            ];
        })->values()->toArray();

        return view('portfolio.gallery', compact('project', 'images', 'imageDataJson'));
    }

    public function downloadPdf(string $slug)
    {
        $project = Project::where('slug', $slug)->firstOrFail();

        $images = ProjectPortfolioImage::where('project_id', $project->id)
            ->orderBy('sort_order')
            ->get();

        $imagesData = [];
        foreach ($images as $img) {
            $path = public_path($img->image_path);
            if (file_exists($path)) {
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                $imagesData[] = 'data:image/' . $type . ';base64,' . base64_encode($data);
            }
        }

        $html = view('portfolio.pdf', compact('project', 'imagesData'))->render();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html);
        $pdf->setPaper('a4', 'portrait');

        return $pdf->download("portfolio-{$project->slug}.pdf");
    }
}
