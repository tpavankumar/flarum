<?php

class MasqueradeUtils {

    const MASQUERADE_CONFIGURE_ENDPOINT = '/api/masquerade/configure';

    private $config;

    public function __construct()
    {
        $this->config = require __DIR__ . '/config.php';
    }

    public function sendPostRequest($token, $data)
    {
        $path = self::MASQUERADE_CONFIGURE_ENDPOINT;
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
        $path = self::MASQUERADE_CONFIGURE_ENDPOINT;

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

    public function getFieldNameIdentifiersMap($token) {

        $fields = $this->getMasqueradeConfigs($token)['data'];
        $fieldNameIdentifiersMap = array();
        foreach ($fields as $field) {
            $targetFieldAttributes = $field['attributes'];
            $fieldNameIdentifiersMap[$targetFieldAttributes['name']] = intval($targetFieldAttributes['id']);
        }
        return $fieldNameIdentifiersMap;
    }

}