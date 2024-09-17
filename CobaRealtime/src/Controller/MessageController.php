<?php

namespace App\Controller;

use App\Repository\DataRealtimeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController
{
    private $dataRealtimeRepository;

    public function __construct(DataRealtimeRepository $dataRealtimeRepository)
    {
        $this->dataRealtimeRepository = $dataRealtimeRepository;
    }

    
      #[Route("/api/messages", name:"api_messages", methods:['GET'])]
     
    public function getMessages(): JsonResponse
    {
        // Mengambil semua data dari repository
        $messages = $this->dataRealtimeRepository->findAll();

        // Membuat array dari objek pesan
        $responseData = [];
        foreach ($messages as $message) {
            $responseData[] = [
                'IDAssy' => $message->getIDAssy(),
                'Zvalue' => $message->getZvalue(),
                'Xvalue' => $message->getXvalue(),
                'username' => $message->getUsername(),
                'datetime' => $message->getDatetime() ? $message->getDatetime()->format('Y-m-d H:i:s') : null,
                'status' => $message->getStatus(),
            ];
        }

        // Mengembalikan response JSON
        return new JsonResponse($responseData);
    }
}
