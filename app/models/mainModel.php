<?php 
    namespace app\models;

use config\db;
use \PDO;

    //Preguntamos si el archivo existe 
    if(file_exists(__DIR__."/../../config/server.php")){
        //si existe lo llamamos
        require_once __DIR__."/../../config/server.php";
    }
    //Preguntamos si el archivo existe 
    if(file_exists(__DIR__."/../../config/db.php")){
        //si existe lo llamamos
        require_once __DIR__."/../../config/db.php";
    }

    class mainModel extends db{

        //Funcion para ejecutar cualquier consulta genérica
        protected function ejecutarConsulta($consulta){
            //Preparamos la consulta
            $sql = $this->conectar()->prepare($consulta);
            //Ejecutamos la consulta
            $sql->execute();
            //Devolvemos el resultado
            return $sql;
        }

        public function ejecutarConsultaLibre($consulta){
            //Preparamos la consulta
            $sql = $this->conectar()->prepare($consulta);
            //Ejecutamos la consulta
            $sql->execute();
            //Devolvemos el resultado
            return $sql;
        }

        public function limpiarCadena($cadena){
            $palabras = ["<script>","</script>","<script src","<script type=","SELECT * FROM",
                         "DELETE FROM","INSERT INTO","DROP TALBE","DROP DATABASE","TRUNCATE TABLE",
                         "SHOW TABLE;","SHOW DATABASES;","<?php","?>","--","^","<","[","]","==",";","::"];

            $cadena=trim($cadena);
            $cadena=stripslashes($cadena);
            
            foreach($palabras as $palabra){
                $cadena = str_ireplace($palabra,"",$cadena);
            }

            $cadena=trim($cadena);
            $cadena=stripslashes($cadena);

            return $cadena;

        }

        protected function verificarDatos($filtro,$cadena){
            if(preg_match("/^".$filtro."$/",$cadena)){
                return false;
            }else{
                return true;
            }
        }

        protected function guardarDatos($tabla,$datos){
            $query = "INSERT INTO $tabla (";

            $contador = 0;

            foreach($datos as $clave){
                if($contador>=1){$query.=",";}
                $query.=$clave["campo_nombre"];
                $contador++;
            }

            $query.=") VALUES(";
            $contador = 0;

            foreach($datos as $clave){
                if($contador>=1){$query.=",";}
                $query.=$clave["campo_marcador"];
                $contador++;
            }

            $query.=")";
            $sql = $this->conectar()->prepare($query);

            foreach($datos as $clave){
                $sql->bindParam($clave["campo_marcador"],$clave["campo_valor"]);
            }

            $sql->execute();

            return $sql;
        }

        protected function guardarDatosIdClave($tabla, $datos) {
            // Obtener la conexión a la base de datos
            $pdo = $this->conectar();
        
            // Construir la consulta de inserción
            $query = "INSERT INTO $tabla (";
        
            $contador = 0;
        
            foreach($datos as $clave) {
                if($contador >= 1) {
                    $query .= ",";
                }
                $query .= $clave["campo_nombre"];
                $contador++;
            }
        
            $query .= ") VALUES(";
            $contador = 0;
        
            foreach($datos as $clave) {
                if($contador >= 1) {
                    $query .= ",";
                }
                if ($clave["campo_marcador"] == ":Clave") {
                    // Si el marcador es Clave, usar AES_ENCRYPT
                    $query .= "AES_ENCRYPT(" . $clave["campo_marcador"] . ", 'PEPE')";
                } else {
                    // De lo contrario, usar el marcador normalmente
                    $query .= $clave["campo_marcador"];
                }
                $contador++;
            }
        
            $query .= ")";
            
            // Preparar y ejecutar la consulta
            $sql = $pdo->prepare($query);
        
            foreach($datos as $clave) {
                $sql->bindParam($clave["campo_marcador"], $clave["campo_valor"]);
            }
        
            $sql->execute();
        
            // Obtener el ID del último registro insertado
            $lastInsertId = $pdo->lastInsertId();
        
            // Retornar el ID del último registro insertado
            return $lastInsertId;
        }

        protected function guardarDatosId($tabla, $datos) {
            // Obtener la conexión a la base de datos
            $pdo = $this->conectar();
        
            // Construir la consulta de inserción
            $query = "INSERT INTO $tabla (";
        
            $contador = 0;
        
            foreach($datos as $clave) {
                if($contador >= 1) {
                    $query .= ",";
                }
                $query .= $clave["campo_nombre"];
                $contador++;
            }
        
            $query .= ") VALUES(";
            $contador = 0;
        
            foreach($datos as $clave) {
                if($contador >= 1) {
                    $query .= ",";
                }
                $query .= $clave["campo_marcador"];
                $contador++;
            }
        
            $query .= ")";
            
            // Preparar y ejecutar la consulta
            $sql = $pdo->prepare($query);
        
            foreach($datos as $clave) {
                $sql->bindParam($clave["campo_marcador"], $clave["campo_valor"]);
            }
        
            $sql->execute();
        
            // Obtener el ID del último registro insertado
            $lastInsertId = $pdo->lastInsertId();
        
            // Retornar el ID del último registro insertado
            return $lastInsertId;
        }

        protected function guardarDatosClave($tabla, $datos) {
            // Construir la consulta de inserción
            $query = "INSERT INTO $tabla (";
        
            $contador = 0;
        
            foreach($datos as $clave) {
                if($contador >= 1) {
                    $query .= ",";
                }
                $query .= $clave["campo_nombre"];
                $contador++;
            }
        
            $query .= ") VALUES(";
            $contador = 0;
        
            foreach($datos as $clave) {
                if($contador >= 1) {
                    $query .= ",";
                }
                if ($clave["campo_marcador"] == ":Clave") {
                    // Si el marcador es Clave, usar AES_ENCRYPT
                    $query .= "AES_ENCRYPT(" . $clave["campo_marcador"] . ", 'PEPE')";
                } else {
                    // De lo contrario, usar el marcador normalmente
                    $query .= $clave["campo_marcador"];
                }
                $contador++;
            }
        
            $query .= ")";
            
            // Preparar y ejecutar la consulta
            $sql = $this->conectar()->prepare($query);
        
            foreach($datos as $clave) {
                if ($clave["campo_marcador"] == ":Clave") {
                    // Si el marcador es Clave, bindear el valor cifrado
                    $sql->bindParam($clave["campo_marcador"], $clave["campo_valor"]);
                } else {
                    // De lo contrario, bindear el valor normalmente
                    $sql->bindParam($clave["campo_marcador"], $clave["campo_valor"]);
                }
            }
        
            $sql->execute();
        
            return $sql;
        }

        public function seleccionarDatos($tipo,$tabla,$campo,$id){
            $tipo=$this->limpiarCadena($tipo);
            $tabla=$this->limpiarCadena($tabla);
            $campo=$this->limpiarCadena($campo);
            $id=$this->limpiarCadena($id);

            //Unico hace referenica a una sola fila o a una seleccion de algo unico
            if($tipo == "Unico"){
                $sql=$this->conectar()->prepare("SELECT * FROM $tabla WHERE $campo=:id");
                $sql->bindParam(":id",$id);

            }elseif($tipo=="Normal"){
                //Normal hace referenica a una seleccion de un campo con todos sus registros de una tabla
                $sql=$this->conectar()->prepare("SELECT $campo FROM $tabla ");


            }elseif($tipo=="Menu"){
                //Menu hace referencia a la seleccion de una tabla para cargar un menu desplegable
                $sql=$this->conectar()->prepare("SELECT * FROM $tabla ");
            }

            $sql->execute();
            return $sql;
        }

        protected function actualizarDatos($tabla,$datos,$condicion){
            $query = "UPDATE $tabla SET ";

            $contador = 0;

            foreach($datos as $clave){
                if($contador>=1){$query.=",";}

                $query.=$clave["campo_nombre"]."=".$clave["campo_marcador"];
                $contador++;
            }

            $query.=" WHERE ".$condicion["condicion_campo"]."=".$condicion["condicion_marcador"];
            $sql = $this->conectar()->prepare($query);

            foreach($datos as $clave){
                $sql->bindParam($clave["campo_marcador"],$clave["campo_valor"]);
            }
            $sql->bindParam($condicion["condicion_marcador"],$condicion["condicion_valor"]);

            $sql->execute();
            return $sql;
        }

        protected function actualizarDatosConClave($tabla, $datos, $condicion) {
            // Inicializamos la consulta base para actualizar los datos en la tabla
            $query = "UPDATE $tabla SET ";
            $contador = 0; // Contador para saber si estamos procesando el primer campo o no
        
            // Recorremos el array de datos a actualizar
            foreach ($datos as $clave) {
                // Si no es el primer campo, agregamos una coma para separar los campos en la consulta SQL
                if ($contador >= 1) {
                    $query .= ",";
                }
        
                // Si el campo actual es una clave (contraseña), se encripta usando AES_ENCRYPT
                if ($clave["campo_marcador"] == ":Clave") {
                    $query .= $clave["campo_nombre"] . "=AES_ENCRYPT(" . $clave["campo_marcador"] . ", 'PEPE')";
                } else {
                    // En caso contrario, se asigna el valor normalmente
                    $query .= $clave["campo_nombre"] . "=" . $clave["campo_marcador"];
                }
                $contador++; // Incrementamos el contador
            }
        
            // Agregamos la cláusula WHERE para especificar la condición de la actualización
            $query .= " WHERE " . $condicion["condicion_campo"] . "=" . $condicion["condicion_marcador"];
        
            // Preparamos la consulta SQL utilizando PDO
            $sql = $this->conectar()->prepare($query);
        
            // Asociamos los valores correspondientes a los marcadores de los datos
            foreach ($datos as $clave) {
                $sql->bindParam($clave["campo_marcador"], $clave["campo_valor"]);
            }
        
            // Asociamos el valor correspondiente al marcador de la condición
            $sql->bindParam($condicion["condicion_marcador"], $condicion["condicion_valor"]);
        
            // Ejecutamos la consulta preparada
            $sql->execute();
        
            // Devolvemos el objeto PDOStatement resultante para verificar el éxito de la operación
            return $sql;
        }
        

        protected function eliminarRegistro($tabla,$campo,$id){
            $sql=$this->conectar()->prepare("UPDATE $tabla
                                             SET flag_mostrar = 0
                                             WHERE $campo =:id");
            $sql->bindParam(":id",$id);
            $sql->execute();
            return $sql;
        }

    }

?>