<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attachment;

class AttachmentsSeeder extends Seeder
{
    public function run()
    {
        // Crear varios attachments
        Attachment::factory(30)->create();
    }
}
