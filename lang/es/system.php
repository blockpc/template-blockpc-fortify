<?php

return [
    'permissions' => [
        'menu' => 'Permisos',
        'title' => 'Listado de permisos',
        'description' => 'Muestra los permisos que pueden ser asignados a los roles y/o usuarios.',
        'search-permissions' => 'Buscar permisos...',
        'table' => [
            'name' => 'Nombre',
            'description' => 'Descripción',
            'key' => 'Clave',
            'type' => 'Tipo',
            'actions' => 'Acciones',
            'no_permissions' => 'No hay permisos registrados.',
            'edit' => 'Editar',
        ],
        'edit' => [
            'title' => 'Editar permiso',
            'description' => 'Modifica los detalles del permiso.',
            'display_name' => 'Nombre',
            'description' => 'Descripción',
            'save' => 'Guardar cambios',
            'validations' => [
                'display_name.required' => 'El nombre es obligatorio.',
                'display_name.string' => 'El nombre debe ser una cadena de texto.',
                'display_name.max' => 'El nombre no puede tener más de 255 caracteres.',
                'description.required' => 'La descripción es obligatoria.',
                'description.string' => 'La descripción debe ser una cadena de texto.',
                'description.max' => 'La descripción no puede tener más de 255 caracteres.',
            ],
        ],
        'keys' => [
            'sudo' => 'Super Admin',
            'users' => 'Usuarios',
            'roles' => 'Roles',
            'permissions' => 'Permisos',
        ],
    ],
];
