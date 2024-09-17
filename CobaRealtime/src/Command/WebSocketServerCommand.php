<?php

// namespace App\Command;

// use App\Repository\DataRealtimeRepository;
// use App\WebSocket\websocketServer;
// use Ratchet\Http\HttpServer;
// use Ratchet\Server\IoServer;
// use Ratchet\WebSocket\WsServer;
// use React\EventLoop\Factory as LoopFactory;
// use React\Socket\Server as Reactor;
// use Symfony\Component\Console\Command\Command;
// use Symfony\Component\Console\Input\InputInterface;
// use Symfony\Component\Console\Output\OutputInterface;

// class WebSocketServerCommand extends Command
// {
//     protected static $defaultName = 'app:websocket-server';

//     private $dataRealtimeRepository;

//     public function __construct(DataRealtimeRepository $dataRealtimeRepository)
//     {
//         parent::__construct();
//         $this->dataRealtimeRepository = $dataRealtimeRepository;
//     }

//     protected function execute(InputInterface $input, OutputInterface $output)
//     {
//         $loop = LoopFactory::create();
//         $webSocket = new websocketServer($this->dataRealtimeRepository);

//         $socketServer = new Reactor('127.0.0.1:8080', $loop);
//         $server = new IoServer(new HttpServer(new WsServer($webSocket)), $socketServer, $loop);

//         $output->writeln('WebSocket server started on ws://127.0.0.1:8080');

//         $loop->run();

//         $output->writeln('WebSocket server stopped');

//         return Command::SUCCESS;

//     }
// }

namespace App\Command;

use App\WebSocket\websocketServer;
use Doctrine\DBAL\Connection;
use PDO;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use React\EventLoop\Factory as LoopFactory;
use React\Socket\Server as Reactor;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class WebSocketServerCommand extends Command
{
    protected static $defaultName = 'app:websocket-server';
    private $connection;

    public function __construct(Connection $connection)
    {
        parent::__construct();
        $this->connection = $connection;
    }

    // protected function execute(InputInterface $input, OutputInterface $output): int
    // {
    //     $loop = LoopFactory::create();
    //     $webSocket = new websocketServer();
    //     $socket = new Reactor('127.0.0.1:8080', $loop);

    //     $server = new IoServer(
    //         new HttpServer(
    //             new WsServer($webSocket)
    //         ),
    //         $socket,
    //         $loop
    //     );

    //     // Mendapatkan koneksi PDO dari Doctrine DBAL
    //     $pdo = $this->connection->getNativeConnection(); // Gunakan getNativeConnection()
    //     $pdo->exec('LISTEN message_updates');
    //     $output->writeln('WebSocket server started on ws://127.0.0.1:8080');

    //     // Run PostgreSQL listen loop asynchronously
    //     $loop->addPeriodicTimer(1, function () use ($output, $pdo, $webSocket) {
    //         $notification = $pdo->pgsqlGetNotify(PDO::FETCH_ASSOC);

    //         if ($notification) {
    //             $output->writeln("Notification received: " . $notification['payload']);
    //             // Broadcast to WebSocket clients
    //             $webSocket->broadcast($notification['payload']);
    //         }
    //     });

    //     // Start the WebSocket server loop
    //     $loop->run();

    //     return Command::SUCCESS;
    // }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $loop = LoopFactory::create();
        $webSocket = new websocketServer();
        $socket = new Reactor('127.0.0.1:8080', $loop);

        $server = new IoServer(
            new HttpServer(
                new WsServer($webSocket)
            ),
            $socket,
            $loop
        );

        // Mendapatkan koneksi PDO dari Doctrine DBAL
        $pdo = $this->connection->getNativeConnection();
        $pdo->exec('LISTEN message_updates');
        $output->writeln('WebSocket server started on ws://127.0.0.1:8080');

        // Run PostgreSQL listen loop asynchronously
        $loop->addPeriodicTimer(1, function () use ($output, $pdo, $webSocket) {
            // Non-blocking check for new notifications
            $notification = $pdo->pgsqlGetNotify(PDO::FETCH_ASSOC, 1000);

            if ($notification) {
                $output->writeln("Notification received: " . $notification['payload']);

                // Ambil data terbaru dari database setelah menerima notifikasi
                $data = $this->fetchLatestDataFromDatabase($pdo);

                // Broadcast the updated data to WebSocket clients
                $webSocket->broadcast(json_encode($data));
            }
        });

        // Start the WebSocket server loop
        $loop->run();

        return Command::SUCCESS;
    }

    private function fetchLatestDataFromDatabase($pdo)
    {
        // Mengambil data terbaru dari database dengan PDO langsung
        $query = "SELECT * FROM data_realtime ORDER BY datetime DESC LIMIT 50";
        $stmt = $pdo->query($query);

        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Menggunakan fetchAll dari PDO
    }
}
