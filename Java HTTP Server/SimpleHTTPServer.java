//Simple HTTP Server 
//Web server refers to server software that can serve contents to the World Wide Web. A web server processes incoming network requests over HTTP and several other related protocols.

import java.net.ServerSocket;
import java.net.Socket;
import java.io.IOException;
import java.util.Date;

public class SimpleHTTPServer {

	public static void main(String[] args) throws Exception {
		final ServerSocket server = new ServerSocket(8080);
		System.out.println("Listening for connection on port 8080 . . ."); 
		while (true) { 
			try(Socket socket = server.accept()) { //connection established
				Date today = new Date();
				String httpResponse = "HTTP/1.1 200 OK\r\n\r\n" + today; //HTTP response to client is today's date
				socket.getOutputStream().write(httpResponse.getBytes("UTF-8")); //automatically closes connection and socket once the HTTP response is sent
			}
		}
	}
}
