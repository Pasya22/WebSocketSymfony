//  import React, { useState, useEffect } from "react";
// import io from "socket.io-client";

// const socket = io('ws://localhost:8080');

// const App = () => {
//     const [data, setData] = useState([]);
//     const [error, setError] = useState(null);

//     useEffect(() => {
//         socket.on("data", (data) => {
//             setData(data);
//         });

//         socket.on("error", (error) => {
//             setError(error);
//         });

//         // Request initial data from the server
//         socket.emit("getData");

//         return () => {
//             socket.off("data");
//             socket.off("error");
//         };
//     }, []);

//     return (
//         <div>
//             <h1>Real-Time Data</h1>
//             {error && <p style={{ color: 'red' }}>{error}</p>}
//             <ul>
//                 {data.map((item, index) => (
//                     <li key={index}>{JSON.stringify(item)}</li>
//                 ))}
//             </ul>
//         </div>
//     );
// };

// export default App; 
// import React, { useEffect, useState } from 'react';
// import socket from './socket';

// const App = () => {
//   const [messages, setMessages] = useState([]);

//   useEffect(() => {
//     // Mendengarkan pesan dari WebSocket server
//     socket.onmessage = (event) => {
//       setMessages((prevMessages) => [...prevMessages, event.data]);
//     };
//   }, []);

//   const sendMessage = () => {
//     socket.send('Hello from React');
//   };

//   return (
//     <div>
//       <h1>Data Realtime</h1>
//       <ul>
//         {messages.map((msg, index) => (
//           <li key={index}>{msg}</li>
//         ))}
//       </ul>
//       <button onClick={sendMessage}>Send Message</button>
//     </div>
//   );
// };

// export default App;
// import React, { useEffect, useState } from 'react';
// import socket from './socket';  // Mengimpor koneksi WebSocket

// const App = () => {
//     const [messages, setMessages] = useState([]);

//     useEffect(() => {
//         // Menerima pesan dari WebSocket server
//         socket.onmessage = (event) => {
//             const data = JSON.parse(event.data);
//             setMessages((prevMessages) => [...prevMessages, data]);
//         };

//         return () => {
//             // Menutup koneksi WebSocket saat komponen di-unmount
//             socket.close();
//         };
//     }, []);

//     return (
//         <div>
//             <h1>Data Realtime</h1>
//             <table border="1">
//                 <thead>
//                     <tr>
//                         <th>ID Assy</th>
//                         <th>Z Value</th>
//                         <th>X Value</th>
//                         <th>Username</th>
//                         <th>Date Time</th>
//                         <th>Status</th>
//                     </tr>
//                 </thead>
//                 <tbody>
//                     {messages.map((msg, index) => (
//                         <tr key={index}>
//                             <td>{msg.IDAssy}</td>
//                             <td>{msg.Zvalue}</td>
//                             <td>{msg.Xvalue}</td>
//                             <td>{msg.username}</td>
//                             <td>{msg.datetime}</td>
//                             <td>{msg.status}</td>
//                         </tr>
//                     ))}
//                 </tbody>
//             </table>
//         </div>
//     );
// };

// export default App;

// import React, { useEffect, useState } from 'react';
// import { w3cwebsocket as W3CWebSocket } from 'websocket';

// const socket = new W3CWebSocket('ws://127.0.0.1:8080');

// const App = () => {
//     const [messages, setMessages] = useState(() => {
//         // Ambil data dari LocalStorage jika ada
//         const savedMessages = localStorage.getItem('messages');
//         return savedMessages ? JSON.parse(savedMessages) : [];
//     });

//     useEffect(() => {
//         fetch('http://localhost:8000/api/messages')
//             .then(response => response.json())
//             .then(data => {
//                 setMessages(data);
//                 localStorage.setItem('messages', JSON.stringify(data)); // Simpan data ke LocalStorage
//             });

//         socket.onopen = () => {
//             console.log('WebSocket Client Connected');
//         };

//         socket.onmessage = (message) => {
//             console.log('Received data from WebSocket: ', message.data);
//             const parsedData = JSON.parse(message.data);

