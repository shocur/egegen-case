<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use App\Http\Requests\StoreNewsRequest;
use Illuminate\Support\Facades\Storage;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class NewsController extends Controller
{
    /**
     * Haberleri listeler ve arama yapar.
     */
    public function index(Request $request)
    {
        $query = News::query();
        // Arama parametresi varsa başlık veya içerikte ara
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', "%$search%")
                ->orWhere('content', 'like', "%$search%") ;
        }
        $news = $query->orderByDesc('created_at')->paginate(20);
        return response()->json($news);
    }

    /**
     * Yeni haber ekler.
     */
    public function store(StoreNewsRequest $request)
    {
        $data = $request->validated();
        // Görsel yükleme işlemi
        if ($request->hasFile('image')) {
            $file = $request->file('image');

            // Intervention-Image kütüphanesi
            $manager = new ImageManager(new Driver());
            $image = $manager->read($file->getRealPath());

            // 800*800 ölçülerine ayarlıyoruz
            $image->resizeDown(800, 800);

            // webp formatına dönüştürüyoruz
            $encoded = $image->toWebp(60);
            
            $filename = uniqid('news_') . '.webp';            
            Storage::disk('public')->put('news/' . $filename, $encoded);
            $data['image_path'] = 'news/' . $filename;
        }
        $news = News::create([
            'title' => $data['title'],
            'content' => $data['content'],
            'image_path' => $data['image_path'] ?? null,
            'published_at' => now(),
        ]);
        return response()->json(['message' => 'Haber başarıyla eklendi.', 'data' => $news], 201);
    }

    /**
     * Tekil haber gösterir.
     */
    public function show(string $id)
    {
        $new = News::find($id);
        if($new)
            return response()->json($new);
        else
            return response()->json(['message' => 'Haber bulunamadı.'],404);

    }

    /**
     * Haberi günceller.
     */
    public function update(StoreNewsRequest $request, string $id)
    {
        $news = News::find($id);
        if($news){
            $data = $request->validated();
            // Görsel güncellenecekse eskiyi sil, yenisini kaydet
            if ($request->hasFile('image')) {
                if ($news->image_path) {
                    Storage::disk('public')->delete($news->image_path);
                }
                
                $file = $request->file('image');

                // Intervention-Image kütüphanesi
                $manager = new ImageManager(new Driver());
                $image = $manager->read($file->getRealPath());

                // 800*800 ölçülerine ayarlıyoruz
                $image->resizeDown(800, 800);

                // webp formatına dönüştürüyoruz
                $encoded = $image->toWebp(60);
                
                $filename = uniqid('news_') . '.webp';
                Storage::disk('public')->put('news/' . $filename, $encoded);
                $data['image_path'] = 'news/' . $filename;
            }
            $news->update([
                'title' => $data['title'],
                'content' => $data['content'],
                'image_path' => $data['image_path'] ?? $news->image_path,
            ]);
            return response()->json(['message' => 'Haber başarıyla güncellendi.', 'data' => $news]);
        }else{
            return response()->json(['message' => 'Haber bulunamadı.'],404);
        }
    }

    /**
     * Haberi siler.
     */
    public function destroy(string $id)
    {
        $news = News::find($id);
        if($news){
        if ($news->image_path) {
            Storage::disk('public')->delete($news->image_path);
        }
        $news->delete();
            return response()->json(['message' => 'Haber başarıyla silindi.']);
        }else{
            return response()->json(['message' => 'Haber bulunamadı.'],404);
        }
    }
}