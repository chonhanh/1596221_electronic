<?php
class RestApi
{
    private $curl;
    private $baseUrl = BASE_URL_API . 'api';
    private $apiUrl;
    private $data;
    private $result;
    private $headers = ["Content-Type:multipart/form-data"];

    function __construct()
    {
        $this->curl = curl_init();
    }

    private function setUrl($url)
    {
        $this->apiUrl = $this->baseUrl . $url;
    }

    private function setOptions()
    {
        curl_setopt($this->curl, CURLOPT_URL, $this->apiUrl);
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    }

    private function setData($data)
    {
        $this->data = $data;
    }

    private function setMethod($method)
    {
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, $method);

        if ($this->data) {
            curl_setopt($this->curl, CURLOPT_POSTFIELDS, $this->data);
        }
    }

    private function execute()
    {
        $this->result = curl_exec($this->curl);
    }

    private function close()
    {
        curl_close($this->curl);
    }

    public function decode($data, $associative = false)
    {
        if ($data) {
            $data = json_decode($data, $associative);
        }

        return $data;
    }

    public function get($url)
    {
        $this->setUrl($url);
        $this->setOptions();
        $this->setMethod('GET');
        $this->execute();
        $this->close();

        return $this->result;
    }

    public function post($url, $data = null)
    {
        $this->setUrl($url);
        $this->setData($data);
        $this->setOptions();
        $this->setMethod('POST');
        $this->execute();
        $this->close();

        return $this->result;
    }

    public function put($url, $data = null)
    {
        $this->setUrl($url);
        $this->setData($data);
        $this->setOptions();
        $this->setMethod('PUT');
        $this->execute();
        $this->close();

        return $this->result;
    }

    public function patch($url, $data = null)
    {
        $this->setUrl($url);
        $this->setData($data);
        $this->setOptions();
        $this->setMethod('PATCH');
        $this->execute();
        $this->close();

        return $this->result;
    }

    public function delete($url, $data = null)
    {
        $this->setUrl($url);
        $this->setData($data);
        $this->setOptions();
        $this->setMethod('DELETE');
        $this->execute();
        $this->close();

        return $this->result;
    }
}