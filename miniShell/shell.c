#include <stdio.h>
#include <unistd.h>
#include <string.h>
#include <stdlib.h>
#include <dirent.h>
#include <ctype.h> // isspace()
#include <sys/types.h>
#include <sys/stat.h>
#include <fcntl.h>

#define MAXCHARS 1024
#define MASHISTORYS 500
#define MAXARGV 128

void print_prompt(); // print prompt
void commands_string_token(char *command); // tokenize the multiple commands
void change_directory(char *command); // change directory
void see_history(char *command); // see history
char *redirection(char *command); // redirection
void exec_commands(char *command); // execute "execvp"
void multiple_pipe(char *command); // multiple pipe
char *trim(char *s); // remove space
char *ltrim(char *s); // remove left space
char *rtrim(char *s); // remove right space
int number_of_pipe(char *s); // number of pipe

/* variables for using history */

char history[MASHISTORYS][MAXCHARS];
int command_count = 0;

/* variables for using redirection */

int redirection_flag = 0; // 0 : NONE, 1 : '>', 2 : '<', 3 : ">>", 4 : ">!"
char *redirection_token;

/* variable for using background */

int amp; 
int back_count = 0;

int main(){

	char command[MAXCHARS];
	printf("KSH(KeoSeong's Shell)\n");
	while(1){
		print_prompt();
		fgets(command, MAXCHARS, stdin);
		command[strlen(command) - 1] = '\0';
		if (command[0] != '\0') {
			strcat(history[command_count], command);	
			strcat(history[command_count++], "\n");	
			commands_string_token(command);
		}
		else continue; // just enter
	}
	return 0;
}

void print_prompt(){ // print prompt, <KSH> current working directory > 
	char *cwd;
	if((cwd = getcwd(NULL, 0)) == NULL){ // get the current working directory
			perror("getcwd failed");
			exit(1);
	}
	printf("<KSH> %s > ", cwd);
}

void commands_string_token(char *command){
	char *tmp, *re_string;
	char *commands[10]; // number of multiple commands <= 10
	int i = 0, j, status;
	pid_t pid;
	tmp = strtok(command, ";");
	commands[i] = (char *)malloc(strlen(tmp));
	strcpy(commands[i++], tmp);
	while (tmp = strtok(NULL, ";")){
		commands[i] = (char *)malloc(strlen(tmp));
		strcpy(commands[i++], tmp);
	}
	for(j = 0; j < i; j++){
		redirection_flag = 0;
		/* processing to identify 4 redirection operators */
		if (strchr(commands[j], '>') || strchr(commands[j], '<')){
			if (strstr(commands[j], ">>") || strstr(commands[j], ">!")){
				redirection_token = (char *) malloc(2);
				if (strstr(commands[j], ">>")) {redirection_flag = 3; strcpy(redirection_token, ">>");}
				else {redirection_flag = 4; strcpy(redirection_token, ">!");}
			}
			else{
				redirection_token = (char *) malloc(1);
				if (strchr(commands[j], '>')) {redirection_flag = 1; strcpy(redirection_token, ">");}
				else {redirection_flag = 2; strcpy(redirection_token, "<");} 
			}
		}
		if (strstr(commands[j], "exit")) exit(0);
		if (strchr(commands[j], '&')) {amp = 1; strtok(commands[j], "&"); back_count++;}
		else amp = 0;
		change_directory(commands[j]);
		see_history(commands[j]);
		if (!strchr(commands[j], '|')){
			if ((pid = fork()) == 0){
				if (redirection_flag != 0) {re_string = redirection(commands[j]); exec_commands(re_string);}
				else exec_commands(commands[j]);
			}
		
			if (amp == 0){
				waitpid(pid, &status, 0);
				if (back_count != 0) {printf(" [%d]+ Done\n", back_count); back_count = 0;}
			} 
			else printf(" [%d] %d\n", back_count, pid);
		}
		else multiple_pipe(commands[j]);
	}
}

void change_directory(char *command){
	char *cp_command, *tmp, *path;	
	cp_command = (char *)malloc(strlen(command));
	strcpy(cp_command, command);
	tmp = strtok(cp_command, " "); 
	if (!strcmp(tmp, "cd")) { // change directory
            	path = strtok(NULL, " ");
		if (path == NULL){
			path = getenv("HOME");
		}
            	if (chdir(path) < 0){
			printf("KSH: cd: %s: No such Directory\n", path);
    		}
	}
}

