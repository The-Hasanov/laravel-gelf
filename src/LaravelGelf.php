<?php

namespace LaravelGelf;

use Gelf\Publisher;
use Gelf\Transport\TcpTransport;
use Gelf\Transport\TransportInterface;
use Gelf\Transport\UdpTransport;

class LaravelGelf
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @var Publisher;
     */
    protected $publisher;

    /**
     * LaravelGelf constructor.
     * @param $config
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * @return Publisher
     */
    public function publisher()
    {
        if (!$this->publisher) {
            $this->publisher = new Publisher($this->connection());
        }
        return $this->publisher;
    }

    /**
     * @return TransportInterface
     */
    public function connection()
    {
        $type = $this->get('connection.type', 'tcp');
        if (method_exists($this, $method = strtolower($type) . '_connection')) {
            return $this->$method();
        }
        throw new \RuntimeException('Invalid Connection Type');
    }

    /**
     * @return TcpTransport
     */
    protected function tcp_connection()
    {
        return new TcpTransport(
            $this->get('connection.host', '127.0.0.1'),
            $this->get('connection.port', 12201)
        );
    }

    /**
     * @return UdpTransport
     */
    protected function udp_connection()
    {
        return new UdpTransport(
            $this->get('connection.host', '127.0.0.1'),
            $this->get('connection.port', 12201)
        );
    }


    /**
     * @return string
     */
    public function level()
    {
        return $this->get('level', 'debug');
    }

    /**
     * @return bool
     */
    public function bubble()
    {
        return $this->get('bubble', true);
    }

    /**
     * @param      $key
     * @param null $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return array_get($this->config, $key, $default);
    }
}
