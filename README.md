# Microservices with Symfony
This project is a simple implementation of a microservice architecture using Symfony and RabbitMQ. It consists of two applications: "app-backend" and "app-front". The "app-backend" is responsible for handling the database and message queue, while the "app-front" acts as the API for the client to interact with the service. The "Common" directory contains shared files between the two applications.

To run the project, please follow these steps:

- Clone the repository
- Run ```docker-compose up --build -d``` to start the containers
- Run ```symfony server:start``` in both the "app-front" and "app-backend" containers to start the web server
- Run migrations in the "app-backend" container to set up the database
------

- To test the "app-front" application:

- Send a POST request to http://yourlocalip:8000/books with the following header: ```X-AUTH-TOKEN: user_hard_coded_token```
- In the body of the request, include the following JSON data as an example:
```
{
    "title": "The Book of Tale",
    "author": "Taleh A",
    "pages" : 999,
    "releaseDate": "2033-10-10"
}
```
Send a GET request to http://yourlocalip:8000/books to retrieve a list of books stored in the database.
Please note that the IP address used in the examples above should be replaced with the IP address of the host machine running the containers.
