<?php

namespace Database\Seeders;

use App\Models\ActividadEconomica;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ActividadEconomicaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Path to the CSV file
        $csvFile = database_path('seeders/data/actividad_economica.csv');
        
        // Check if the file exists
        if (!File::exists($csvFile)) {
            echo "CSV file not found: $csvFile\n";
            return;
        }
        
        // Read the CSV file
        $csvData = File::get($csvFile);
        $rows = explode("\n", $csvData);
        
        // Remove the header row
        array_shift($rows);
        
        // Process each row
        foreach ($rows as $row) {
            // Skip empty rows
            if (empty(trim($row))) {
                continue;
            }
            
            // Split the row by comma
            $columns = str_getcsv($row);
            
            // Ensure we have both codigo and descripcion
            if (count($columns) >= 2) {
                $codigo = trim($columns[0]);
                $descripcion = trim($columns[1]);
                
                // Create or update the actividad economica
                ActividadEconomica::firstOrCreate(
                    ['codigo' => $codigo],
                    ['descripcion' => $descripcion]
                );
            }
        }
    }
}