void see_history(char *command){
	char *cp_command, *tmp, *number;
	int comp_num, i;
	cp_command = (char *)malloc(strlen(command));
	strcpy(cp_command, command);
	tmp = strtok(cp_command, " ");
	if (!strcmp(tmp, "history")) { // history
            	number = strtok(NULL, " ");	
		if (number == NULL){
			for (i = 0; i < command_count; i++){
				printf(" %d\t%s", i + 1, history[i]);
			}
		}
		else{
			comp_num = atoi(number);
			if (comp_num > 0 && comp_num <= command_count){
				for (i = 0; i < comp_num; i++){
					printf(" %d\t%s", command_count - comp_num + i + 1, history[command_count - comp_num + i]);
				}
			}
			else {
				if (strcmp(number, "0")) printf("KSH: history: %s: invalid value(put the lower number or integer)\n", number);
			}
		}
	}
}

char *redirection(char *command){
	int fd;
	char *cp_command, *left_command, *right_command, *trim_left, *trim_right, *re_argv[MAXARGV];
	cp_command = (char *)malloc(strlen(command));
	strcpy(cp_command, command);
	left_command = strtok(cp_command, redirection_token);
	right_command = strtok(NULL, redirection_token);
	trim_left = rtrim(left_command);
	trim_right = trim(right_command);

	if (redirection_flag == 1){ // ">"
		if ((fd = open(trim_right, O_CREAT|O_WRONLY|O_EXCL, 0644)) < 0) printf("KSH: file already exist\n");
		close(1);
		dup(fd);
		close(fd);	
	} else if (redirection_flag == 2){ // "<"
		if ((fd = open(trim_right, O_RDONLY)) < 0) printf("KSH: file open error\n");
		close(0);
		dup(fd);
		close(fd);
	} else if (redirection_flag == 3){ // ">>"
		if((fd = open(trim_right, O_CREAT|O_WRONLY|O_APPEND, 0644)) < 0) printf("KSH: file open error\n");
		close(1);
		dup(fd);
		close(fd);
	} else { // ">!"
		if((fd = open(trim_right, O_WRONLY|O_TRUNC, 0644)) < 0) printf("KSH: file open error\n");
		close(1);
		dup(fd);
		close(fd);
	}
	return trim_left;
}

void multiple_pipe(char *command){
	char *cp_command, *tmp;
	char *pipe_commands[10];
	int num, i, j = 0;
	int *pid;
	pid = malloc(sizeof(int) * num);
	cp_command = (char *)malloc(strlen(command));
	strcpy(cp_command, command);
	num = number_of_pipe(command);
	int pipefds[num][2];
	tmp = strtok(cp_command, "|");
	pipe_commands[j] = (char *)malloc(strlen(tmp));
	strcpy(pipe_commands[j++], tmp);
	while (tmp = strtok(NULL, "|")){
		pipe_commands[j] = (char *)malloc(strlen(tmp));
		strcpy(pipe_commands[j++], tmp);
	}
	for (i = 0; i < num; i++){
		pipe(pipefds[i]);
		fcntl(pipefds[i][0], F_SETFL, O_NONBLOCK);
		fcntl(pipefds[i][1], F_SETFL, O_NONBLOCK);
	}
	for (i = 0; i < num + 1; i++){
		pid[i] = fork();
		switch (pid[i]){
			case -1:
			{
				perror("fork error");
			}
			case 0:
			{
				if (i == 0){
					close(1);
					dup(pipefds[i][1]);
					close(2);
				}
				else if (i == num){
					close(0);
					dup(pipefds[i - 1][0]);
					close(2);
				}
				else {
					close(0);
					dup(pipefds[i - 1][0]);
					close(1);
					dup(pipefds[i][1]);
					close(2);
				}
				exec_commands(pipe_commands[i]);
			}
			default:
			{
				wait(NULL);
			}
		}
	}
}

void exec_commands(char *command){
	int j, i = 0;
	char *cp_command, *tmp, *argv[MAXARGV];
	cp_command = (char *)malloc(strlen(command));
	strcpy(cp_command, command);
	tmp = strtok(cp_command, " ");
	argv[i] = (char *)malloc(strlen(tmp));
	strcpy(argv[i++], tmp);
	while (tmp = strtok(NULL, " ")){
		argv[i] = (char *)malloc(strlen(tmp));
		strcpy(argv[i++], tmp);
	}
	argv[i] = NULL;
	execvp(argv[0], argv);

}

char *rtrim(char *s) {
	char t[MAXCHARS];
	char *end;

	strcpy(t, s);
	end = t + strlen(t) - 1;
	while (end != t && isspace(*end))
		end--;
	*(end + 1) = '\0';
	s = t;

	return s;
}

char *ltrim(char *s) {
	char *begin;
	begin = s;

	while (*begin != '\0') {
		if (isspace(*begin))
			begin++;
		else {
			s = begin;
			break;
		}
	}

	return s;
}

char *trim(char *s) {
	return rtrim(ltrim(s));
}

int number_of_pipe(char *s){
	int count = 0, i;
	for(i = 0; i < strlen(s); i++){
		if (*(s + i) == '|') count++;	
	}
	return count;
}

