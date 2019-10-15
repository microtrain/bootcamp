# User Request and Server Response

Every web page is created by a server responding to a user request. The user makes a request, the server processes that request and creates a response. That response is most commonly in the form of an HTML document. The server can create this response using any document type it chooses (providing it has the ability to do so). This is a simplistic but accurate view of an IPO (input, process, output) model. In practice, this process may be repeated multiple times as a user loads or interacting with a single web page.

![Simple Example](../img/ipo/simple.png)

Let's replace the word user with the word client. In this example, we will use *end-user* to represent a human actor and *client* to represent software (in this case the browser). An end-user opens a web browser (the client) and enters www.youtube.com into the address bar and presses [ENTER]. At this point, the client (browser) makes a request with no parameters to the server at www.youtube.com the server sees there are no parameters, processes the response and returns the YouTube homepage as an HTML document. This only returns an HTML document that describes the layout of the page. There are no images, no videos, no styles, no colors, no javascript, no CSS, no special fonts, and so on; these are all additional requests made by the client. The HTML document contains special references that when interpreted by the client (in this case a web browser) provide instructions for that client to  (on behalf of the end-user) make a request to a server. Each additional request is processed by a server which in turn creates a response and serves that response to the client. These responses are not typically HTML documents, rather these tend to by images, videos, stylesheets, javascript files, etc.

![Simple Example](../img/ipo/less_simple.png)

In summary, a basic web page is served as follows

* A client makes a server request.
* That server processes the user request and returns an HTML document.
* The client processes that HTML document and makes additional requests as instructed by the document.
    * Each of these requests is processed by a server.
    * Each of these servers creates a response and serves it to the client accordingly.
    * The client processes each of these responses and processes the instruction sets accordingly.
        * These may or may not lead to additional server requests.

## Summary
In this section, we covered how a user-request leads to a server-response.


[Next: HTML](/05-HTML/README.md)
