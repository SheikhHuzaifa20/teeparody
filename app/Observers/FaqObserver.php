<?php

namespace App\Observers;

use App\Models\Faq;
use Illuminate\Support\Facades\File;

class FaqObserver
{
    public function created(Faq $faq): void
    {
        //
    }

    public function updated(Faq $faq): void
    {
        if ($faq->isDirty('image')) {
            $oldImage = $faq->getOriginal('image');
            if ($oldImage && File::exists(public_path($oldImage))) {
                File::delete(public_path($oldImage));
            }
        }
    }

    public function deleted(Faq $faq): void
    {
        if ($faq->isForceDeleting()) {
            if ($faq->image && File::exists(public_path($faq->image))) {
                File::delete(public_path($faq->image));
            }
        }
    }

    public function restored(Faq $faq): void
    {
        //
    }

    public function forceDeleted(Faq $faq): void
    {
        //
    }
}