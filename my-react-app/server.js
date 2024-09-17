// // server.js
// import express from 'express';
// import http from 'http';
// import { Server as SocketIOServer } from 'socket.io';
// import db from './db.js'; // Import database connection

// const app = express();
// const server = http.createServer(app);
// const io = new SocketIOServer(server, {
//     cors: {
//         origin: "http://localhost:5173",
//         methods: ["GET", "POST"],
//         allowedHeaders: ["my-custom-header"],
//         credentials: true
//     }
// });

// app.get('/', (req, res) => {
//     res.send('WebSocket server is running');
// });

// io.on('connection', (socket) => {
//     console.log('New client connected');

//     socket.on('getData', async () => {
//         try {
//             // Fetch data from PostgreSQL
//             const data = await db.any('SELECT * FROM datarealtime');
//             socket.emit('datarealtime', data);
//         } catch (error) {
//             console.error('Error fetching data:', error);
//             socket.emit('error', 'Error fetching data');
//         }
//     });

//     socket.on('message', (message) => {
//         console.log('Message received:', message);
//         io.emit('message', message);
//     });

//     socket.on('disconnect', () => {
//         console.log('Client disconnected');
//     });
// });

// // Listen for PostgreSQL notifications
// const listenForNotifications = async () => {
//     try {
//         const cn = 'postgres://postgres:root@localhost:5432/postgres';
//         const pgClient = pgp(cn);

//         pgClient.connect();
//         pgClient.query('LISTEN data_channel');

//         pgClient.on('notification', async (msg) => {
//             if (msg.channel === 'data_channel') {
//                 // Notify all clients about data changes
//                 const data = await db.any('SELECT * FROM datarealtime');
//                 io.emit('data', data);
//             }
//         });
//     } catch (error) {
//         console.error('Error setting up PostgreSQL notifications:', error);
//     }
// };

// listenForNotifications();

// const PORT = process.env.PORT || 8080;
// server.listen(PORT, () => {
//     console.log(`Server is running on port ${PORT}`);
// });
const WebSocket = require('ws');

// Inisialisasi WebSocket server pada port 8080
const wss = new WebSocket.Server({ port: 8080 });

wss.on('connection', (ws) => {
    console.log('New client connected');

    // Ketika server menerima pesan dari klien
    ws.on('message', (message) => {
        console.log(`Received message: ${message}`);

        // Broadcast pesan ke semua klien
        wss.clients.forEach(client => {
            if (client.readyState === WebSocket.OPEN) {
                client.send(message);
            }
        });
    });

    // Ketika klien memutuskan koneksi
    ws.on('close', () => {
        console.log('Client disconnected');
    });
});

console.log('WebSocket server running on ws://localhost:8080');
