<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ModifyRelationsAddPivots extends Migration
{
    public function up()
    {
        // 1) Crear tabla pivote cliente_representante
        if (!Schema::hasTable('cliente_representante')) {
            Schema::create('cliente_representante', function (Blueprint $table) {
                $table->unsignedBigInteger('cliente_id');
                $table->unsignedBigInteger('representante_id');
                $table->timestamps();

                $table->primary(['cliente_id', 'representante_id']);
                $table->index('representante_id', 'cr_representante_idx');

                $table->foreign('cliente_id', 'cr_cliente_fk')
                      ->references('id')->on('clientes')->onDelete('cascade');
                $table->foreign('representante_id', 'cr_representante_fk')
                      ->references('id')->on('representantes')->onDelete('cascade');
            });
        }

        // 2) Crear tabla pivote cliente_auditor
        if (!Schema::hasTable('cliente_auditor')) {
            Schema::create('cliente_auditor', function (Blueprint $table) {
                $table->unsignedBigInteger('cliente_id');
                $table->unsignedBigInteger('auditor_id');
                $table->timestamps();

                $table->primary(['cliente_id', 'auditor_id']);
                $table->index('auditor_id', 'ca_auditor_idx');

                $table->foreign('cliente_id', 'ca_cliente_fk')
                      ->references('id')->on('clientes')->onDelete('cascade');
                $table->foreign('auditor_id', 'ca_auditor_fk')
                      ->references('id')->on('auditores')->onDelete('cascade');
            });
        }

        // 3) Migrar datos de representantes.cliente_id --> cliente_representante (si existe columna)
        if (Schema::hasColumn('representantes', 'cliente_id')) {
            DB::table('representantes')->select('id', 'cliente_id')
                ->whereNotNull('cliente_id')
                ->orderBy('id')
                ->chunkById(200, function ($rows) {
                    $inserts = [];
                    foreach ($rows as $r) {
                        $inserts[] = [
                            'cliente_id' => $r->cliente_id,
                            'representante_id' => $r->id,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                    if (!empty($inserts)) {
                        DB::table('cliente_representante')->insertOrIgnore($inserts);
                    }
                });

            // 4) Eliminar FK y columna representantes.cliente_id
            Schema::table('representantes', function (Blueprint $table) {
                try {
                    $table->dropForeign(['cliente_id']);
                } catch (\Exception $e) {
                    // ignorar si no existe FK
                }
                try {
                    $table->dropColumn('cliente_id');
                } catch (\Exception $e) {
                    // ignorar si no existe columna
                }
            });
        }

        // 5) Quitar UNIQUE en tareas_clientes (tarea_id, cliente_id)
        if (Schema::hasTable('tareas_clientes')) {
            Schema::table('tareas_clientes', function (Blueprint $table) {
                // Intentar dropear por nombre conocido
                try {
                    $table->dropUnique('tareas_clientes_tarea_id_cliente_id_unique');
                } catch (\Exception $e) {
                    // intentar dropear por columnas (si Laravel lo acepta)
                    try { $table->dropUnique(['tarea_id', 'cliente_id']); } catch (\Exception $e2) {
                        // Si no se puede, ignorar: puede que no exista unique
                    }
                }
            });
        }

        // 6) Agregar índice en tareas_instancia_valores.valor_fecha para mejorar consultas por fecha
        if (Schema::hasTable('tareas_instancia_valores')) {
            Schema::table('tareas_instancia_valores', function (Blueprint $table) {
                try {
                    $table->index('valor_fecha', 'tareas_instancia_valores_valor_fecha_index');
                } catch (\Exception $e) {
                    // ignorar si ya existe o si no es posible
                }
            });
        }
    }

    public function down()
    {
        // 1) Restaurar columna representantes.cliente_id si no existe
        if (!Schema::hasColumn('representantes', 'cliente_id')) {
            Schema::table('representantes', function (Blueprint $table) {
                $table->unsignedBigInteger('cliente_id')->nullable()->after('id');
            });

            if (Schema::hasTable('cliente_representante')) {
                // Poblar representantes.cliente_id desde cliente_representante (primer mapping)
                $rows = DB::table('cliente_representante')
                    ->select('representante_id', 'cliente_id')
                    ->orderBy('representante_id')
                    ->get();

                $firstByRep = [];
                foreach ($rows as $r) {
                    if (!isset($firstByRep[$r->representante_id])) {
                        $firstByRep[$r->representante_id] = $r->cliente_id;
                    }
                }
                foreach ($firstByRep as $repId => $clienteId) {
                    DB::table('representantes')->where('id', $repId)->update(['cliente_id' => $clienteId]);
                }

                try {
                    Schema::table('representantes', function (Blueprint $table) {
                        $table->foreign('cliente_id', 'representantes_cliente_id_foreign')
                              ->references('id')->on('clientes')->onDelete('cascade');
                    });
                } catch (\Exception $e) {
                    // ignorar si no se puede crear FK
                }
            }
        }

        // 2) Re-crear UNIQUE en tareas_clientes (tarea_id, cliente_id) si es necesario
        if (Schema::hasTable('tareas_clientes')) {
            Schema::table('tareas_clientes', function (Blueprint $table) {
                try {
                    $table->unique(['tarea_id', 'cliente_id'], 'tareas_clientes_tarea_id_cliente_id_unique');
                } catch (\Exception $e) {
                    // ignorar si no se puede crear
                }
            });
        }

        // 3) Eliminar índice en tareas_instancia_valores.valor_fecha si existe
        if (Schema::hasTable('tareas_instancia_valores')) {
            Schema::table('tareas_instancia_valores', function (Blueprint $table) {
                try {
                    $table->dropIndex('tareas_instancia_valores_valor_fecha_index');
                } catch (\Exception $e) {
                    try { $table->dropIndex(['valor_fecha']); } catch (\Exception $e2) {}
                }
            });
        }

        // 4) Eliminar pivotes (nota: esto eliminará los datos de relación)
        if (Schema::hasTable('cliente_auditor')) {
            Schema::dropIfExists('cliente_auditor');
        }
        if (Schema::hasTable('cliente_representante')) {
            Schema::dropIfExists('cliente_representante');
        }
    }
}
