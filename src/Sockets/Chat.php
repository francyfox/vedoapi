<?php


namespace App\Sockets;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);
        echo "New connection! ({$conn->resourceId}) addr {$conn->remoteAddress} \n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        $decoded = json_decode($msg);
        if ($decoded) {
            $uuid = $decoded->uuid ?? 'null';
            echo '/------------------------------'. "\n";
            echo sprintf('Socket %d with user id: %d sending message: '."\n".' "%s" at %d || clients count: %d' . "\n"
                , $from->resourceId, $decoded->userID ?? 'null', $decoded->message ?? 'null', $uuid, $numRecv);
            echo '------------------------------/'. "\n";

            foreach ($this->clients as $client) {
                if ($from !== $client) {
                    $client->send($msg);
                }
            }
        } else {
            echo 'Message Not Received';
        }
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->send("Error : " . $e->getMessage());
        $conn->close();
    }
}