/*
 A simple server in the internet domain using TCP
 Usage:./server port (E.g. ./server 10000 )
 */
#include <stdio.h>
#include <sys/types.h>   // definitions of a number of data types used in socket.h and netinet/in.h
#include <sys/socket.h>  // definitions of structures needed for sockets, e.g. sockaddr
#include <netinet/in.h>  // constants and structures needed for internet domain addresses, e.g. sockaddr_in
#include <stdlib.h>
#include <string.h>

void error(char *msg)
{
    perror(msg);
    exit(1);
}

int main(int argc, char *argv[])
{
    int sockfd, newsockfd; //descriptors rturn from socket and accept system calls
    int portno; // port number
    char *directory;
    socklen_t clilen;
    
    char buffer[500];
    char fileType[100];
    char temp[100];
    int fileSize;
    char *data;
    char *response;
    size_t contentSize;
    size_t fileOpenResult;
    FILE *fp;
    
    /*sockaddr_in: Structure Containing an Internet Address*/
    struct sockaddr_in serv_addr, cli_addr;
    
    int n;
    if (argc < 2) {
        fprintf(stderr,"ERROR, no port provided\n");
        exit(1);
    }
    
    /*Create a new socket
     AF_INET: Address Domain is Internet
     SOCK_STREAM: Socket Type is STREAM Socket */
    sockfd = socket(AF_INET, SOCK_STREAM, 0);
    if (sockfd < 0) {
        error("ERROR opening socket");
        exit(1);
    }
    
    bzero((char *) &serv_addr, sizeof(serv_addr));
    portno = atoi(argv[1]); //atoi converts from String to Integer
    serv_addr.sin_family = AF_INET;
    serv_addr.sin_addr.s_addr = INADDR_ANY; //for the server the IP address is always the address that the server is running on
    serv_addr.sin_port = htons(portno); //convert from host to network byte order
    
    if (bind(sockfd, (struct sockaddr *) &serv_addr, sizeof(serv_addr)) < 0){
        error("ERROR on binding");
        exit(1);
    } //Bind the socket to the server address
    
    listen(sockfd,5); // Listen for socket connections. Backlog queue (connections to wait) is 5
    
    clilen = sizeof(cli_addr);
    /* accept function:
     1) Block until a new connection is established
     2) the new socket descriptor will be used for subsequent communication with the newly connected client.
     */
    while (1) {
        newsockfd = accept(sockfd, (struct sockaddr *) &cli_addr, &clilen);
        
        if (newsockfd < 0)
            error("ERROR on accept");
        
        bzero(buffer,256);
        n = read(newsockfd,buffer,500); //Read is a block function. It will read at most 500 bytes
        if (n < 0)
            error("ERROR reading from socket");
        printf("%s\n",buffer);
        
        int i;
        directory = strtok(buffer, " ");
        directory = strtok(NULL, " "); //리퀘스트에서 파일이름 추출
        char *dot = strrchr(directory, '.'); 
        if (dot && !strcmp(dot, ".html")){ //확장자 확인 후 content-type 지정 
            strcpy(fileType, "text/html");
        } else if(dot && !strcmp(dot, ".txt")){
            strcpy(fileType, "text/plain");
        } else if((dot && !strcmp(dot, ".jpg")) || (dot && !strcmp(dot, ".jpeg"))){
            strcpy(fileType, "image/jpeg");
        } else if(dot && !strcmp(dot, ".gif")){
            strcpy(fileType, "image/gif");
        } else if(dot && !strcmp(dot, ".mp3")){
            strcpy(fileType, "audio/mpeg");
        } else if(dot && !strcmp(dot, ".pdf")){
            strcpy(fileType, "application/pdf");
        }
        
        directory = strtok(directory, "/"); //파일에서 /를 뗀 후 파일 열기 
        
        if((fp = fopen(directory, "rb")) == NULL){
            return 0;
        }
        
        fseek(fp, 0L, SEEK_END);
        fileSize = ftell(fp); //파일크기를 구함(http response content-length에 사용)
        fseek(fp, 0L, SEEK_SET);
	data = (char*)malloc(sizeof(char)*fileSize); //파일 내용을 저장할 변수에 메모리 할당 
        fileOpenResult = fread(data, 1, fileSize, fp); //파일 내용을 읽어옴 
        
        if(strcmp(fileType, "text/html") == 0){ //파일타입에 따라 헤더를 다르게 만듦 
            char header[100] = "HTTP/1.1 200 OK\r\nContent-Type:text/html\r\nContent-Length:"; //헤더 
            sprintf(temp,"%d",fileSize);
            strcat(header,temp);
            strcat(header,"\r\n\r\n"); //여기까지 헤더를 붙이는 과정 
            int len = strlen(header);
	    response = (char*)calloc(1, sizeof(char)*(len + fileSize)); //헤더 + 데이터를 저장할 변수 메모리 할당 
	    strcpy(response, header); //리스폰스 변수에 헤더를 붙임
	    memcpy(response + len, data, fileSize); //리스폰스 변수에 데이터를 붙임 
            write(newsockfd, response, len + fileOpenResult); //만들어진 response를 클라이언트(브라우저)로 보냄 
	    printf("%s", response);
        } else if(strcmp(fileType,"text/plain") == 0){
            char header[100] = "HTTP/1.1 200 OK\r\nContent-Type:text/plain\r\nContent-Length:";
            sprintf(temp,"%d",fileSize);
            strcat(header,temp);
            strcat(header,"\r\n\r\n");
            int len = strlen(header);
	    response = (char*)calloc(1, sizeof(char)*(len + fileSize));
	    strcpy(response, header);
	    memcpy(response + len, data, fileSize);
	    printf("%s", response);
            write(newsockfd, response, len + fileOpenResult);
	    printf("%s", response);
        } else if(strcmp(fileType,"audio/mpeg") == 0){
            char header[100] = "HTTP/1.1 200 OK\r\nContent-Type:audio/mpeg\r\nContent-Length:";
            sprintf(temp,"%d",fileSize);
            strcat(header,temp);
            strcat(header,"\r\n\r\n");
            int len = strlen(header);
	    response = (char*)calloc(1, sizeof(char)*(len + fileSize));
	    strcpy(response, header);
	    memcpy(response + len, data, fileSize);
            write(newsockfd, response, len + fileOpenResult);
	    printf("%s", response);
        } else if(strcmp(fileType,"image/jpeg") == 0){
            char header[100] = "HTTP/1.1 200 OK\r\nContent-Type:image/jpeg\r\nContent-Length:";
            sprintf(temp,"%d",fileSize);
            strcat(header,temp);
            strcat(header,"\r\n\r\n");
            int len = strlen(header);
	    response = (char*)calloc(1, sizeof(char)*(len + fileSize));
	    strcpy(response, header);
	    memcpy(response + len, data, fileSize);
            write(newsockfd, response, len + fileOpenResult);
	    printf("%s", response);
        } else if(strcmp(fileType,"image/gif") == 0){
            char header[100] = "HTTP/1.1 200 OK\r\nContent-Type:image/gif\r\nContent-Length:";
            sprintf(temp,"%d",fileSize);
            strcat(header,temp);
            strcat(header,"\r\n\r\n");
            int len = strlen(header);
	    response = (char*)calloc(1, sizeof(char)*(len + fileSize));
	    strcpy(response, header);
	    memcpy(response + len, data, fileSize);
            write(newsockfd, response, len + fileOpenResult);
	    printf("%s", response);
        } else if(strcmp(fileType,"application/pdf") == 0){
            char header[100] = "HTTP/1.1 200 OK\r\nContent-Type:application/pdf\r\nContent-Length:";
            sprintf(temp,"%d",fileSize);
            strcat(header,temp);
            strcat(header,"\r\n\r\n");
            int len = strlen(header);
	    response = (char*)calloc(1, sizeof(char)*(len + fileSize));
            strcpy(response, header);
	    memcpy(response + len, data, fileSize);
            write(newsockfd, response, len + fileOpenResult);
	    printf("%s", response);
        }
	free(response);
        free(data);
        close(newsockfd);
        close(fp);
    }
    close(sockfd);
    
    
    return 0;
}
