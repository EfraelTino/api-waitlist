<?php

class WaitList{
    private $host='localhost';
    private $user='u694359124_waitlist';
    private $password='=zN6opbJ';
    private $database='u694359124_waitlist';
    public $dbConnect;
    public function __construct()
    {
        $this->dbConnect= new mysqli($this->host, $this->user, $this->password, $this->database);

        if($this->dbConnect->connect_error){
            die("Error en la conexión a la base de datos: " . $this->dbConnect->connect_error);
        }
    }
    public function getDBConnect (){
        return $this->dbConnect;
    }
    public function executeQuery($query)
    {
        $result = $this->dbConnect->query($query);
        if ($result === false) {
            die("Error en la consulta: " . $this->dbConnect->error);
        }
        return $result;
    }
    public function prepare($query)
    {
        return $this->dbConnect->prepare($query);
    }
    public function postInsert($table, $camps, $vals, $bind_param, $data_camps)
    {

        $sql = "INSERT INTO $table ($camps) VALUES ($vals)";

        $stmt = mysqli_prepare($this->dbConnect, $sql);
        if (!$stmt) {
            $respuesta["success"] = false;
            $respuesta["message"] = "Error en la preparación de la consulta" . mysqli_error($this->dbConnect);
        } else {
            // Enlaza los parámetros y ejecuta la consulta
            if (!mysqli_stmt_bind_param($stmt, $bind_param, ...$data_camps)) {
                // Si hay un error al enlazar los parámetros
                $respuesta["success"] = false;
                $respuesta["message"] = "Error al enlazar los parámetros: " . mysqli_stmt_error($stmt);
            } else {
                // Ejecuta la consulta
                if (!mysqli_stmt_execute($stmt)) {
                    // Si hay un error al ejecutar la consulta
                    $respuesta["success"] = false;
                    $respuesta["message"] = "Error en la consulta: " . mysqli_error($this->dbConnect);
                } else {
                    // Si la consulta se ejecuta correctamente
                    $respuesta["success"] = true;
                    $respuesta["message"] = "Consulta satisfactoria";
                }
            }
            // Cierra el statement
            mysqli_stmt_close($stmt);
        }
        return json_encode($respuesta);
    }
}