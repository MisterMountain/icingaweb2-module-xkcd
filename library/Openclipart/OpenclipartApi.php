<?php

namespace Icinga\Module\Openclipart;

class OpenclipartApi
{

    private $config;
    private string $baseUrl;
    private string $username;
    private string $password;
    private string $appid;
    private string $secret;
    private string $userToken;
    private string $apiToken;


    public function __construct($config)
    {
        $this->config   = $config;

        $this->baseUrl  = $this->config->get('API', 'baseUrl');
        $this->username = $this->config->get('API', 'username');
        $this->password = $this->config->get('API', 'password');
        $this->appid    = $this->config->get('API', 'appid');
        $this->secret   = $this->config->get('API', 'secret');

        $this->getUserToken();
        $this->getApiToken();
    }

    public function getRandomImage(string $search, bool $nsfw = false) : string|false
    {
        $apiToken = $this->apiToken;
        $baseUrl  = $this->config->get('API', 'baseUrl');
        
        $headers = [
            'x-openclipart-apikey: ' . $apiToken,
            'Content-Type: application/json'
        ];
        
        $images = [];
        $offset = 0;
        $ch     = curl_init();

        do {
            
            $requestUrl = $baseUrl . 'search?q=' . $search . '&per_page=100&offset=' . $offset;

            curl_setopt_array($ch, [
                CURLOPT_URL            => $requestUrl,
                CURLOPT_HTTPHEADER     => $headers,
                CURLOPT_RETURNTRANSFER => true
            ]);

            $response = json_decode(curl_exec($ch), true);
            $images = array_merge($images, $response['data']['files']);
            $temp[$offset / 100] = $response['data']['files'];
            $offset += 100;

        } while(($offset + 100) < $response['data']['total_results']);

        curl_close($ch);

        if ($response['data']['files_count'] <= 0) {
            // $this->view->error = 'Error: No results found';
            return false;
        }

        do {
            $random = rand(0, $response['data']['files_count'] - 1);
        } while ($response['data']['files'][$random]['nsfw'] && !$nsfw);

        // return $response['data']['files'][$random]['svg_file'];
        return $response['data']['files'][$random]['svg_file'];
    }

    private function getUserToken()
    {
        // Get User Token
        $getUserTokenUrl = $this->baseUrl  . 'auth/login';

        $data = 'username=' . $this->username . '&password=' . $this->password;

        $ch = curl_init($getUserTokenUrl);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = json_decode(curl_exec($ch), true);

        curl_close($ch);

        $this->userToken = $response['data']['token'];
    }

    private function getApiToken()
    {
        // Get Api Token
        $getApiTokenUrl = $this->baseUrl  . 'apps/getToken';

        $headers = [
            'x-openclipart-apikey: ' . $this->userToken,
            'Content-Type: application/json'
        ];

        $data = [
            'appid'  => $this->appid,
            'secret' => $this->secret
        ];

        $ch = curl_init($getApiTokenUrl);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = json_decode(curl_exec($ch), true);

        curl_close($ch);

        $this->apiToken = $response['data']['token'];
    }
}
