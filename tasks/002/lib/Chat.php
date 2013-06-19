<?php

class Chat
{
    /**
     * Create client
     * @param string $name
     * @return Client
     */
    public function createClient($name) {
        return new Client($name);
    }
    
    /**
     * Create chat room
     * @param string $name
     * @return Chatroom
     */
    public function createChatroom($name) {
        return new Chatroom($name);
    }
}


class Client
{
    private $name;
    private $listener;
    
    function __construct($name) {
        $this->name = $name;
    }
    
    /**
     * Add listener
     * @param Listener $listener
     */
    public function addListener($listener) {
        $this->listener = $listener;
    }
    
    /**
     * Get listener
     * @return Listener
     */
    public function getListener() {
        return $this->listener;
    }

    /**
     * Notifing listener
     * @param Client $client
     * @param Chatroom $chatroom
     * @param string $message
     */
    public function notifyListener($client, $chatroom, $message) {
        if ($this->listener) {
            $this->listener->receive($client, $chatroom, $message);
        }
    }
}


class Chatroom
{
    private $name;
    private $occupants;
    
    function __construct($name) {
        $this->name = $name;
        $this->occupants = array();
    }
    
    /**
     * Get name
     * @return string
     */
    public function getName() {
        return $this->name;
    }
    
    /**
     * Add client
     * @param Client $client
     */
    public function addClient($client) {
        $this->occupants[] = $client;
    }
    
    /**
     * Get Occupants
     * @return array
     */
    public function getOccupants() {
        return $this->occupants;
    }
    
    /**
     * Send message
     * @param Client $client
     * @param string $message
     */
    public function send($client, $message) {
        if (!empty($this->occupants)) {
            foreach ($this->occupants as $occupant) {
                if ($occupant != $client) {
                    $occupant->notifyListener($client, $this, $message);
                }
            }
        }
    }
}


class Listener
{
    /**
     * Receive message
     * @param Client $client
     * @param Chatroom $chatroom
     * @param string $message
     */
    public function receive($client, $chatroom, $message) {
        echo "Received message: " . $message;
    }
}
?>
