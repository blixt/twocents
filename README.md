# Two Cents: A simple commenting service

## Information

Two Cents is a very simple service that simply lets people add and get comments
for a certain path (arbitrary string).

Used for <http://blixt.org/js>.

## Examples

To add a comment, request:

    twocents.php/put?path="home"&name="blixt"&message="Hello+World!"

To get comments, request:

    twocents.php/get?path="home"

The response could look something like this (indented for readability):

    {
        "status": "success",
        "response": [
            {
                "id": "1",
                "added": "1292162356",
                "name": "blixt",
                "message": "Hello World!"
            }
        ]
    }

## MIT license

This project is licensed under an [MIT license][].

Copyright © 2011 Andreas Blixt (<andreas@blixt.org>)

[MIT license]: http://www.opensource.org/licenses/mit-license.php
