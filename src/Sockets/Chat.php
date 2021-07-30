<?php


namespace App\Sockets;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface {
    protected $messages = [];
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);
        echo "New connection! ({$conn->resourceId}) addr {$conn->remoteAddress} \n";
        if ($this->messages) {
//            ITS FIX duplicate, when WS double connection
            $last = 0;
            foreach ($this->messages as $key => $value) {
                if ($value->uuid == $last) {
                    echo $value->uuid. "\n";
                    echo $last. "\n";;
                    unset($this->messages[$key]);
                } else {
                    $last = $value->uuid;
                }

            }
            $messagesJson = json_encode($this->messages);
            $conn->send($messagesJson);
        }
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        $decoded = json_decode($msg);
        echo '/------------------------------'. "\n";
        echo sprintf('Socket %d with user id: %d sending message: '."\n".' "%s" at %d || clients count: %d' . "\n"
            , $from->resourceId, $decoded->userID, $decoded->message, $decoded->uuid, $numRecv);
        echo '------------------------------/'. "\n";

        $num = 0;
        $lastChildIndex = sizeof($this->messages);
        foreach ($this->clients as $client) {
            if ($from !== $client) {
                array_push($this->messages, $decoded);
                $client->send($msg);
//                TODO: Client send message to all connections. Connections double count, fix it soon
            }
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