<?php


namespace Combindma\Gallery\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\File;

class Gallery extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $guarded = [];

    protected $table = 'gallery';

    protected static function newFactory()
    {
        return \Combindma\Gallery\Database\Factories\GalleryFactory::new();
    }

    public function getFileNameAttribute()
    {
        return $this->getFirstMedia('images')?->file_name;
    }

    public function getFileSizeAttribute()
    {
        return $this->getFirstMedia('images')?->human_readable_size;
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images')
            ->withResponsiveImages()
            ->singleFile()
            ->acceptsFile(function (File $file) {
                return ($file->mimeType === 'image/jpeg') or ($file->mimeType === 'image/jpg') or ($file->mimeType === 'image/png') or ($file->mimeType === 'image/gif');
            });
    }

    public function addImage($file)
    {
        $this->addMedia($file)->toMediaCollection('images', 'images');

        return $this;
    }

    public function image()
    {
        return $this->getFirstMedia('images');
    }

    public function image_url()
    {
        return $this->getFirstMediaUrl('images');
    }
}