//             // Update state dan simpan data baru ke LocalStorage
//             setMessages((prevMessages) => {
//                 const updatedMessages = [parsedData, ...prevMessages];
//                 localStorage.setItem('messages', JSON.stringify(updatedMessages)); // Simpan data di LocalStorage
//                 return updatedMessages;
//             });
//         };

//         socket.onclose = () => {
//             console.log('WebSocket Client Disconnected');
//         };

//         socket.onerror = (error) => {
//             console.error('WebSocket Error: ', error);
//         };

//         return () => {
//             socket.close();
//         };
//     }, []);

//     return (
//         <div>
//             <h1>WebSocket Data Realtim</h1>
//             <ul>
//                 {messages.map((message, index) => (
//                     <li key={index}>
//                         IDAssy: {message.IDAssy}, Zvalue: {message.Zvalue}, Xvalue: {message.Xvalue}, Username: {message.username}, DateTime: {message.datetime}, Status: {message.status}
//                     </li>
//                 ))}
//             </ul>
//         </div>
//     );
// };

// export default App;

// import React, { useEffect, useState } from 'react';
// import { w3cwebsocket as W3CWebSocket } from 'websocket';

// const socket = new W3CWebSocket('ws://localhost:8080');

// const App = () => {
//     const [messages, setMessages] = useState(() => {
//         // Ambil data dari LocalStorage jika ada
//         const savedMessages = localStorage.getItem('messages');
//         return savedMessages ? JSON.parse(savedMessages) : [];
//     });

//     useEffect(() => {
//         socket.onopen = () => {
//             console.log('WebSocket Client Connected');
//         };

//         socket.onmessage = (message) => {
//             console.log('Received data from WebSocket: ', message.data);
//             const parsedData = JSON.parse(message.data);

//             // Update state dan simpan data baru ke LocalStorage
//             setMessages((prevMessages) => {
//                 const existingIndex = prevMessages.findIndex(m => m.IDAssy === parsedData.IDAssy);

//                 if (existingIndex !== -1) {
//                     const updatedMessages = [...prevMessages];
//                     updatedMessages[existingIndex] = parsedData;
//                     localStorage.setItem('messages', JSON.stringify(updatedMessages));
//                     return updatedMessages;
//                 } else {
//                     const updatedMessages = [parsedData, ...prevMessages];
//                     localStorage.setItem('messages', JSON.stringify(updatedMessages));
//                     return updatedMessages;
//                 }
//             });
//         };

//         socket.onclose = () => {
//             console.log('WebSocket Client Disconnected');
//         };

//         socket.onerror = (error) => {
//             console.error('WebSocket Error: ', error);
//         };

//         return () => {
//             socket.close();
//         };
//     }, []);

//     return (
//         <div>
//             <h1>WebSocket Data Realtime</h1>
//             <ul>
//                 {messages.map((message, index) => (
//                     <li key={index}>
//                         IDAssy: {message.IDAssy}, Zvalue: {message.Zvalue}, Xvalue: {message.Xvalue}, Username: {message.username}, DateTime: {message.datetime}, Status: {message.status}
//                     </li>
//                 ))}
//             </ul>
//         </div>
//     );
// };

// export default App;


// import React, { useEffect, useState } from 'react';
// import { w3cwebsocket as W3CWebSocket } from 'websocket';

// const socket = new W3CWebSocket('ws://localhost:8080');

// const App = () => {
//     const [messages, setMessages] = useState([]);

//     useEffect(() => {
//         socket.onopen = () => {
//             console.log('WebSocket Client Connected');
//         };

//         socket.onmessage = (message) => {
//             console.log('Received data from WebSocket: ', message.data);
//             const parsedData = JSON.parse(message.data);

//             // Update state with new message
//             setMessages((prevMessages) => {
//                 // Check if message already exists to avoid duplicates
//                 const updatedMessages = [parsedData, ...prevMessages.filter(msg => msg.IDAssy !== parsedData.IDAssy)];
//                 return updatedMessages;
//             });
//         };

//         socket.onclose = () => {
//             console.log('WebSocket Client Disconnected');
//         };

//         socket.onerror = (error) => {
//             console.error('WebSocket Error: ', error);
//         };

//         return () => {
//             socket.close();
//         };
//     }, []);

