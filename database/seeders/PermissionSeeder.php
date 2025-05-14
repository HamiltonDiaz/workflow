<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['id' => 1, 'name' => 'comentario.view', 'modelo' => 'Comentario', 'accion' => 'Ver']);
        Permission::create(['id' => 2, 'name' => 'comentario.create', 'modelo' => 'Comentario', 'accion' => 'Crear']);
        Permission::create(['id' => 3, 'name' => 'comentario.update', 'modelo' => 'Comentario', 'accion' => 'Actualizar']);
        Permission::create(['id' => 4, 'name' => 'comentario.delete', 'modelo' => 'Comentario', 'accion' => 'Eliminar']);
        Permission::create(['id' => 5, 'name' => 'comentario.export', 'modelo' => 'Comentario', 'accion' => 'Exportar']);
        Permission::create(['id' => 6, 'name' => 'comentario.import', 'modelo' => 'Comentario', 'accion' => 'Importar']);
        Permission::create(['id' => 7, 'name' => 'comentario.publish', 'modelo' => 'Comentario', 'accion' => 'Publicar']);
        Permission::create(['id' => 8, 'name' => 'flujotrabajo.view', 'modelo' => 'FlujoTrabajo', 'accion' => 'Ver']);
        Permission::create(['id' => 9, 'name' => 'flujotrabajo.create', 'modelo' => 'FlujoTrabajo', 'accion' => 'Crear']);
        Permission::create(['id' => 10, 'name' => 'flujotrabajo.update', 'modelo' => 'FlujoTrabajo', 'accion' => 'Actualizar']);
        Permission::create(['id' => 11, 'name' => 'flujotrabajo.delete', 'modelo' => 'FlujoTrabajo', 'accion' => 'Eliminar']);
        Permission::create(['id' => 12, 'name' => 'flujotrabajo.export', 'modelo' => 'FlujoTrabajo', 'accion' => 'Exportar']);
        Permission::create(['id' => 13, 'name' => 'flujotrabajo.import', 'modelo' => 'FlujoTrabajo', 'accion' => 'Importar']);
        Permission::create(['id' => 14, 'name' => 'flujotrabajo.publish', 'modelo' => 'FlujoTrabajo', 'accion' => 'Publicar']);
        Permission::create(['id' => 15, 'name' => 'historicotarea.view', 'modelo' => 'HistoricoTarea', 'accion' => 'Ver']);
        Permission::create(['id' => 16, 'name' => 'historicotarea.create', 'modelo' => 'HistoricoTarea', 'accion' => 'Crear']);
        Permission::create(['id' => 17, 'name' => 'historicotarea.update', 'modelo' => 'HistoricoTarea', 'accion' => 'Actualizar']);
        Permission::create(['id' => 18, 'name' => 'historicotarea.delete', 'modelo' => 'HistoricoTarea', 'accion' => 'Eliminar']);
        Permission::create(['id' => 19, 'name' => 'historicotarea.export', 'modelo' => 'HistoricoTarea', 'accion' => 'Exportar']);
        Permission::create(['id' => 20, 'name' => 'historicotarea.import', 'modelo' => 'HistoricoTarea', 'accion' => 'Importar']);
        Permission::create(['id' => 21, 'name' => 'historicotarea.publish', 'modelo' => 'HistoricoTarea', 'accion' => 'Publicar']);
        Permission::create(['id' => 22, 'name' => 'instanciaflujotrabajo.view', 'modelo' => 'InstanciaFlujoTrabajo', 'accion' => 'Ver']);
        Permission::create(['id' => 23, 'name' => 'instanciaflujotrabajo.create', 'modelo' => 'InstanciaFlujoTrabajo', 'accion' => 'Crear']);
        Permission::create(['id' => 24, 'name' => 'instanciaflujotrabajo.update', 'modelo' => 'InstanciaFlujoTrabajo', 'accion' => 'Actualizar']);
        Permission::create(['id' => 25, 'name' => 'instanciaflujotrabajo.delete', 'modelo' => 'InstanciaFlujoTrabajo', 'accion' => 'Eliminar']);
        Permission::create(['id' => 26, 'name' => 'instanciaflujotrabajo.export', 'modelo' => 'InstanciaFlujoTrabajo', 'accion' => 'Exportar']);
        Permission::create(['id' => 27, 'name' => 'instanciaflujotrabajo.import', 'modelo' => 'InstanciaFlujoTrabajo', 'accion' => 'Importar']);
        Permission::create(['id' => 28, 'name' => 'instanciaflujotrabajo.publish', 'modelo' => 'InstanciaFlujoTrabajo', 'accion' => 'Publicar']);
        Permission::create(['id' => 29, 'name' => 'instanciapasoflujo.view', 'modelo' => 'InstanciaPasoFlujo', 'accion' => 'Ver']);
        Permission::create(['id' => 30, 'name' => 'instanciapasoflujo.create', 'modelo' => 'InstanciaPasoFlujo', 'accion' => 'Crear']);
        Permission::create(['id' => 31, 'name' => 'instanciapasoflujo.update', 'modelo' => 'InstanciaPasoFlujo', 'accion' => 'Actualizar']);
        Permission::create(['id' => 32, 'name' => 'instanciapasoflujo.delete', 'modelo' => 'InstanciaPasoFlujo', 'accion' => 'Eliminar']);
        Permission::create(['id' => 33, 'name' => 'instanciapasoflujo.export', 'modelo' => 'InstanciaPasoFlujo', 'accion' => 'Exportar']);
        Permission::create(['id' => 34, 'name' => 'instanciapasoflujo.import', 'modelo' => 'InstanciaPasoFlujo', 'accion' => 'Importar']);
        Permission::create(['id' => 35, 'name' => 'instanciapasoflujo.publish', 'modelo' => 'InstanciaPasoFlujo', 'accion' => 'Publicar']);
        Permission::create(['id' => 36, 'name' => 'instanciatareaflujo.view', 'modelo' => 'InstanciaTareaFlujo', 'accion' => 'Ver']);
        Permission::create(['id' => 37, 'name' => 'instanciatareaflujo.create', 'modelo' => 'InstanciaTareaFlujo', 'accion' => 'Crear']);
        Permission::create(['id' => 38, 'name' => 'instanciatareaflujo.update', 'modelo' => 'InstanciaTareaFlujo', 'accion' => 'Actualizar']);
        Permission::create(['id' => 39, 'name' => 'instanciatareaflujo.delete', 'modelo' => 'InstanciaTareaFlujo', 'accion' => 'Eliminar']);
        Permission::create(['id' => 40, 'name' => 'instanciatareaflujo.export', 'modelo' => 'InstanciaTareaFlujo', 'accion' => 'Exportar']);
        Permission::create(['id' => 41, 'name' => 'instanciatareaflujo.import', 'modelo' => 'InstanciaTareaFlujo', 'accion' => 'Importar']);
        Permission::create(['id' => 42, 'name' => 'instanciatareaflujo.publish', 'modelo' => 'InstanciaTareaFlujo', 'accion' => 'Publicar']);
        Permission::create(['id' => 43, 'name' => 'listaelemento.view', 'modelo' => 'ListaElemento', 'accion' => 'Ver']);
        Permission::create(['id' => 44, 'name' => 'listaelemento.create', 'modelo' => 'ListaElemento', 'accion' => 'Crear']);
        Permission::create(['id' => 45, 'name' => 'listaelemento.update', 'modelo' => 'ListaElemento', 'accion' => 'Actualizar']);
        Permission::create(['id' => 46, 'name' => 'listaelemento.delete', 'modelo' => 'ListaElemento', 'accion' => 'Eliminar']);
        Permission::create(['id' => 47, 'name' => 'listaelemento.export', 'modelo' => 'ListaElemento', 'accion' => 'Exportar']);
        Permission::create(['id' => 48, 'name' => 'listaelemento.import', 'modelo' => 'ListaElemento', 'accion' => 'Importar']);
        Permission::create(['id' => 49, 'name' => 'listaelemento.publish', 'modelo' => 'ListaElemento', 'accion' => 'Publicar']);
        Permission::create(['id' => 50, 'name' => 'pasoflujo.view', 'modelo' => 'PasoFlujo', 'accion' => 'Ver']);
        Permission::create(['id' => 51, 'name' => 'pasoflujo.create', 'modelo' => 'PasoFlujo', 'accion' => 'Crear']);
        Permission::create(['id' => 52, 'name' => 'pasoflujo.update', 'modelo' => 'PasoFlujo', 'accion' => 'Actualizar']);
        Permission::create(['id' => 53, 'name' => 'pasoflujo.delete', 'modelo' => 'PasoFlujo', 'accion' => 'Eliminar']);
        Permission::create(['id' => 54, 'name' => 'pasoflujo.export', 'modelo' => 'PasoFlujo', 'accion' => 'Exportar']);
        Permission::create(['id' => 55, 'name' => 'pasoflujo.import', 'modelo' => 'PasoFlujo', 'accion' => 'Importar']);
        Permission::create(['id' => 56, 'name' => 'pasoflujo.publish', 'modelo' => 'PasoFlujo', 'accion' => 'Publicar']);
        Permission::create(['id' => 57, 'name' => 'permission.view', 'modelo' => 'Permission', 'accion' => 'Ver']);
        Permission::create(['id' => 58, 'name' => 'permission.create', 'modelo' => 'Permission', 'accion' => 'Crear']);
        Permission::create(['id' => 59, 'name' => 'permission.update', 'modelo' => 'Permission', 'accion' => 'Actualizar']);
        Permission::create(['id' => 60, 'name' => 'permission.delete', 'modelo' => 'Permission', 'accion' => 'Eliminar']);
        Permission::create(['id' => 61, 'name' => 'permission.export', 'modelo' => 'Permission', 'accion' => 'Exportar']);
        Permission::create(['id' => 62, 'name' => 'permission.import', 'modelo' => 'Permission', 'accion' => 'Importar']);
        Permission::create(['id' => 63, 'name' => 'permission.publish', 'modelo' => 'Permission', 'accion' => 'Publicar']);
        Permission::create(['id' => 64, 'name' => 'role.view', 'modelo' => 'Role', 'accion' => 'Ver']);
        Permission::create(['id' => 65, 'name' => 'role.create', 'modelo' => 'Role', 'accion' => 'Crear']);
        Permission::create(['id' => 66, 'name' => 'role.update', 'modelo' => 'Role', 'accion' => 'Actualizar']);
        Permission::create(['id' => 67, 'name' => 'role.delete', 'modelo' => 'Role', 'accion' => 'Eliminar']);
        Permission::create(['id' => 68, 'name' => 'role.export', 'modelo' => 'Role', 'accion' => 'Exportar']);
        Permission::create(['id' => 69, 'name' => 'role.import', 'modelo' => 'Role', 'accion' => 'Importar']);
        Permission::create(['id' => 70, 'name' => 'role.publish', 'modelo' => 'Role', 'accion' => 'Publicar']);
        Permission::create(['id' => 71, 'name' => 'tareaflujo.view', 'modelo' => 'TareaFlujo', 'accion' => 'Ver']);
        Permission::create(['id' => 72, 'name' => 'tareaflujo.create', 'modelo' => 'TareaFlujo', 'accion' => 'Crear']);
        Permission::create(['id' => 73, 'name' => 'tareaflujo.update', 'modelo' => 'TareaFlujo', 'accion' => 'Actualizar']);
        Permission::create(['id' => 74, 'name' => 'tareaflujo.delete', 'modelo' => 'TareaFlujo', 'accion' => 'Eliminar']);
        Permission::create(['id' => 75, 'name' => 'tareaflujo.export', 'modelo' => 'TareaFlujo', 'accion' => 'Exportar']);
        Permission::create(['id' => 76, 'name' => 'tareaflujo.import', 'modelo' => 'TareaFlujo', 'accion' => 'Importar']);
        Permission::create(['id' => 77, 'name' => 'tareaflujo.publish', 'modelo' => 'TareaFlujo', 'accion' => 'Publicar']);
        Permission::create(['id' => 78, 'name' => 'tipolistaelemento.view', 'modelo' => 'TipoListaElemento', 'accion' => 'Ver']);
        Permission::create(['id' => 79, 'name' => 'tipolistaelemento.create', 'modelo' => 'TipoListaElemento', 'accion' => 'Crear']);
        Permission::create(['id' => 80, 'name' => 'tipolistaelemento.update', 'modelo' => 'TipoListaElemento', 'accion' => 'Actualizar']);
        Permission::create(['id' => 81, 'name' => 'tipolistaelemento.delete', 'modelo' => 'TipoListaElemento', 'accion' => 'Eliminar']);
        Permission::create(['id' => 82, 'name' => 'tipolistaelemento.export', 'modelo' => 'TipoListaElemento', 'accion' => 'Exportar']);
        Permission::create(['id' => 83, 'name' => 'tipolistaelemento.import', 'modelo' => 'TipoListaElemento', 'accion' => 'Importar']);
        Permission::create(['id' => 84, 'name' => 'tipolistaelemento.publish', 'modelo' => 'TipoListaElemento', 'accion' => 'Publicar']);
        Permission::create(['id' => 85, 'name' => 'user.view', 'modelo' => 'User', 'accion' => 'Ver']);
        Permission::create(['id' => 86, 'name' => 'user.create', 'modelo' => 'User', 'accion' => 'Crear']);
        Permission::create(['id' => 87, 'name' => 'user.update', 'modelo' => 'User', 'accion' => 'Actualizar']);
        Permission::create(['id' => 88, 'name' => 'user.delete', 'modelo' => 'User', 'accion' => 'Eliminar']);
        Permission::create(['id' => 89, 'name' => 'user.export', 'modelo' => 'User', 'accion' => 'Exportar']);
        Permission::create(['id' => 90, 'name' => 'user.import', 'modelo' => 'User', 'accion' => 'Importar']);
        Permission::create(['id' => 91, 'name' => 'user.publish', 'modelo' => 'User', 'accion' => 'Publicar']);


        //Asigna todos los permisos al admin
        $allPermissions = Permission::all();
        Role::findById(1)->syncPermissions($allPermissions);


        //Asigna permisos al rol auxiliar
        $auxPermissions = [
            'comentario.view',
            'comentario.create',
            'instanciaflujotrabajo.view',
            'instanciaflujotrabajo.create',
            'instanciaflujotrabajo.update',
            'instanciapasoflujo.create',
            'instanciatareaflujo.view',
            'instanciatareaflujo.create',
            'instanciatareaflujo.update',

        ];
        Role::findById(2)->syncPermissions($auxPermissions);
    }
}
