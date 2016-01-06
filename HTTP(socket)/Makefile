OBJECTS = server.o
server : $(OBJECTS)
		gcc -o server server.o
server.o : server.c
		gcc -c server.c
clean :
		rm $(OBJECTS)
