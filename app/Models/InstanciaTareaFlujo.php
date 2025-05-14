<?php

namespace App\Models;

use App\Enums\GlobalEnums;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class InstanciaTareaFlujo extends Model
{
    use  HasFactory, SoftDeletes;
    protected $table = 'instancia_tareas_flujo';


    protected $fillable = [
        'titulo',
        'descripcion',
        'fecha_inicio',
        'fecha_vencimiento',
        'orden',
        'ruta_archivo',
        'es_final',
        'es_editable',
        'instancia_paso_flujo_id',
        'estado',
        'asignado_a',
        'asignado_por',

    ];

    protected static function booted()
    {
        static::updated(function ($model) {
            $changes = $model->getDirty();

            foreach ($changes as $field => $newValue) {
                // Ignoramos campos del sistema y booleanos que no han cambiado realmente
                if ($field === 'updated_at') continue;

                $oldValue = $model->getOriginal($field);

                // Convertimos a booleano para comparación si es campo es_final o es_editable
                if (in_array($field, ['es_final', 'es_editable'])) {
                    $oldValue = (bool)$oldValue;
                    $newValue = (bool)$newValue;

                    // Si los valores son iguales después de la conversión, saltamos
                    if ($oldValue === $newValue) continue;
                }

                $mensaje = static::getChangeMessage($field, $oldValue, $newValue, $model);

                HistoricoTarea::create([
                    'descripcion' => $mensaje,
                    'instancia_tareas_flujo_id' => $model->id,
                    'user_id' => Auth::user()->id
                ]);
            }
        });

        static::saving(function ($model) {
            if ($model->ruta_archivo) {
                $extension = pathinfo($model->ruta_archivo, PATHINFO_EXTENSION);
                $allowedExtensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'];

                if (!in_array(strtolower($extension), $allowedExtensions)) {
                    throw new \Exception('Tipo de archivo no permitido');
                }
            }
        });
    }



    //Funciones del modelo
    protected static function getChangeMessage($field, $oldValue, $newValue, $model): string
    {
        return match ($field) {
            'titulo' => "Se modificó el título de '{$oldValue}' a '{$newValue}'",
            'descripcion' => "Se actualizó la descripción de la tarea de '{$oldValue}' a '{$newValue}'",
            'fecha_inicio' => static::getDateChangeMessage('fecha de inicio', $oldValue, $newValue),
            'fecha_vencimiento' => static::getDateChangeMessage('fecha de vencimiento', $oldValue, $newValue),
            'estado' => static::getEstadoChangeMessage($oldValue, $newValue, $model),
            'asignado_a' => static::getAsignadoChangeMessage($oldValue, $newValue, $model),
            'asignado_por' => static::getAsignadoPorChangeMessage($oldValue, $newValue, $model),
            'ruta_archivo' => "Se cambió adjunto de '<a href='" .
                asset('storage/tareas-archivos/' . basename($oldValue)) . "'>" . basename($oldValue) .
                "</a>' a '<a href='" .
                asset('storage/tareas-archivos/' . basename($newValue)) . "'>" . basename($newValue) .
                "</a>'",
            'es_final' => "Se cambió el estado final de '" .
                ($oldValue ? 'Sí' : 'No') . "' a '" .
                ($newValue ? 'Sí' : 'No') . "'",
            'es_editable' => "Se cambió la edición de '" .
                ($oldValue ? 'Permitida' : 'No permitida') . "' a '" .
                ($newValue ? 'Permitida' : 'No permitida') . "'",
            'orden' => "Se modificó el orden de '{$oldValue}' a '{$newValue}'",
            default => "Se modificó el campo {$field} de '{$oldValue}' a '{$newValue}'"
        };
    }

    protected static function getDateChangeMessage($fieldName, $oldValue, $newValue): string
    {
        $oldDate = $oldValue ? Carbon::parse($oldValue)->format('d/m/Y') : 'sin fecha';
        $newDate = $newValue ? Carbon::parse($newValue)->format('d/m/Y') : 'sin fecha';
        return "Se cambió la {$fieldName} de '{$oldDate}' a '{$newDate}'";
    }

    // En el modelo InstanciaTareaFlujo:

    protected static function getEstadoChangeMessage($oldValue, $newValue, $model): string
    {
        // Buscar el ESTADO antiguo directamente en ListaElemento
        $oldEstado = ListaElemento::where('id', $oldValue)
            ->where('tipo_lista_elemento_id', GlobalEnums::ESTADO_TAREAS->value())
            ->first()->nombre ?? $oldValue;

        // El nuevo estado sí se obtiene de la relación actual
        $newEstado = $model->estados->nombre ?? $newValue;

        return "Se cambió el estado de '{$oldEstado}' a '{$newEstado}'";
    }

    protected static function getAsignadoChangeMessage($oldValue, $newValue, $model): string
    {
        // Buscar el USUARIO antiguo directamente en la tabla User
        $oldUser = User::find($oldValue)->name ?? $oldValue;
        // El nuevo usuario sí se obtiene de la relación actual
        $newUser = $model->asignadoA->name ?? $newValue;

        return "Se reasignó la tarea de '{$oldUser}' a '{$newUser}'";
    }

    protected static function getAsignadoPorChangeMessage($oldValue, $newValue, $model): string
    {
        // Buscar el USUARIO (asignador) antiguo en User
        $oldUser = User::find($oldValue)->name ?? $oldValue;
        // El nuevo asignador se obtiene de la relación actual
        $newUser = $model->asignadoPor->name ?? $newValue;

        return "Se cambió el asignador de la tarea de '{$oldUser}' a '{$newUser}'";
    }



    // Relaciones
    public function instanciaPasoFlujo(): BelongsTo
    {
        return $this->belongsTo(InstanciaPasoFlujo::class, 'instancia_paso_flujo_id');
    }

    public function estados(): BelongsTo
    {
        return $this->belongsTo(ListaElemento::class, 'estado')
            ->where('tipo_lista_elemento_id', GlobalEnums::ESTADO_TAREAS->value());
    }

    public function asignadoA(): BelongsTo
    {
        return $this->belongsTo(User::class, 'asignado_a');
    }

    public function asignadoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'asignado_por');
    }

    public function comentarios(): HasMany
    {
        return $this->hasMany(Comentario::class, 'instancia_tareas_flujo_id');
    }

    public function historial(): HasMany
    {
        return $this->hasMany(HistoricoTarea::class, 'instancia_tareas_flujo_id');
    }
}
