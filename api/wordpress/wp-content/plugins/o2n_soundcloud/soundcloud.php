<?php

Class Soundcloud
{
    /**
     * Soundcloud client id
     * @var string
     */
    private $_clientId;

    /**
     * Get all tracks or not
     * @var boolean
     */
    private $_enableAllTracks;

    /**
     * Curl options
     * @var array
     */
    private $_curlOptions;

    /**
     * Soundcloud API url
     * @var string
     */
    private $_apiEndpoint;

    /**
     * Class constructor
     * @access public
     */
    function __construct()
    {
        if (empty(get_option('soundcloud_options')['client_id'])) {
            throw new Soundcloud_Missing_Client_Id_Exception();
        }
        $this->_clientId = get_option('soundcloud_options')['client_id'];
        $this->_setDefaultCurlOptions();
        $this->_apiEndpoint = 'https://api.soundcloud.com/';
    }

    protected function _setDefaultCurlOptions()
    {
        $this->_curlOptions = array(
            CURLOPT_HEADER => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERAGENT => ''
        );
    }

    protected function _constructUrl($path)
    {
        return $path . '?format=json&client_id=' . $this->_clientId;
    }

    protected function _request($path, $curlOptions = array())
    {
        try {
            $options = $this->_curlOptions;
            $options += $curlOptions;

            $curl = curl_init($path);
            curl_setopt_array($curl, $options);
            $response = curl_exec($curl);

            if (FALSE === $response)
                throw new Exception(curl_error($curl), curl_errno($curl));

            curl_close($curl);

            return substr($response, strpos($response, "\r\n\r\n") + 4);

        } catch (Exception $error) {
            trigger_error(sprintf(
                'Soundcloud request failed with error #%d: %s',
                $error->getCode(), $error->getMessage()),
                E_USER_ERROR);

        }
    }

    function getAllTracks($user_id)
    {
        $baseUrl = $this->_apiEndpoint . 'users/' . $user_id . '/tracks';
        $formattedUrl = $this->_constructUrl($baseUrl);

        $data = $this->_request($formattedUrl);

        return json_decode($data, true);
    }
}

class Soundcloud_Missing_Client_Id_Exception extends Exception
{
    /**
     * Default message.
     * @var string
     */
    protected $message = 'All requests must include a client ID. Please set the client ID in the Soundcloud Page in Wordpress';
}
