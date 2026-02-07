<?php

namespace Helpers;


class ResponseHandler {

    /** Méthode d'automatisation d'une réponse
     * @param bool $status Permet de récupérer le status de la réponse rapidement via un false ou true
     * @param string $message Permet d'afficher un petit message pour définir la réponse
     * @param $data Permet d'afficher les data s'il y en a, sinon définit sur null par défaut
     * @return array Retourne la réponse en liste pour envoyer plusieurs donnée en même temps
     */

    public static function format(bool $status, string $message, $data = null): array
    {
        // Renvoie une liste sous forme de clé valeur
        return [
            'status'=> $status,
            'message'=>$message,
            'data'=> $data,
            'timestamp' => date('Y-m-d H:i:s')
        ];
    }
}