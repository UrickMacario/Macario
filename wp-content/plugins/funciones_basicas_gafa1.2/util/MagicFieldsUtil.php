<?php

/**
 * Class MagicFieldsUtil
 * Contiene funciones útiles para trabajar con el plugin de MagicFields v.2.
 */
class MagicFieldsUtil
{
    /**
     * @param string $postId Id del post donde se encuentrael grupo.
     * @param string $groupName nombre del grupo declarado en magic fields.
     * @param array $memberMappings un array que mapea cómo construir el objeto a partir de los campos declarados en el grupo de magic fields.
     *          Tal mapeo debe seguir ésta estructura:
     *			"key" : string Nombre que será usado en la llave del objeto creado de cada campo.
     *			"value" : string|closure Si es un string, el valor para ese campo será el primer elemento del array de campos cuyo nombre coincida con éste valor. Si ningún campo magic-fields tiene dicho nombre, un string vacío será asignado como value.
     *                  El value también puede ser una función anónima, usada para campos con estructuras más complejas, como "image_media".
     *                  Tal función anónima deberá aceptar un parametro llamado (preferentemente) $group al cuál le será pasado el grupo tal
     *                  cuál es devuelto por majic fields, y como tal contendrá todos los campos del grupo, de modo que puedas aplicar lógica más completa para
     *                  seleccionar el valor que se desea asignar a ese miembro del objeto. Ésta función anónima debe regresar el elemento a ser usado como value.
     *
     * Ejemplo
     *
     * Un código como éste:
     * <code>
     *      $data = get_group( 'info_instagram', $this->ID );
     *      $instagramTitulo = isset( $data['info_instagram_titulo'] ) ? $data['info_instagram_titulo'] : false;
     *      $instagramDescripcion = isset( $data['info_instagram_descripcion'] )	? $data['info_instagram_descripcion'] : false;
     *      $instagramFoto = isset( $data['info_instagram_foto'] )	? $data['info_instagram_foto'] : false;
     * </code>
     *
     * Puede ser convertido en éste más sencillo:
     * <code>
     *      $instagramData = Producto::magic_fields_get_group_as_single(
     *          $this->ID,
     *          'info_instagram',
     *          array(
     *              'titulo' => 'info_instagram_titulo',
     *              'descripcion' => 'info_instagram_descripcion',
     *              'foto' => function($elements){return isset($elements['info_instagram_foto']) ? reset($elements['info_instagram_foto'])['original'] : "";},
     *          )
     *      );
     * </code>
     *
     * @return array El array de objetos construidos en base a las reglas especificadas en $memberMappings. Si no se encontró ningún grupo, será devuelto un array vacío.
     */
    public static function get_group_as_array($postId, $groupName, $memberMappings)
    {
        /**
         * The array of groups as returned by magic fields.
         */
        $groups = get_group($groupName, $postId);

        if(!$groups){ return array(); }

        /**
         * The formatted magic fields' group formatted by the rules of $memberMappings.
         */
        $formatedGroup = array();

        foreach($groups as $group)
        {
            $members = array();

            foreach ($memberMappings as $memberName => $memberValue) {
                if(is_string($memberValue))
                {
                    $members[$memberName] = isset($group[$memberValue]) ? reset($group[$memberValue]) : "";
                }
                else
                {
                    $members[$memberName] = $memberValue($group);
                }
            }
            $formatedGroup[] = $members;
        }
        return $formatedGroup;
    }

    /**
     * Lo mismo que get_group_as_array, sólo que devuelve el primer elemento del array que tal función devuelve. Devuelve null si get_group_as_array devuelve un array vacío.
     *
     * @param string $postId Id del post donde se encuentrael grupo.
     * @param string $groupName nombre del grupo declarado en magic fields.
     * @param $memberMappings
     * @return array|null
     */
    public static function get_group_as_single($postId, $groupName, $memberMappings)
    {
        $theArray = MagicFieldsUtil::get_group_as_array($postId, $groupName, $memberMappings);
        return $theArray ? reset($theArray) : null;
    }
}