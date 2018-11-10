/* In computing, a shell is a user interface for access to an operating system's services. 
Shell basic purposes:
	1) Initialize: read and execute its configuration file;
	2) Interpret: read and execute commands form stdin;
	3) Terminate: execute shutdown commands and terminate. */

#include <sys/wait.h> //waitpid()
#include <unistd.h> //chdir(), fork(), exec(), pid_t
#include <stdlib.h> //malloc(), realloc(), free(), exit(), execvp(), EXIT_SUCCESS, EXIT_FAILURE
#include <stdio.h> //fprintf(), printf(), stderr, getchar(), perror()
#include <string.h> //strcmp(), strtok()

//declaration of functions for built-in shell commands: cd (change directory), help, and exit
int lsh_cd(char **args);
int lsh_help(char **args);
int lsh_exit(char **args);

 //list of built-in commands

 char *builtin_str[] = {
 	"cd",
 	"help",
 	"exit"
 };

 int (*builtin_func[]) (char **) = {
 	&lsh_cd,
 	&lsh_help,
 	&lsh_exit
 };

 int lsh_num_builtins() {
 	return sizeof(builtin_str) / sizeof(char *);
 }

  //implementation of built-in functions

 int lsh_cd(char **args) { //change directory function
 	if (args[1] == NULL) {
 		fprintf(stderr, "lsh: exptected argument to \"cd\"\n");
 	} else {
 		if (chdir(args[1]) != 0) {
 			perror("lsh");
 		}
 	}
 	return 1;
 }

int lsh_help(char **args) { //help function
	int i;
	printf("Gustavo Euclides' LSH\n");
	printf("Type program names, arguments and hit enter.\n");
	printf("The following are built in: \n");

	for (i = 0; i < lsh_num_builtins(); i++) {
		printf(" %s\n", builtin_str[i]);
	}
	printf("Use the man command for information on other programs.\n");
	return 1;
}

int lsh_exit(char **args) { //exit function
	return 0;
}

int lsh_launch(char **args) {
	pid_t pid, wpid; //pid_t = data type that represents the ID of a certain process
	int status;

	pid = fork(); //when a process is started, an existing process duplicates itself creating a child process, or 'fork()'
	if (pid == 0) { //child process, the user command is executed here
		if (execvp(args[0], args) == -1) {
			perror("lsh");
		}
		exit(EXIT_FAILURE); //error forking
	} else if (pid < 0) {
		perror("lsh");
	} else {

		do { //parent process
			wpid = waitpid(pid, &status, WUNTRACED); //waitpid() waits the status of a process, in this case, the child process executing the user's command
		} while (!WIFEXITED(status) && !WIFSIGNALED(status)); 
	}
	return 1; //done executing user's command
}

int lsh_execute(char **args) { //launches the process
	int i;
	if (args[0] == NULL) {
		//empty command
		return 1;
	}

	for (i = 0; i < lsh_num_builtins(); i++) {
		if (strcmp(args[0], builtin_str[i]) == 0) { //strcmp() = function to compare strings
			return (*builtin_func[i])(args);
		}
	}
	return lsh_launch(args);
}

#define LSH_RL_BUFSIZE 1024
char *lsh_read_line(void) { //read the command lines from user (stdin)
	int bufsize = LSH_RL_BUFSIZE;
	int position = 0;
	char *buffer = malloc(sizeof(char) * bufsize); //malloc (memory allocation) = função para alocação dinâmica da memória
	int c;

	if (!buffer) {
		fprintf(stderr, "lsh: allocation error\n");
		exit(EXIT_FAILURE);
	}

	while (1) {
		c = getchar();

		if (c == EOF || c == '\n') { //EOF = int, então 'c' deve ser int para testar se é EOF
			buffer[position] = '\0'; 
			return buffer;
		} else {
			buffer[position] = c;
		}
		position++;

		if (position >= bufsize) {
			bufsize += LSH_RL_BUFSIZE;
			buffer = realloc(buffer, bufsize); //realloc = função que realoca memŕia
			if (!buffer) {
				fprintf(stderr, "lsh: allocation error\n");
				exit(EXIT_FAILURE);
			}
		}
	}
}

#define LSH_TOK_BUFSIZE 64
#define LSH_TOK_DELIM "\t\r\n\a"
char **lsh_split_line(char *line) { //split lines into different commands (args). Commands are separated by whitespaces.
	int bufsize = LSH_TOK_BUFSIZE, position = 0;
	char **tokens = malloc(bufsize * sizeof(char*));
	char *token;

	if (!tokens) {
		fprintf(stderr, "lsh: allocation error\n");
		exit(EXIT_FAILURE);
	}

	token = strtok(line, LSH_TOK_DELIM);
	while (token != NULL) {
		tokens[position] = token; //after commands are split they are stored seperately in the array 'tokens' to be executed.
		position++;

		if (position >= bufsize) {
			bufsize += LSH_TOK_BUFSIZE;
			tokens = realloc(tokens, bufsize * sizeof(char*));
			if (!tokens) {
				fprintf(stderr, "lsh: allocation error\n");
				exit(EXIT_FAILURE);
			}
		}
		token = strtok(NULL, LSH_TOK_DELIM);	
	}
	tokens[position] = NULL;
	return tokens;
}

void lsh_loop(void) {
	char *line;
	char **args;
	int status;

	do {
		printf("> ");
		line = lsh_read_line(); //read the command lines from user (stdin)
		args = lsh_split_line(line); //split lines into different commands (args)
		status = lsh_execute(args); //execute commands (args): commands will be either process requested by user or a built-in function (cd, help, exit)

		free(line);
		free(args);
	} while (status);
}

int main(int argc, char **argv) {
	//initialize

	lsh_loop(); //interpret

	//terminate

	return EXIT_SUCCESS;
}




