//     return (
//         <div>
//             <h1>WebSocket Data Realtimes</h1>
//             <ul>
//                 {messages.map((message, index) => (
//                     <li key={index}>
//                         IDAssy: {message.IDAssy}, Zvalue: {message.Zvalue}, Xvalue: {message.Xvalue}, Username: {message.username}, DateTime: {message.datetime}, Status: {message.status}
//                     </li>
//                 ))}
//             </ul>
//         </div>
//     );
// };

// export default App;

// import React, { useEffect, useState } from 'react';
// import { w3cwebsocket as W3CWebSocket } from 'websocket';

// const socket = new W3CWebSocket('ws://127.0.0.1:8080');

// const App = () => {
//     const [messages, setMessages] = useState(() => {
//         // Ambil data dari LocalStorage jika ada
//         const savedMessages = localStorage.getItem('messages');
//         return savedMessages ? JSON.parse(savedMessages) : [];
//     });

//     useEffect(() => {
//         socket.onopen = () => {
//             console.log('WebSocket Client Connected');
//         };

//         socket.onmessage = (message) => {
//             console.log('Received data from WebSocket: ', message.data);
//             const parsedData = JSON.parse(message.data);

//             // Update state dengan memeriksa apakah IDAssy sudah ada di daftar
//             setMessages((prevMessages) => {
//                 const index = prevMessages.findIndex(
//                     (msg) => msg.idassy === parsedData.idassy
//                 );

//                 let updatedMessages;

//                 if (index !== -1) {
//                     // Jika data sudah ada, ganti dengan data baru
//                     updatedMessages = prevMessages.map((msg, i) =>
//                         i === index ? parsedData : msg
//                     );
//                 } else {
//                     // Jika data baru, tambahkan ke daftar
//                     updatedMessages = [parsedData, ...prevMessages];
//                 }

//                 // Simpan data terbaru ke localStorage
//                 localStorage.setItem('messages', JSON.stringify(updatedMessages));
//                 return updatedMessages;
//             });
//         };

//         socket.onclose = () => {
//             console.log('WebSocket Client Disconnected');
//         };

//         socket.onerror = (error) => {
//             console.error('WebSocket Error: ', error);
//         };

//         return () => {
//             socket.close();
//         };
//     }, []);

//     return (
//         <div>
//             <h1>WebSocket Data Realtime</h1>
//             <ul>
//                 {messages.map((message, index) => (
//                     <li key={index}>
//                         IDAssy: {message.idassy}, Zvalue: {message.zvalue}, Xvalue: {message.xvalue}, Username: {message.username}, DateTime: {message.datetime}, Status: {message.status}
//                     </li>
//                 ))}
//             </ul>
//         </div>
//     );
// };

// export default App;
import React, { useEffect, useState } from 'react';
import { w3cwebsocket as W3CWebSocket } from 'websocket';

const socket = new W3CWebSocket('ws://127.0.0.1:8080');

const App = () => {
    const [messages, setMessages] = useState([]);

    useEffect(() => {
        socket.onopen = () => {
            console.log('WebSocket Client Connected');
        };

        socket.onmessage = (message) => {
            console.log('Raw message:', message.data); // Lihat raw data

            try {
                const parsedData = JSON.parse(message.data);
                console.log('Parsed data:', parsedData); // Log hasil parsing

                // Update state dengan data baru
                // setMessages((prevMessages) => [...prevMessages, parsedData]);
                setMessages(parsedData); // Set messages directly as array of objects
 

            } catch (error) {
                console.error('Error parsing message:', error); // Error handling
            }
        };

        return () => {
            socket.close();
        };
    }, []);

    return (
        <div>
            <h1>Real-Time Data</h1>
            <ul>
                {messages.length > 0 ? (
                    messages.map((message, index) => (
                        <li key={index}>
                            <strong>IDAssy:</strong> {message.idassy}, 
                            <strong>Zvalue:</strong> {message.zvalue}, 
                            <strong>Xvalue:</strong> {message.xvalue}, 
                            <strong>Username:</strong> {message.username}, 
                            <strong>DateTime:</strong> {message.datetime}, 
                            <strong>Status:</strong> {message.status}
                        </li>
                    ))
                ) : (
                    <li>No data available</li>
                )}
            </ul>
        </div>
    );
};

export default App;

