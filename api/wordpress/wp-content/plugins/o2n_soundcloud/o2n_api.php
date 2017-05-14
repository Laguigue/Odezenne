<?php
Class O2nApi
{
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
        $this->_setDefaultCurlOptions();
        $this->_apiEndpoint = 'o2n_nginx/api/v1/';
    }

    protected function _setDefaultCurlOptions()
    {
        $ENV = getenv('ENV');
        switch ($ENV) {
            case 'development':
                $HTTPHEADER = array('Host: lumen.o2n');
                break;
            case 'staging':
                $HTTPHEADER = array('Host: api.o2n.bramvanosta.com');
                break;
            case 'production':
                $HTTPHEADER = array('Host: api.odezenne.com');
                break;
            default:
                $HTTPHEADER = array();
        }

        $this->_curlOptions = array(
            CURLOPT_HEADER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERAGENT => 'O2N Wordpress',
            CURLOPT_HTTPHEADER => $HTTPHEADER,
        );
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

            return $response;

        } catch(Exception $error) {
            trigger_error(sprintf(
                'API request failed with error #%d: %s',
                $error->getCode(), $error->getMessage()),
                E_USER_ERROR);

        }
    }

    function setTracksList($tracks)
    {
        $formattedUrl = $this->_apiEndpoint.'tracks/all';
        $formattedTracks = array();

        foreach ($tracks as $track => $status) {
            $formattedTrack = array(
                'track_id' => $track,
                'status' => $status
            );
            array_push($formattedTracks, http_build_query($formattedTrack));
        }

        $params = array(
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $formattedTracks
        );

        $data = $this->_request($formattedUrl, $params);

        return $data;
    }

    function setClientId($clientId)
    {
        $formattedUrl = $this->_apiEndpoint.'settings/soundcloud-client-id';

        $formattedClientId = array(
            'label' => 'soundcloud-client-id',
            'value' => $clientId
        );

        $params = array(
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $formattedClientId
        );

        $data = $this->_request($formattedUrl, $params);

        return $data;
    }
}
