<?php

namespace App\Http\Controllers;

use App\Models\SecondaryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SecondaryImageController extends Controller
{
    public function create(Request $request)
    {
        $this->validate($request, [
            'images.*' => 'image'
        ]);
        $counter = 0;

        foreach ($request->file('images') as $image) {
            $ext = $image->getClientOriginalExtension();
            $filename = time() . '-' . $counter . '.' . $ext;
            $image->move('uploads/secondary_images/', $filename);
            $path = '/uploads/secondary_images/' . $filename;

            SecondaryImage::create([
                'project_id' => $request->project_id ?? null,
                'item_id' => $request->item_id ?? null,
                'path' => $path,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $counter++;
        }

        return redirect()->back()->with('success', 'Secondary Images uploaded successfully...');
    }

    public function destroy(SecondaryImage $secondary_image)
    {
        $path = public_path($secondary_image->path);
        File::delete($path);
        $secondary_image->delete();

        return redirect()->back()->with('danger', 'Secondary Image deleted...');
    }
}
