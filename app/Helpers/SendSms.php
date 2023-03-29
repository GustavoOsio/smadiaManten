<?php

namespace App\Helpers;

class SendSms {

    public static function send($cellphone, $text) {
        /*
        $url = 'https://api.hablame.co/sms/envio/';
        $data = array(
            'cliente' => 10012643, //Numero de cliente
            'api' => 'nyvyr8KQuzX8UwcJjCB5lGv743tju3', //Clave API suministrada
            'numero' => $cellphone, //numero o numeros telefonicos a enviar el SMS (separados por una coma ,)
            'sms' => $text, //Mensaje de texto a enviar
            'fecha' => '', //(campo opcional) Fecha de envio, si se envia vacio se envia inmediatamente (Ejemplo: 2017-12-31 23:59:59)
            'referencia' => 'Referenca Envio Hablame', //(campo opcional) Numero de referencio ó nombre de campaña
        );
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context  = stream_context_create($options);
        $result = json_decode((file_get_contents($url, false, $context)), true);
        return $result;
        */
        $url = "https://api101.hablame.co/api/sms/v2.1/send/";
        $data = array(
            'account' => '10012643', //número de usuario
            'apiKey' => 'nyvyr8KQuzX8UwcJjCB5lGv743tju3', //clave API del usuario
            'token' => 'c54511be84ac6f26db630427666ad53c', // Token de usuario
            'toNumber' => $cellphone, //número de destino
            'sms' => $text , // mensaje de texto
            'flash' => '0', //mensaje tipo flash
            'sendDate'=> time(), //fecha de envío del mensaje
            'isPriority' => 0, //mensaje prioritario
            'sc'=> '899991', //código corto para envío del mensaje de texto
            'request_dlvr_rcpt' => 0, //mensaje de texto con confirmación de entrega al celular
        );
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context  = stream_context_create($options);
        $result = json_decode((file_get_contents($url, false, $context)), true);
        if ( $result["status"] == '1x000' ) {
            return true;
        }else{
            return false;
        }
    }

}
