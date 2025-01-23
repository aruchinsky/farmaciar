<?php
    namespace config;
    use \PDO;

    class db{
        private $server = DB_SERVER;
        private $db = DB_NAME;
        private $user = DB_USER;
        private $pass = DB_PASS;

        protected function conectar(){
            $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);
            $conexion = new PDO("mysql:host=".$this->server."; dbname=".$this->db,
                $this->user,$this->pass, $options);
            //PErmite utilizar caracteres españoles
            $conexion->exec("SET CHARACTER SET utf8");

            return $conexion;
        }
    }
?>