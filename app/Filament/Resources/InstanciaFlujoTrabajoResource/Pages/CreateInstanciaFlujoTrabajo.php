<?php

namespace App\Filament\Resources\InstanciaFlujoTrabajoResource\Pages;

use App\Enums\GlobalEnums;
use App\Filament\Resources\InstanciaFlujoTrabajoResource;
use App\Filament\Traits\FilamentDuplicateCheckTrait;
use App\Models\FlujoTrabajo;
use App\Models\HistoricoTarea;
use App\Models\InstanciaFlujoTrabajo;
use App\Models\InstanciaPasoFlujo;
use App\Models\InstanciaTareaFlujo;
use App\Models\PasoFlujo;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;

class CreateInstanciaFlujoTrabajo extends CreateRecord
{
    use FilamentDuplicateCheckTrait;

    protected static string $resource = InstanciaFlujoTrabajoResource::class;

    protected $pasos;

    protected function beforeCreate(): void
    {

        $cantidadPasosFlujo = PasoFlujo::where('id', $this->data['flujo_trabajo_id'])
            ->where('deleted_at', null)
            ->count();
        if ($cantidadPasosFlujo == 0) {
            Notification::make()
                ->warning()
                ->title('Error en la creación')
                ->body('No hay pasos parametrizados para este flujo.')
                ->send();
            $this->halt();
        }


        // Almacenar los datos de pasos y tareas para crear después
        $this->pasos = collect();

        // Preparar datos de pasos y tareas
        $pasosSinTareas = [];

        $flujoTrabajo = FlujoTrabajo::find($this->data['flujo_trabajo_id']);

        foreach ($flujoTrabajo->pasosFlujo as $pasoOriginal) {
            // Verificar si el paso tiene tareas
            if ($pasoOriginal->tareasFlujo->isEmpty()) {
                $pasosSinTareas[] = $pasoOriginal->nombre;
                continue;
            }

            if ($pasoOriginal->deleted_at ==null ) {
                $this->pasos->push([
                    'paso' => [
                        'nombre' => $pasoOriginal->nombre,
                        'descripcion' => $pasoOriginal->descripcion,
                        'orden' => $pasoOriginal->orden,
                        'es_final' => $pasoOriginal->es_final,
                        'estado' => 1
                    ],
                    'tareas' => $pasoOriginal->tareasFlujo->map(function ($tarea) {
                        if($tarea->deleted_at==null){
                            return [
                                'titulo' => $tarea->titulo,
                                'descripcion' => $tarea->descripcion,
                                'orden' => $tarea->orden,
                                'es_final' => $tarea->es_final,
                                'es_editable' => $tarea->es_editable,
                                'estado' => GlobalEnums::PENDIENTE_INSTANCIA_TAREA->value(),
                            ];
                        }
                        return [];
                    })->toArray()
                ]);
            }
        }

        // Si se encontraron pasos sin tareas, mostrar notificación y detener
        if (!empty($pasosSinTareas)) {
            DB::rollBack();
            Notification::make()
                ->warning()
                ->title('Error en la creación')
                ->body('Los siguientes pasos no tienen tareas asignadas: <br>- ' . implode("<br>- ", array_map(fn($paso) => $paso, $pasosSinTareas)))
                ->send();
            $this->halt();
        }


        // Verificar duplicados primero
        $this->checkDuplicatesAndRestoreDeleted($this->data, ['nombre', 'flujo_trabajo_id'], 'nombre');

        DB::beginTransaction();
        try {
            // Obtener pasos flujo
            $flujoTrabajo = FlujoTrabajo::findOrFail($this->data['flujo_trabajo_id']);
        } catch (\Exception $e) {
            // Para otros errores, mostrar la notificación
            DB::rollBack();
            Notification::make()
                ->danger()
                ->title('Error en la validación')
                ->body('No se pudo crear el flujo: ' . $e->getMessage())
                ->send();
            $this->halt();
        }
    }

    protected function afterCreate(): void
    {
        try {
            foreach ($this->pasos as $pasoData) {
                $instanciaPaso = InstanciaPasoFlujo::create([
                    ...$pasoData['paso'],
                    'instancia_flujo_trabajo_id' => $this->record->id,
                ]);

                // Crear las instancias de tareas
                foreach ($pasoData['tareas'] as $tareaData) {
                    $instanciaTarea = InstanciaTareaFlujo::create([
                        ...$tareaData,
                        'instancia_paso_flujo_id' => $instanciaPaso->id,
                    ]);

                    HistoricoTarea::create([
                        'instancia_tareas_flujo_id' => $instanciaTarea->id,
                        'descripcion' => 'Creación mediante proceso automático',
                        'user_id' => Auth::user()->id,
                    ]);
                }
            }

            DB::commit();

            Notification::make()
                ->success()
                ->title('Flujo creado correctamente')
                ->body('Se han creado todas las instancias necesarias.')
                ->send();
        } catch (\Exception $e) {
            DB::rollBack();

            Notification::make()
                ->danger()
                ->title('Error al crear el flujo')
                ->body('Ocurrió un error: ' . $e->getMessage())
                ->send();
            $this->halt();
        }
    }
    protected function getCreatedNotification(): ?Notification
    {
        return null;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('edit', ['record' => $this->record->id]);
    }
}
