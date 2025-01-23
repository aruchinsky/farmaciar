<?php
    namespace app\models;

    class viewsModel{

        //Funcion para controlar las vistas del SISTEMA
        protected function obtenerVistasModelo($vista){
            // ESte array tiene todas las palabras que se van a permitir en la URL
            $listaBlanca=["dashboard","logOut","myUser",
                          "shopList","shopPay",
                          "userNew","userUpdate","userList","userShop","myUserUpdate",
                          "productNew","productList","productSearch","productUpdate","productInform","productDetalle","productFiltrado"
                        ];
            //PReguntamos si el nombre de la vista recibida existe en el array de permitidos
            if(in_array($vista,$listaBlanca)){
                // Verificamos si esta vista existe en la carpeta CONTENT
                if(is_file("./app/views/content/".$vista."-view.php")){
                    //Devolvemos la vista con toda la ruta definida
                    $contenido = "./app/views/content/".$vista."-view.php";
                }else{
                    //Devolvemos el valor 404 para mostrar la pagina con AVISO 404
                    $contenido = "404";
                }
            }elseif($vista == "login" || $vista == "index"){
                $contenido = "login";
            }else{
                $contenido = "404";
            }

            return $contenido;
        }


    }

?>