urlShortener
============

Another example of unconventional usage of WordPress posts. Posts are used as link containers for a url shortening service.
When the user inputs a link through the forward facing input box, the link is shortened and the user is given an 8 character
alphanumeric combination. This appended to the end of the base wordpress url will redirect the user to the url.

How it Works
==============
The user inputs their desired URL. WordPress takes that url and makes it the content of a post. A random string is then
generated and made the post title. The plugin hooks into the 'init' event. On each page request, wordpress will check if
the URI exists in one of the shortened url posts. If it does, the original url is retrieved and then the user is redirected
to expected url.

Changelog:
=============
 v0.01 - The most basic form of the plugin. Serves as a proof of concept used during my discussion.
