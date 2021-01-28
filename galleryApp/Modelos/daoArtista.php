<?php

// Entidades
require_once("./classes/classArtista.php");
// Datos de la conexión a la base de datos
require_once("./conexion/Connection.php");

class DaoArtista extends Conexion
{

    // Array de objetos Artista
    public $Artistas = array();

    public function listar()
    {
        // vaciamos el array
        $this->Artistas = array();

        $query = "SELECT * FROM artista";
        $this->Query($query, array());

        foreach ($this->returnData as $row) {
            $artista = new Artista();

            $artista->__SET("id_artista", $row["id_artista"]);
            $artista->__SET("nombre_artista", $row["nombre_artista"]);
            $artista->__SET("pagina_personal", $row["pagina_personal"]);
            $artista->__SET("email", $row["email"]);
            $artista->__SET("telefono", $row["telefono"]);
            $artista->__SET("descripcion", $row["descripcion"]);

            $this->Artistas[] = $artista;
        }
    }

    public function listarYPrintarArtistas() {

        // Llamamos a la función listar()
        $this->listar();

        // Mostramos el resultado en pantalla
        $html = '';
        $html .= '<table class="tabla">';
        $html .= '<thead><tr><th >Selección</th><th>Id Artista</th><th>Nombre</th><th>Página Personal</th><th>Email</th><th>Teléfono</th><th>Descripción</th></tr></thead>';

        foreach ($this->Artistas as $artista) {
            $id = $artista->id_artista;
            $html .= "<tr><td><input type='checkbox' name='check[]' value='$id' class='form-control'></td>";
            $html .= "<th>$id</th>";
            $html .= "<td><input type='text' name='nombre$id' value='$artista->nombre_artista' class='form-control'></td>";
            $html .= "<td><input type='text' name='pagina_personal$id' value='$artista->pagina_personal' class='form-control'></td>";
            $html .= "<td><input type='email' name='email$id' value='$artista->email' class='form-control'></td>";
            $html .= "<td><input type='numeric' name='telefono$id' value='$artista->telefono' class='form-control'></td>";
            $html .= "<td><input type='text' name='descripcion$id' value='$artista->descripcion' class='form-control'></td>";
        }

        $html .= "<tr><th>Nuevo Artista: </th>";
        $html .= "<th></th>";
        $html .= "<td><input type='text' name='i_nombre' class='form-control'></td>";
        $html .= "<td><input type='text' name='i_pagina_personal' class='form-control'></td>";
        $html .= "<td><input type='email' name='i_email' class='form-control'></td>";
        $html .= "<td><input type='numeric' name='i_telefono' class='form-control'></td>";
        $html .= "<td><input type='text' name='i_descripcion' class='form-control'></td>";
        $html .= "</table>";
        echo $html;
        
    }

    public function obtenerArtista($id)
    {
        $query = "SELECT * FROM artista WHERE id_artista = :id_artista";

        $parameter = array(":id_artista" => $id);

        $this->Query($query, $parameter);

        $artista = new Artista();

        if (count($this->returnData) > 0) {
            $row = $this->returnData[0];

            $artista->__SET("id_artista", $row["id_artista"]);
            $artista->__SET("nombre_artista", $row["nombre_artista"]);
            $artista->__SET("pagina_personal", $row["pagina_personal"]);
            $artista->__SET("email", $row["email"]);
            $artista->__SET("telefono", $row["telefono"]);
            $artista->__SET("descripcion", $row["descripcion"]);
        }

        return $artista;
    }

    public function insertar($artista)
    {
        $query = "INSERT INTO artista (nombre_artista, pagina_personal, email, descripcion, telefono)
        VALUES (:nombre_artista, :pagina_personal, :email, :descripcion, :telefono)";

        $parameter = array(
            ":nombre_artista" => $artista->__GET("nombre_artista"),
            ":pagina_personal" => $artista->__GET("pagina_personal"),
            ":descripcion" => $artista->__GET("descripcion"),
            ":telefono" => $artista->__GET("telefono"),
            ":email" => $artista->__GET("email")
        );
        $this->Query($query, $parameter);
    }

    public function actualizar($artista)
    {
        $query = "UPDATE artista SET nombre_artista=:nombre_artista, pagina_personal=:pagina_personal, email=:email,
        descripcion=:descripcion, telefono=:telefono WHERE id_artista=:id_artista";

        $parameter = array(
            ":nombre_artista" => $artista->__GET("nombre_artista"),
            ":pagina_personal" => $artista->__GET("pagina_personal"),
            ":descripcion" => $artista->__GET("descripcion"),
            ":telefono" => $artista->__GET("telefono"),
            ":email" => $artista->__GET("email"),
            ":id_artista" => $artista->__GET("id_artista")
        );
        $this->Query($query, $parameter);
    }

    public function eliminar($id_artista)
    {
        $query = "DELETE FROM artista WHERE id_artista = :id_artista";
        $parameter = array(":id_artista"=>$id_artista);
        $this->Query($query, $parameter);
    }
}
