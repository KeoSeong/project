use project;
create table tweets(
				no integer primary key auto_increment not null,
				author varchar(20) not null,
				contents text not null,
				time datetime not null,
				reply integer
);
create table user(
				id varchar(20) primary key not null,
				password text not null,
				comment text,
				school text,
				age integer,
				name text,
				email varchar(40) not null
);
create table problem(
                no integer auto_increment primary key not null,
                type text not null,
                problem text not null,
                answer text not null,
                conf integer not null
);
create table user_problem(
                id varchar(20) not null,
                problem_no integer not null,
                user_ans text not null,
                result integer not null,
                foreign key(id) references user(id),
                foreign key(problem_no) references problem(no)
);
create table feedback(
				id varchar(20) not null,
				feed text
);
