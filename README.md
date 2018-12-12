# RestAPI-RawPHP
An attempt to build Rest API with raw PHP

I've been asked by a company that sends cakes by email to write an app RESTful API to manage a TodoList. 
Much remains to be done but the logic is there. 

Currently to Read/Create a TODo list is working fine. Tested it on Postman.

Example POST request:
```
POST localhost:1051/todo with JSON block
{
    "data": {
        "name": "Weekend Shopping List"
    }
}
```
Example GET request:

```
GET localhost:1051/todo
{
    "message": [
        {
            "id": "1",
            "name": "Weekend Shopping List"
        }
    ]
}```
