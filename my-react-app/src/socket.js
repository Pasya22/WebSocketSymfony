import { w3cwebsocket as W3CWebSocket } from 'websocket';

const socket = new W3CWebSocket('ws://127.0.0.1:8000'); // Menggunakan alamat WebSocket server yang sama

socket.onopen = () => {
  console.log('WebSocket Client Connected');
};

socket.onclose = () => {
  console.log('WebSocket Client Disconnected');
};

export default socket;
