# rideShare

USAGE:

        To use this application you must first create the following database , grant permission and create the tables described below:
        
        1 - Create a database called rideshare
            create database rideshare; 
            use rideshare;
        
        2 - Give permission to main admin user
            
            grant all on rideshare.* to dbuser@localhost identified by "goodbyeWorld";
        
        3- Create the tables:
            
            create table users (
                                    name varchar(50),
                                    email varchar(100) primary key,
                                    username varchar(60),
                                    password varchar(60),
                                    phone int,
                                    address varchar(100),
                                    avatar blob,
                                    isdriver varchar(3),
                                    carmodel varchar(30),
                                    drivingexp int
                                );
            
            create table drivers (
                                    id int primary key AUTO_INCREMENT,
                                    email varchar(100),
                                    origin varchar(100),
                                    latitude_o double,
                                    longitude_o double,
                                    destination varchar(100),
                                    latitude_d double,
                                    longitude_d double,
                                    start_time datetime,
                                    end_time datetime,
                                    size int
                                );
                                    
            create table riders(
                                    id int primary key AUTO_INCREMENT,
                                    email varchar(100),
                                    origin varchar(100),
                                    destination varchar(100),
                                    start_time datetime,
                                    driver int
                                );
                                
        4 - Update the below variables in /db/dbLogin.php:

            1) $host - host address
            2) $user - database username
            3) $password - password associated with the username
            4) $database - database name (rideshare)

