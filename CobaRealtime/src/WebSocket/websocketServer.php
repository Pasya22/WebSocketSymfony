<?php
namespace App\WebSocket;

use App\Repository\DataRealtimeRepository;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

class websocketServer implements MessageComponentInterface
{
    protected $clients;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage();
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        foreach ($this->clients as $client) {
            if ($from !== $client) {
                $client->send($msg);
            }
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error occurred: {$e->getMessage()}\n";
        $conn->close();
    }

    public function broadcast($msg)
    {
        echo "Broadcasting message: $msg\n"; // Tambahkan logging ini
        foreach ($this->clients as $client) {
            $client->send($msg);
        }
    }
    
    
    // protected $clients;
    // private $dataRealtimeRepository;

    // public function __construct(DataRealtimeRepository $dataRealtimeRepository)
    // {
    //     $this->clients = new \SplObjectStorage();
    //     $this->dataRealtimeRepository = $dataRealtimeRepository;
    // }

    // public function onOpen(ConnectionInterface $conn)
    // {
    //     $this->clients->attach($conn);
    //     // echo "New connection! ({$conn->resourceId})\n";

    //     $data = $this->dataRealtimeRepository->findAllMessages();
    //     foreach ($data as $message) {
    //         $conn->send(json_encode([
    //             'IDAssy' => $message->getIDAssy(),
    //             'Zvalue' => $message->getZvalue(),
    //             'Xvalue' => $message->getXvalue(),
    //             'username' => $message->getUsername(),
    //             'datetime' => $message->getDatetime() ? $message->getDatetime()->format('Y-m-d H:i:s') : null,
    //             'status' => $message->getStatus(),
    //         ]));
    //     }
    //     // $data = $this->dataRealtimeRepository->findAllMessages();
    //     // foreach ($data as $message) {
    //     //     $conn->send(json_encode($message));
    //     // }
    // }

    // public function onMessage(ConnectionInterface $from, $msg)
    // {
    //     foreach ($this->clients as $client) {
    //         if ($from !== $client) {
    //             $client->send($msg);
    //         }
    //     }
    // }

    // public function onClose(ConnectionInterface $conn)
    // {
    //     $this->clients->detach($conn);
    //     echo "Connection {$conn->resourceId} has disconnected\n";
    // }

    // public function onError(ConnectionInterface $conn, \Exception $e)
    // {
    //     echo "An error has occurred: {$e->getMessage()}\n";
    //     $conn->close();
    // }

    // protected $clients;

    // public function __construct()
    // {
    //     $this->clients = new \SplObjectStorage();
    // }

    // public function onOpen(ConnectionInterface $conn)
    // {
    //     // Simpan koneksi baru ke objek $clients
    //     $this->clients->attach($conn);
    //     echo "New connection! ({$conn->resourceId})\n";
    // }

    // public function onMessage(ConnectionInterface $from, $msg)
    // {
    //     // Kirim pesan ke semua klien yang terhubung
    //     foreach ($this->clients as $client) {
    //         if ($from !== $client) {
    //             // Kirim pesan ke semua klien kecuali pengirim
    //             $client->send($msg);
    //         }
    //     }
    // }

    // public function onClose(ConnectionInterface $conn)
    // {
    //     // Hapus klien saat menutup koneksi
    //     $this->clients->detach($conn);
    //     echo "Connection {$conn->resourceId} has disconnected\n";
    // }

    // public function onError(ConnectionInterface $conn, \Exception $e)
    // {
    //     echo "An error has occurred: {$e->getMessage()}\n";
    //     $conn->close();
    // }

    // protected $clients;

    // public function __construct()
    // {
    //     $this->clients = new \SplObjectStorage;
    // }

    // public function onOpen(ConnectionInterface $conn)
    // {
    //     // Store the new connection
    //     $this->clients->attach($conn);
    //     echo "New connection: ({$conn->resourceId})\n";
    // }

    // public function onMessage(ConnectionInterface $from, $msg)
    // {
    //     echo "Received message: $msg\n";
    //     foreach ($this->clients as $client) {
    //         if ($from !== $client) {
    //             // Broadcast message to all clients except the sender
    //             $client->send($msg);
    //         }
    //     }
    // }

    // public function onClose(ConnectionInterface $conn)
    // {
    //     // The connection is closed
    //     $this->clients->detach($conn);
    //     echo "Connection {$conn->resourceId} has disconnected\n";
    // }

    // public function onError(ConnectionInterface $conn, \Exception $e)
    // {
    //     echo "An error occurred: {$e->getMessage()}\n";
    //     $conn->close();
    // }
}

// Set up the WebSocket server
// $loop = Factory::create();
// $webSock = new SocketServer('127.0.0.1:8080', [], $loop);

// $server = new HttpServer(new WsServer(new WebSocketServer()));
// $server = new \Ratchet\Server\IoServer($server, $webSock, $loop);

// echo "WebSocket server started on ws://127.0.0.1:8080\n";
// $loop->run();
