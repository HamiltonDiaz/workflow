<?php

namespace App\Filament\Traits;

use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;

/**
 * Esta trait es de elaboración propia y está diseñado para ser utilizada en proyectos
 * que requieren la verificación de duplicados en el contexto de Filament.
 * 
 * Una trait en PHP es un mecanismo que permite reutilizar código en múltiples clases,
 * proporcionando una forma de compartir funcionalidad común sin necesidad de herencia.
 */
trait FilamentDuplicateCheckTrait
{
    /**
     * Realiza la validación de duplicados y restauración de registros eliminados
     * 
     * @param array $data Los datos del formulario
     * @param array $fields Los campos a verificar para duplicados
     * @param string|null $modelClass La clase del modelo a usar (Por defecto la clase relacionada con el recurso)
     * @param string nombre de campo que se va a mostrar en la tarjeta de notificación.
     * @return void
     */
    protected function checkDuplicatesAndRestoreDeleted(array $data, array $fields, string $nombreRegistro): void
    {
        // Determinar la clase del modelo
        $modelClass = $this->getModelClass();
        //Crea una instancia del modelo relacionado al recurso de filament
        $modelo = new $modelClass();

        // Validar si existe un registro activo
        if ($modelo->duplicatedRegister($data, $fields)) {
            Notification::make()
                ->title('Error')
                ->body("El registro '{$data[$nombreRegistro]}' ya existe.")
                ->danger()
                ->send();
            $this->halt();
        }

        // Validar si el registro está eliminado y restaurarlo
        $existingRegister = $modelo->deletedRegister($data, $fields);
        if ($existingRegister) {
            if ($this instanceof \Filament\Resources\Pages\CreateRecord) {
                Notification::make()
                    ->title('Creado')
                    ->success()
                    ->send();
                $this->redirect($this->getResource()::getUrl('edit', ['record' => $existingRegister->id]));
                $this->halt();
            }
        }
    }

    /**
     * Obtiene la clase del modelo a partir del recurso
     * 
     * @return string
     */
    protected function getModelClass(): string
    {
        // Acceder al recurso de forma segura
        $resourceClass = $this->getResource();

        // Obtener el modelo asociado al recurso
        return $resourceClass::getModel();
    }
}
