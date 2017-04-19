<?php 

/**
* 
*/
class conexion
{
    public $conex;

    function __construct()
    {
    $this->conex = new PDO("mysql:host=localhost;dbname=fabrica;charset=utf8", 'root','');
        $this->conex->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->conex->exec("SET CHARACTER SET utf8");
    }

    function ObtenerObjeto(){

        return $this->conex;
    }

    function Consulta($sql)
    {
        return $this->conex->prepare($sql);
    }
}



 ?>