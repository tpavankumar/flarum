<?php

class MasqueradeUtils {

    private $config;

    public function __construct()
    {
        $this->config = require __DIR__ . '/config.php';
    }

    public function sendPostRequest($token, $data)
    {
        $path = '/api/masquerade/configure';
        $data_string = json_encode($data);

        $ch = curl_init($this->config['flarum_url'] . $path);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json; charset=UTF-8',
                'Content-Length: ' . strlen($data_string),
                'Cookie: flarum_remember=' . $token,
            ]
        );
        $result = curl_exec($ch);
        return json_decode($result, true);
    }

    public function getMasqueradeConfigs($token)
    {
        $path = '/api/masquerade/configure';

        $ch = curl_init($this->config['flarum_url'] . $path);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json; charset=UTF-8',
                'Cookie: flarum_remember=' . $token,
            ]
        );
        $result = curl_exec($ch);
        return json_decode($result, true);
    }

    public function getIdentifierForThisField($token, $fieldName) {

        $fields = $this->getMasqueradeConfigs($token)['data'];
        foreach ($fields as $field) {
            $targetFieldName = $field['attributes']['name'];
            if ($targetFieldName == $fieldName) return $field['id'];
        }


    }

}